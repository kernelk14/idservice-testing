<?php

namespace App\Controllers;

class GoogleAuth extends BaseController
{
    public function login()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('google_login');
    }

    public function auth()
    {
        $clientId     = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri  = base_url('google-callback');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->to('/user/login')->with('error', 'Google OAuth is not configured.');
        }

        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri'  => $redirectUri,
        ]);

        $authUrl = $provider->getAuthorizationUrl([
            'scope' => ['openid', 'email', 'profile'],
        ]);

        session()->set('oauth2state', $provider->getState());

        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $clientId     = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri  = base_url('google-callback');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->to('/user/login')->with('error', 'Google OAuth is not configured.');
        }

        $state = $this->request->getGet('state');
        $storedState = session()->get('oauth2state');

        if (empty($state) || $state !== $storedState) {
            session()->remove('oauth2state');
            return redirect()->to('/user/login')->with('error', 'Invalid state parameter.');
        }

        session()->remove('oauth2state');

        $code = $this->request->getGet('code');
        if (empty($code)) {
            return redirect()->to('/user/login')->with('error', 'Authorization code not provided.');
        }

        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri'  => $redirectUri,
        ]);

        try {
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);
            $ownerDetails = $provider->getResourceOwner($token);

            $googleEmail = $ownerDetails->getEmail();
            $googleName  = $ownerDetails->getName();
        } catch (\Exception $e) {
            return redirect()->to('/user/login')->with('error', 'Failed to authenticate with Google: ' . $e->getMessage());
        }

        if (empty($googleEmail)) {
            return redirect()->to('/user/login')->with('error', 'Could not retrieve email from Google.');
        }

        $db = db_connect();

        $identity = $db->table('auth_identities')
            ->where('secret', $googleEmail)
            ->where('type', 'email_password')
            ->get()
            ->getRowArray();

        if ($identity) {
            $user = $db->table('users')->where('id', $identity['user_id'])->get()->getRowArray();
            if ($user) {
                auth()->loginById($user['id']);
                return redirect()->to('/')->withCookies();
            }
        }

        $username = $this->generateUsername($googleEmail);
        $db->table('users')->insert([
            'username' => $username,
            'active'   => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $newUserId = $db->insertID();

        $db->table('auth_identities')->insert([
            'user_id'    => $newUserId,
            'type'       => 'email_password',
            'secret'     => $googleEmail,
            'secret2'    => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        auth()->loginById($newUserId);
        return redirect()->to('/')->withCookies();
    }

    private function generateUsername(string $email): string
    {
        $base = strstr($email, '@', true);
        $base = preg_replace('/[^a-zA-Z0-9.]/', '', $base);

        if (strlen($base) > 25) {
            $base = substr($base, 0, 25);
        }

        $db = db_connect();
        $username = $base;
        $i = 1;
        while ($db->table('users')->where('username', $username)->countAllResults() > 0) {
            $suffix = (string) $i;
            $username = substr($base, 0, 30 - strlen($suffix)) . $suffix;
            $i++;
        }

        return $username;
    }
}

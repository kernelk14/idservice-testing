<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class AdminLogin extends BaseController
{
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('admin_login');
    }

    public function loginAction(): RedirectResponse
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username and password are required.');
        }

        $db = db_connect();

        $user = $db->table('users')->where('LOWER(username)', strtolower($username))->get()->getRowArray();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        $identity = $db->table('auth_identities')
            ->where('user_id', $user['id'])
            ->where('type', 'email_password')
            ->get()
            ->getRowArray();

        if (!$identity) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        $result = auth('session')->attempt([
            'username' => $username,
            'password' => $password,
        ]);

        if (!$result->isOK()) {
            return redirect()->back()->withInput()->with('error', $result->reason());
        }

        $authenticator = auth('session')->getAuthenticator();
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    public function logoutAction(): RedirectResponse
    {
        auth()->logout();

        return redirect()->to('/admin/login')->with('message', 'Logged out successfully.');
    }
}

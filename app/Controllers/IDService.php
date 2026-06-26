<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\IDModel;
use App\Models\ProcessingModel;
use App\Models\ProcessedModel;
 
class IDService extends BaseController
{
    
    public function index()
    {
        $db = db_connect();
        $data['users'] = $db->table('id_users')
            ->select('id_users.*')
            ->join('processing', 'processing.userId = id_users.userId', 'left')
            ->where('processing.userId', null)
            ->get()
            ->getResultArray();

        return view('users', $data);
    }

    public function create()
    {
        $db = db_connect();
        $existing = $db->table('id_users')
            ->where('auth_user_id', auth()->id())
            ->first();

        if ($existing) {
            return redirect()->to('/user/success')
                ->with('message', 'You have already submitted an ID request.');
        }

        return view('create');
    }

    public function success() 
    {
        return view('user_success');
    }

    public function store() {
        $idModel = new IDModel();

        $file = $this->request->getFile('attach_id');

        if (!$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Upload failed');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->withInput()->with('error', 'Only JPG, PNG, GIF allowed');
        }

        if ($file->getSize() > 2097152) {
            return redirect()->back()->withInput()->with('error', 'File too large (max 2MB)');
        }

        $fileName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $fileName);

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'contact_num' => $this->request->getPost('contact_num'),
            'address' => $this->request->getPost('address'),
            'emergency_person' => $this->request->getPost('emergency_person'),
            'emergency_number' => $this->request->getPost('emergency_number'),
            'attach_id' => $fileName,
            'auth_user_id' => auth()->id(),
        ];

        $idModel->insert($data);
        return redirect()->to('/user/success')->with('message', 'ID request submitted successfully.');
    }

    public function addToProcessing()
    {
        $userIds = $this->request->getPost('userIds');

        if (empty($userIds)) {
            return redirect()->to('/requests')->with('error', 'No users selected.');
        }

        $processingModel = new ProcessingModel();
        $userId = auth()->id();

        foreach ($userIds as $uid) {
            $existing = $processingModel->where('userId', $uid)->first();
            if (!$existing) {
                $processingModel->insert(['userId' => $uid, 'processed_by' => $userId]);
            }
        }

        return redirect()->to('/requests/process')->with('message', 'Users added to processing.');
    }

    public function showProcess()
    {
        $db = db_connect();
        $users = $db->table('processing')
            ->select('processing.*, id_users.name, id_users.email, id_users.contact_num, id_users.address, id_users.emergency_person, id_users.emergency_number, id_users.attach_id')
            ->join('id_users', 'id_users.userId = processing.userId')
            ->get()
            ->getResultArray();

        return view('process', ['users' => $users]);
    }

    public function generatePdf()
    {
        $db = db_connect();
        $processingRecords = $db->table('processing')
            ->select('processing.*, id_users.name, id_users.email, id_users.contact_num, id_users.address, id_users.emergency_person, id_users.emergency_number, id_users.attach_id')
            ->join('id_users', 'id_users.userId = processing.userId')
            ->get()
            ->getResultArray();

        if (empty($processingRecords)) {
            return redirect()->to('/requests')->with('error', 'Nothing to process.');
        }

        $tempDir = WRITEPATH . 'temp';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        if (count($processingRecords) === 1) {
            $user = $processingRecords[0];
            $html = view('id_card', ['user' => $user]);
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();

            $filename = 'ID_' . $user['userId'] . '_' . str_replace(' ', '_', $user['name']) . '.pdf';
            $filepath = $tempDir . '/' . $filename;
            file_put_contents($filepath, $dompdf->output());

            $db->table('processed')->insert(['userId' => $user['userId'], 'processed_by' => $user['processed_by']]);
            $db->table('processing')->where('userId', $user['userId'])->delete();

            $download = $this->response->download($filepath, null)->setFileName($filename);
            register_shutdown_function(function () use ($filepath) {
                if (is_file($filepath)) unlink($filepath);
            });
            return $download;
        }

        $pdfPaths = [];

        foreach ($processingRecords as $user) {
            $html = view('id_card', ['user' => $user]);
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->render();

            $filename = 'ID_' . $user['userId'] . '_' . str_replace(' ', '_', $user['name']) . '.pdf';
            $filepath = $tempDir . '/' . $filename;
            file_put_contents($filepath, $dompdf->output());
            $pdfPaths[] = $filepath;
        }

        $zip = new \ZipArchive();
        $zipPath = $tempDir . '/ID_Cards_' . time() . '.zip';
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($pdfPaths as $path) {
                $zip->addFile($path, basename($path));
            }
            $zip->close();
        }

        foreach ($processingRecords as $user) {
            $db->table('processed')->insert(['userId' => $user['userId'], 'processed_by' => $user['processed_by']]);
            $db->table('processing')->where('userId', $user['userId'])->delete();
        }

        foreach ($pdfPaths as $path) {
            unlink($path);
        }

        $download = $this->response->download($zipPath, null)->setFileName('ID_Cards.zip');
        register_shutdown_function(function () use ($zipPath) {
            if (is_file($zipPath)) unlink($zipPath);
        });
        return $download;
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        // STEP 1: Check kung logged in na (Layer 1 Check)
        if (session()->has('user')) {
            $role = session('user')['role'];
            return $this->redirectBasedOnRole($role);
        }

        // Pakita ang login view kung walang pino-post
        if (!$this->validate(['inputEmail' => 'required'])) {
            return view('pages/commons/login');
        }

        $email = $this->request->getVar('inputEmail');
        $password = $this->request->getVar('inputPassword');

        // STEP 2: JOIN roles table para makuha ang role_name
        $user = $this->ApplicationModel->db->table('users')
            ->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role')
            ->where('users.email', $email)
            ->get()
            ->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            
            // CRITICAL: Ang session key ay dapat 'user' at ang loob ay may 'role'
            session()->set([
                'user' => [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role_name'], // Ito yung 'admin', 'teacher', o 'student'
                ],
                'isLoggedIn' => true
            ]);

            return $this->redirectBasedOnRole($user['role_name']);

        } else {
            session()->setFlashdata('notif_error', 'Your ID or Password is Wrong!');
            return redirect()->to(base_url('login'));
        }
    }

    // STEP 2.3: Redirect logic base sa match($role) ng documentation mo
    private function redirectBasedOnRole($role)
    {
        return match($role) {
            'admin'   => redirect()->to(base_url('dashboard')),
            'teacher' => redirect()->to(base_url('dashboard')),
            'student' => redirect()->to(base_url('student/dashboard')),
            default   => redirect()->to(base_url('login')),
        };
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    // Para sa Step 6: Unauthorized Page
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
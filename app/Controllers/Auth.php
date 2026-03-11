<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        // 2.3: Redirect logged-in users to dashboard
        if (session()->get('isLoggedIn') == TRUE) {
            return redirect()->to(base_url('dashboard'));
        }

        // 2.2: Login View validation
        if (!$this->validate(['inputEmail' => 'required'])) {
            return view('pages/commons/login');
        } else {
            $inputEmail    = htmlspecialchars($this->request->getVar('inputEmail', FILTER_UNSAFE_RAW));
            $inputPassword = htmlspecialchars($this->request->getVar('inputPassword', FILTER_UNSAFE_RAW));
            
            // Kunin ang user base sa email
            $user = $this->ApplicationModel->getUser($inputEmail);

            if ($user) {
                // 2.2: password_verify() to check the hash
                if (password_verify($inputPassword, $user['password'])) {
                    session()->set([
                        'user' => [
                            'id'    => $user['userID'],
                            'name'  => $user['name'],
                            'email' => $user['email'],
                            'role'  => $user['role']
                        ],
                        'username'   => $user['name'],
                        'email'      => $user['email'],
                        'role'       => $user['role'],
                        'isLoggedIn' => TRUE
                    ]);
                    return redirect()->to(base_url('dashboard'));
                } else {
                    // Generic error message for security (Part 2.2 failure requirement)
                    session()->setFlashdata('notif_error', 'Your ID or Password is Wrong!');
                    return redirect()->to(base_url('login'));
                }
            } else {
                session()->setFlashdata('notif_error', 'Your ID or Password is Wrong!');
                return redirect()->to(base_url('login'));
            }
        }
    }

    public function logout()
    {
        // 2.2: Destroy session and redirect to login
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        return view('pages/commons/register');
    }

    public function registration()
    {
        // 2.1 Server-side validation
        $rules = [
            'inputFullname'  => 'required|min_length[3]',
            'inputEmail'     => 'required|valid_email|is_unique[users.email]', // Unique email check
            'inputPassword'  => 'required|min_length[6]',
            'inputPassword2' => 'matches[inputPassword]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('notif_error', 'Check your inputs: Password must match and Email must be unique.');
            return redirect()->back()->withInput();
        } else {
            // Kunin ang raw inputs
            $inputFullname = $this->request->getVar('inputFullname');
            $inputEmail    = $this->request->getVar('inputEmail');
            $inputPassword = $this->request->getVar('inputPassword');

            // DAPAT TUMUGMA ITO SA COLUMN NAMES NG DATABASE MO
            $dataUser = [
                'name'       => $inputFullname, // Mula 'inputFullname' -> 'name'
                'email'      => $inputEmail,    // Mula 'inputUsername' -> 'email'
                'password'   => password_hash($inputPassword, PASSWORD_BCRYPT), // Requirement 2.1
                'role'       => 1,              // Base sa structure mo kanina
                'created_at' => date('Y-m-d H:i:s'), // Requirement 1.2
            ];

            $this->ApplicationModel->createUser($dataUser);
            session()->setFlashdata('notif_success', '<b>Registration Successfully!</b> Please login.');
            return redirect()->to(base_url('login'));
        
        }
    }
}
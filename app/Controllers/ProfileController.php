<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ProfileController extends BaseController
{
    public function show()
    {
        $userId = session()->get('user')['id'];
        $userModel = new UserModel();
        
        $user = $userModel->find($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('profile/show', array_merge($this->data, ['user' => $user]));
    }

    public function edit()
    {
        $userId = session()->get('user')['id'];
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return view('profile/edit', array_merge($this->data, ['user' => $user]));
    }

    public function update()
    {
        // 1. Get logged-in user ID and fetch current record
        $userId = session()->get('user')['id'];
        $userModel = new UserModel();
        $currentUser = $userModel->find($userId);

        if (!$currentUser) {
            session()->destroy();
            return redirect()->to('/login');
        }
        
        // 2. Server-side validation
        $rules = [
            'name'       => 'required|min_length[3]|max_length[255]',
            'email'      => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'student_id' => 'permit_empty|max_length[20]',
            'course'     => 'permit_empty|max_length[100]',
            'year_level' => 'permit_empty|integer|in_list[1,2,3,4,5]',
            'section'    => 'permit_empty|max_length[50]',
            'phone'      => 'permit_empty|max_length[20]',
            'address'    => 'permit_empty|max_length[500]',
        ];

        // 3. If validation fails, redirect back
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare update data
        $updateData = [
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'student_id' => $this->request->getPost('student_id'),
            'course'     => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level'),
            'section'    => $this->request->getPost('section'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
        ];
        
        // 4. Handle image upload
        $file = $this->request->getFile('profile_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate image
            $validationRule = [
                'profile_image' => [
                    'rules' => 'uploaded[profile_image]|is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[profile_image,2048]',
                ],
            ];

            if ($this->validate($validationRule)) {
                // Delete old image if exists
                if (!empty($currentUser['profile_image'])) {
                    $oldImagePath = FCPATH . 'uploads/profiles/' . $currentUser['profile_image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Generate unique filename
                $ext = $file->getExtension();
                $newName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                
                // Create directory if not exists
                $uploadPath = FCPATH . 'uploads/profiles/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Move file
                $file->move($uploadPath, $newName);
                $updateData['profile_image'] = $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid image file. Only JPG, PNG, WEBP allowed (max 2MB)');
            }
        }

        // 6. Update database
        $userModel->updateProfile($userId, $updateData);
        
        // 7. Update session
        $updatedUser = $userModel->find($userId);
        session()->set('user', $updatedUser);

        // 8. Redirect with success message
        return redirect()->to('/profile')->with('success', 'Profile updated successfully!');
    }
}
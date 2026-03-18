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
        $userId = session()->get('user')['id'];
        $userModel = new UserModel();
        $currentUser = $userModel->find($userId);
        $role = session()->get('user')['role'];

        if (!$currentUser) {
            session()->destroy();
            return redirect()->to('/login');
        }

        $rules = [
            'name'  => 'required|min_length[3]|max_length[255]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if ($role === 'student') {
            $rules += [
                'student_id' => 'permit_empty|max_length[20]',
                'course'     => 'permit_empty|max_length[100]',
                'year_level' => 'permit_empty|integer|in_list[1,2,3,4,5]',
                'section'    => 'permit_empty|max_length[50]',
                'phone'      => 'permit_empty|max_length[20]',
                'address'    => 'permit_empty|max_length[500]',
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($role === 'student') {
            $updateData += [
                'student_id' => $this->request->getPost('student_id'),
                'course'     => $this->request->getPost('course'),
                'year_level' => $this->request->getPost('year_level') ?: null,
                'section'    => $this->request->getPost('section'),
                'phone'      => $this->request->getPost('phone'),
                'address'    => $this->request->getPost('address'),
            ];
        }

        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!$this->validate(['profile_image' => 'is_image[profile_image]|mime_in[profile_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[profile_image,2048]'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid image. Only JPG, PNG, WEBP allowed (max 2MB)');
            }
            if (!empty($currentUser['profile_image'])) {
                $old = FCPATH . 'uploads/profiles/' . $currentUser['profile_image'];
                if (file_exists($old)) unlink($old);
            }
            $uploadPath = FCPATH . 'uploads/profiles/';
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            $newName = 'avatar_' . $userId . '_' . time() . '.' . $file->getExtension();
            $file->move($uploadPath, $newName);
            $updateData['profile_image'] = $newName;
        }

        $userModel->updateProfile($userId, $updateData);
        $updatedUser = $userModel->find($userId);
        session()->set('user', array_merge(session()->get('user'), $updatedUser));

        return redirect()->to('/profile')->with('success', 'Profile updated successfully!');
    }
}
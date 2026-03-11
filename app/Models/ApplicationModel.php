<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    // ==========================================================
    // PART 1 & 2: AUTHENTICATION & USER MANAGEMENT
    // ==========================================================

    public function getUser($email = false, $userID = false)
    {
        if ($email) {
            return $this->db->table('users')
                ->select('*, users.id AS userID, user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['email' => $email]) 
                ->get()->getRowArray();
        } elseif ($userID) {
            return $this->db->table('users')
                ->select('*, users.id AS userID, user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['users.id' => $userID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('users')
                ->select('*, users.id AS userID, user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->get()->getResultArray();
        }
    }

    /**
     * Requirement 2.1: Create a new user with hashed password
     */
    public function createUser($dataUser)
    {
        return $this->db->table('users')->insert([
            'name'       => $dataUser['name'],       // Requirement 1.2
            'email'      => $dataUser['email'],      // Requirement 1.2
            'password'   => $dataUser['password'],   // Hashed via Controller
            'role'       => $dataUser['role'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function updateUser($dataUser)
    {
        if (!empty($dataUser['password'])) {
            $password = password_hash($dataUser['password'], PASSWORD_BCRYPT);
        } else {
            $user     = $this->getUser(userID: $dataUser['userID']);
            $password = $user['password'];
        }

        return $this->db->table('users')->update([
            'name'     => $dataUser['name'],
            'email'    => $dataUser['email'],
            'password' => $password,
            'role'     => $dataUser['role'],
        ], ['id' => $dataUser['userID']]);
    }

    public function deleteUser($userID)
    {
        return $this->db->table('users')->delete(['id' => $userID]);
    }

    // ==========================================================
    // PART 3: CRUD OPERATIONS FOR RECORDS (Exam Requirement)
    // ==========================================================

    public function getAllRecords()
    {
        return $this->db->table('records')->get()->getResultArray();
    }

    public function getRecordById($id)
    {
        return $this->db->table('records')->where('id', $id)->get()->getRowArray();
    }

    public function insertRecord($data)
    {
        return $this->db->table('records')->insert([
            'title'       => $data['title'],
            'description' => $data['description'],
            'category'    => $data['category'],
            'status'      => $data['status'],
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }

    public function updateRecord($id, $data)
    {
        return $this->db->table('records')->where('id', $id)->update([
            'title'       => $data['title'],
            'description' => $data['description'],
            'category'    => $data['category'],
            'status'      => $data['status'],
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }

    public function deleteRecord($id)
    {
        return $this->db->table('records')->where('id', $id)->delete();
    }

    // ==========================================================
    // PART 4: MENU & ACCESS CONTROL
    // ==========================================================

    public function getAccessMenuCategory($role)
    {
        return $this->db->table('user_menu_category')
            ->select('*,user_menu_category.id AS menuCategoryID')
            ->join('user_access', 'user_menu_category.id = user_access.menu_category_id')
            ->where(['user_access.role_id' => $role])
            ->get()->getResultArray();
    }

    public function getAccessMenu($role)
    {
        return $this->db->table('user_menu')
            ->join('user_access', 'user_menu.id = user_access.menu_id')
            ->where(['user_access.role_id' => $role])
            ->get()->getResultArray();
    }

    public function getMenuCategory($menuCategoryID = false)
    {
        if ($menuCategoryID) {
            return $this->db->table('user_menu_category')->where(['id' => $menuCategoryID])->get()->getRowArray();
        }
        return $this->db->table('user_menu_category')->get()->getResultArray();
    }

    public function getMenu($menuID = false)
    {
        if ($menuID) {
            return $this->db->table('user_menu')
                ->select('*,user_menu_category.menu_category AS category,user_menu.menu_category AS menu_category_id,user_menu.id AS menu_id')
                ->join('user_menu_category', 'user_menu.menu_category = user_menu_category.id')
                ->where(['user_menu.id' => $menuID])
                ->get()->getRowArray();
        }
        return $this->db->table('user_menu')
            ->select('*,user_menu_category.menu_category AS category,user_menu.menu_category AS menu_category_id,user_menu.id AS menu_id')
            ->join('user_menu_category', 'user_menu.menu_category = user_menu_category.id')
            ->get()->getResultArray();
    }

    public function getUserRole($role = false)
    {
        if ($role) {
            return $this->db->table('user_role')->where(['id' => $role])->get()->getRowArray();
        }
        return $this->db->table('user_role')->get()->getResultArray();
    }

    public function getMenuByUrl($url)
    {
        return $this->db->table('user_menu')
            ->where('url', $url)
            ->get()->getRowArray();
    }

    public function checkUserAccess($data)
    {
        return $this->db->table('user_access')
            ->where([
                'role_id' => $data['roleID'],
                'menu_id' => $data['menuID']
            ])
            ->get()->getRowArray();
    }
}
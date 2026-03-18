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
                ->select('users.*, users.id AS userID, roles.id AS role_id, roles.name AS role_name')
                ->join('roles', 'users.role = roles.id', 'left')
                ->where(['email' => $email])
                ->get()->getRowArray();
        } elseif ($userID) {
            return $this->db->table('users')
                ->select('users.*, users.id AS userID, roles.id AS role_id, roles.name AS role_name')
                ->join('roles', 'users.role = roles.id', 'left')
                ->where(['users.id' => $userID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('users')
                ->select('users.*, users.id AS userID, roles.id AS role_id, roles.name AS role_name')
                ->join('roles', 'users.role = roles.id', 'left')
                ->get()->getResultArray();
        }
    }

    /**
     * Requirement 2.1: Create a new user with hashed password
     */
    public function createUser($dataUser)
    {
        return $this->db->table('users')->insert([
            'name'       => $dataUser['name'],
            'email'      => $dataUser['email'],
            'password'   => $dataUser['password'],
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
            return $this->db->table('roles')->where(['id' => $role])->get()->getRowArray();
        }
        return $this->db->table('roles')->get()->getResultArray();
    }

    public function getSubmenu($submenuID = false)
    {
        if ($submenuID) {
            return $this->db->table('user_submenu')
                ->select('user_submenu.*, user_menu.title AS menu_title, user_menu_category.menu_category')
                ->join('user_menu', 'user_submenu.menu_id = user_menu.id', 'left')
                ->join('user_menu_category', 'user_menu.menu_category = user_menu_category.id', 'left')
                ->where('user_submenu.id', $submenuID)
                ->get()->getRowArray();
        }
        return $this->db->table('user_submenu')
            ->select('user_submenu.*, user_menu.title AS menu_title, user_menu_category.menu_category')
            ->join('user_menu', 'user_submenu.menu_id = user_menu.id', 'left')
            ->join('user_menu_category', 'user_menu.menu_category = user_menu_category.id', 'left')
            ->get()->getResultArray();
    }

    public function createRole($data)
    {
        return $this->db->table('roles')->insert([
            'name'  => url_title(strtolower($data['inputRoleName']), '-', true),
            'label' => $data['inputRoleName'],
        ]);
    }

    public function updateRole($data)
    {
        return $this->db->table('roles')->update([
            'label' => $data['inputRoleName'],
        ], ['id' => $data['roleID']]);
    }

    public function deleteRole($roleID)
    {
        return $this->db->table('roles')->delete(['id' => $roleID]);
    }

    public function createMenuCategory($data)
    {
        return $this->db->table('user_menu_category')->insert([
            'menu_category' => $data['inputMenuCategory'],
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    public function updateMenuCategory($data)
    {
        return $this->db->table('user_menu_category')->update([
            'menu_category' => $data['inputMenuCategory'],
            'updated_at'    => date('Y-m-d H:i:s'),
        ], ['id' => $data['menuCategoryID']]);
    }

    public function createMenu($data)
    {
        return $this->db->table('user_menu')->insert([
            'menu_category' => $data['inputMenuCategory2'],
            'title'         => $data['inputMenuTitle'],
            'url'           => $data['inputMenuURL'],
            'icon'          => $data['inputMenuIcon'] ?? null,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    public function createSubMenu($data)
    {
        return $this->db->table('user_submenu')->insert([
            'menu_id'    => $data['inputMenu'],
            'title'      => $data['inputSubmenuTitle'],
            'url'        => $data['inputSubmenuURL'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function checkUserMenuCategoryAccess($data)
    {
        return $this->db->table('user_access')
            ->where(['role_id' => $data['roleID'], 'menu_category_id' => $data['menuCategoryID']])
            ->countAllResults();
    }

    public function insertMenuCategoryPermission($data)
    {
        return $this->db->table('user_access')->insert([
            'role_id' => $data['roleID'], 'menu_category_id' => $data['menuCategoryID']
        ]);
    }

    public function deleteMenuCategoryPermission($data)
    {
        return $this->db->table('user_access')
            ->where(['role_id' => $data['roleID'], 'menu_category_id' => $data['menuCategoryID']])
            ->delete();
    }

    public function insertMenuPermission($data)
    {
        return $this->db->table('user_access')->insert([
            'role_id' => $data['roleID'], 'menu_id' => $data['menuID']
        ]);
    }

    public function deleteMenuPermission($data)
    {
        return $this->db->table('user_access')
            ->where(['role_id' => $data['roleID'], 'menu_id' => $data['menuID']])
            ->delete();
    }

    public function checkUserSubmenuAccess($data)
    {
        return $this->db->table('user_access')
            ->where(['role_id' => $data['roleID'], 'submenu_id' => $data['submenuID']])
            ->countAllResults();
    }

    public function insertSubmenuPermission($data)
    {
        return $this->db->table('user_access')->insert([
            'role_id' => $data['roleID'], 'submenu_id' => $data['submenuID']
        ]);
    }

    public function deleteSubmenuPermission($data)
    {
        return $this->db->table('user_access')
            ->where(['role_id' => $data['roleID'], 'submenu_id' => $data['submenuID']])
            ->delete();
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
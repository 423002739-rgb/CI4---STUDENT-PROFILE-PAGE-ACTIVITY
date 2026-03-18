<?php

// app/Models/UserModel.php  (UPDATED for RBAC Activity)

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    protected $allowedFields = [
        'name', 'email', 'password', 'role',
        'student_id', 'course', 'year_level', 'section',
        'phone', 'address', 'profile_image',
    ];

    protected $returnType = 'array';

    // ── Validation (registration only) ───────────────────────
    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];

    // ── Custom methods ────────────────────────────────────────

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Return a user with their role name joined in.
     * Uses a raw query join so we get role.name alongside user data.
     *
     * @param int $id  User ID
     */
    public function findWithRole(int $id): ?array
    {
        return $this->db->table('users u')
            ->select('u.*, r.name AS role_name, r.label AS role_label')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('u.id', $id)
            ->where('u.deleted_at IS NULL')
            ->get()
            ->getRowArray();
    }

    /**
     * Return all users with their role label joined in.
     * Used by the Teacher/Admin student management page.
     */
    public function getAllWithRoles(): array
    {
        return $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.student_id, u.course,
                      u.year_level, u.section, u.created_at,
                      r.name AS role_name, r.label AS role_label')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('u.deleted_at IS NULL')
            ->orderBy('u.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function updateProfile(int $userId, array $data): bool
    {
        return $this->update($userId, $data);
    }
}

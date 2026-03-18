<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TeacherFilter implements FilterInterface
{
    // Base sa Step 3.3 ng PDF mo, Teacher at Admin ang allowed dito
    protected array $allowedRoles = ['teacher', 'admin'];

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!in_array(session('user')['role'], $this->allowedRoles, true)) {
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class StudentFilter implements FilterInterface 
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Layer 2: Dapat 'student' ang role sa session
        if (session('user')['role'] !== 'student') {
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
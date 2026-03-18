<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface 
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Layer 2: Dapat 'admin' ang role sa session
        if (session('user')['role'] !== 'admin') {
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
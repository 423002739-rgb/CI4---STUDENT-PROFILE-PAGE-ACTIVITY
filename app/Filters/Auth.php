<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check kung ang user ay naka-login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('notif_error', 'Kailangan mo munang mag-login!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Hayaan lang itong walang laman
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AuthController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    /**
     * Handle /admin route - redirect based on login status
     */
    public function index()
    {
        // Jika sudah login, langsung ke dashboard
        if (session()->get('is_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        
        // Jika belum login, ke halaman login
        return redirect()->to('/admin/login');
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard (tidak perlu login lagi)
        if (session()->get('is_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $admin = $this->adminModel->validateLogin($username, $password);

            if ($admin) {
                session()->set([
                    'admin_id' => $admin['id'],
                    'admin_username' => $admin['username'],
                    'admin_nama' => $admin['nama_lengkap'],
                    'is_logged_in' => true
                ]);

                return redirect()->to('/admin/dashboard')->with('success', 'Login berhasil!');
            } else {
                return redirect()->back()->with('error', 'Username atau password salah!');
            }
        }

        return view('admin/auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Logout berhasil!');
    }
}
<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function login(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn') === true) {
            return redirect()->to('/customers');
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function attemptLogin(): RedirectResponse
    {
        if (! $this->validate([
            'username' => 'required|max_length[50]',
            'password' => 'required|max_length[255]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->where('username', trim((string) $this->request->getPost('username')))->first();
        $password  = (string) $this->request->getPost('password');

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'The username or password is incorrect.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id'    => (int) $user['id'],
            'username'   => $user['username'],
            'full_name'  => $user['full_name'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/customers')->with('success', 'Welcome back, ' . $user['full_name'] . '.');
    }

    public function logout(): RedirectResponse
    {
        $session = session();
        $session->remove(['user_id', 'username', 'full_name', 'isLoggedIn']);
        $session->destroy();

        return redirect()->to('/login');
    }
}

<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        return view('users/index', [
            'title' => 'User Accounts',
            'users' => $userModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('users/form', ['title' => 'New User', 'user' => null]);
    }

    public function create(): RedirectResponse
    {
        if (! $this->validate($this->rules(true))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $username  = trim((string) $this->request->getPost('username'));

        if ($userModel->where('username', $username)->first() !== null) {
            return redirect()->back()->withInput()->with('error', 'That username is already in use.');
        }

        $userModel->insert([
            'username'   => $username,
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'password'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'User account created.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/form', ['title' => 'Edit User', 'user' => $user]);
    }

    public function update(int $id): RedirectResponse
    {
        $userModel = new UserModel();

        if ($userModel->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        if (! $this->validate($this->rules(false))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username  = trim((string) $this->request->getPost('username'));
        $duplicate = $userModel->where('username', $username)->where('id !=', $id)->first();

        if ($duplicate !== null) {
            return redirect()->back()->withInput()->with('error', 'That username is already in use.');
        }

        $data = [
            'username'  => $username,
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        if ((int) session()->get('user_id') === $id) {
            session()->set(['username' => $data['username'], 'full_name' => $data['full_name']]);
        }

        return redirect()->to('/users')->with('success', 'User account updated.');
    }

    public function delete(int $id): RedirectResponse
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/users')->with('error', 'You cannot delete the account you are using.');
        }

        (new UserModel())->delete($id);

        return redirect()->to('/users')->with('success', 'User account deleted.');
    }

    private function rules(bool $passwordRequired): array
    {
        return [
            'username'  => 'required|alpha_numeric_punct|max_length[50]',
            'full_name' => 'required|max_length[100]',
            'password'  => ($passwordRequired ? 'required|' : 'permit_empty|') . 'min_length[8]|max_length[255]',
        ];
    }
}

<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();

        return view('customers/index', [
            'title'     => 'Customer Accounts',
            'customers' => $customerModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('customers/form', ['title' => 'New Customer', 'customer' => null]);
    }

    public function create(): RedirectResponse
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert($this->customerData() + ['created_at' => date('Y-m-d H:i:s')]);

        return redirect()->to('/customers')->with('success', 'Customer account created.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/form', ['title' => 'Edit Customer', 'customer' => $customer]);
    }

    public function update(int $id): RedirectResponse
    {
        $customerModel = new CustomerModel();

        if ($customerModel->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customerModel->update($id, $this->customerData());

        return redirect()->to('/customers')->with('success', 'Customer account updated.');
    }

    public function delete(int $id): RedirectResponse
    {
        (new CustomerModel())->delete($id);

        return redirect()->to('/customers')->with('success', 'Customer account deleted.');
    }

    private function rules(): array
    {
        return [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];
    }

    private function customerData(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')),
        ];
    }
}

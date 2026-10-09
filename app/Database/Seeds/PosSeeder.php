<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $createdAt = '2026-10-09 12:00:00';
        $password  = password_hash('Password123!', PASSWORD_DEFAULT);

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Maria Santos', 'email' => 'maria.santos@example.com', 'phone' => '0917-123-4567', 'created_at' => $createdAt],
            ['full_name' => 'Juan Dela Cruz', 'email' => 'juan.delacruz@example.com', 'phone' => '0918-234-5678', 'created_at' => $createdAt],
            ['full_name' => 'Angela Reyes', 'email' => 'angela.reyes@example.com', 'phone' => '0919-345-6789', 'created_at' => $createdAt],
            ['full_name' => 'Carlo Mendoza', 'email' => 'carlo.mendoza@example.com', 'phone' => '0920-456-7890', 'created_at' => $createdAt],
            ['full_name' => 'Nicole Garcia', 'email' => 'nicole.garcia@example.com', 'phone' => '0921-567-8901', 'created_at' => $createdAt],
        ]);

        $this->db->table('users')->insertBatch([
            ['username' => 'admin', 'full_name' => 'Andrea Lim', 'password' => $password, 'created_at' => $createdAt],
            ['username' => 'cashier01', 'full_name' => 'Paolo Cruz', 'password' => $password, 'created_at' => $createdAt],
            ['username' => 'cashier02', 'full_name' => 'Ella Ramos', 'password' => $password, 'created_at' => $createdAt],
            ['username' => 'manager01', 'full_name' => 'Miguel Torres', 'password' => $password, 'created_at' => $createdAt],
            ['username' => 'inventory01', 'full_name' => 'Sofia Navarro', 'password' => $password, 'created_at' => $createdAt],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin Quản Trị',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'), // Mật khẩu
            'role' => 'admin', // QUAN TRỌNG: role phải là admin
        ]);
        
        // Tạo thêm 1 user thường để test
        \App\Models\User::factory()->create([
            'name' => 'Khách Hàng',
            'email' => 'khach@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'user',
        ]);
    }
}

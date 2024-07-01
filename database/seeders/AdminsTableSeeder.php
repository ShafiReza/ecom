<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'type' => 'superadmin',
                'vendor_id' => 0,
                'mobile' => '9800000000',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'), // You can hash the password here
                'image' => '',
                'status' => 1
            ]
        ];
        Admin::insert($adminRecords);

    }
}

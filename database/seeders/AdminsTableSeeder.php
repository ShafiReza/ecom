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
                'id' => 2,
                'name' => 'shafi',
                'type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '01947393823',
                'email' => 's.reza3823@gmail.com',
                'password' => bcrypt('123456'), // You can hash the password here
                'image' => '',
                'status' => 0
            ]
        ];
        Admin::insert($adminRecords);

    }
}

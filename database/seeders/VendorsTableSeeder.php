<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;
class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1,'name'=>'shafi', 'address'=>'cp-122', 'city'=>'Dhaka', 'state'=>'Dhaka',
            'country'=>'Bangladesh', 'pincode'=>'110001', 'mobile'=>'01947393823',
            'email'=>'s.reza3823@gmail.com','status'=>0
            ]
        ];
        Vendor::insert($vendorRecords);
    }
}

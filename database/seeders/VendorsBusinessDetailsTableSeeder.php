<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;
class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1, 'vendor_id'=>1, 'shop_name'=>'Shafi Tech bd', 'shop_address'=>'1234-SCF',
            'shop_city'=>'Dhaka', 'shop_state'=>'Dhaka', 'shop_country'=>'Bangladesh', 'shop_pincode'=>'110001',
            'shop_mobile'=>'01947393823','shop_website'=>'sitemakers.in','shop_email'=>'s.reza3823@gmail.com','address_proof'=>'Passport', 'address_proof_image'=>'test.jpg',
            'business_license_number'=>'13243535', 'gst_number'=>'446466446', 'pan_number'=>'242355346',
            ]
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;
class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1, 'vendor_id'=>1, 'account_holder_name'=>'shafi', 'bank_name'=>'ONE BANK',
            'account_number'=>'6987678976897', 'bank_ifsc_code'=>'3453636546',
            ]
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}

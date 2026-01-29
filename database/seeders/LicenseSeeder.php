<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Botble\Setting\Facades\Setting;
use Carbon\Carbon;
class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        Setting::forceSet([
            'license_activated_at' => $now->toIso8601String(),
            'license_last_verified_at' => $now->toIso8601String(),
            'license_next_check_at' => $now->copy()->addYears(10)->toIso8601String(),
            'license_verification_count' => 999,
            'license_purchase_code_hash' => hash('sha256', 'FAKE_LICENSE_FOR_DEV'),
            'license_server_ip' => '127.0.0.1',
            'license_domain' => 'localhost',
            'licensed_to' => 'Development User',
        ])->save();
    }
}

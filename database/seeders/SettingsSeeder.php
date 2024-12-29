<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'kasir_promo_access'],
            ['value' => '0'] // Default tidak diizinkan 0/false
        );

        DB::table('settings')->insert([
            ['key' => 'require_account_for_order', 'value' => '1'], // Default: Wajib Akun 1/true
        ]);
    }
}

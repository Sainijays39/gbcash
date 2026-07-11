<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->firstOrCreate(
            ['email' => 'admin@bharatpaye.in'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ],
        );
    }
}

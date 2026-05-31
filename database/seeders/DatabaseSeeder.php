<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Fee Types
        DB::table('jenis_iuran')->insert([
            ['name' => 'Satpam',     'amount' => 100000, 'created_at' => now()],
            ['name' => 'Kebersihan', 'amount' => 15000,  'created_at' => now()],
        ]);

        // 20 Houses
        for ($i = 1; $i <= 20; $i++) {
            DB::table('rumah')->insert([
                'house_number' => 'Rumah ' . $i,
                'status'       => $i <= 15 ? 'dihuni' : 'tidak_dihuni',
                'created_at'   => now(),
            ]);
        }
    }
}

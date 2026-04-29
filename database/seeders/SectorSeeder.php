<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sector::insert([
            ['key' => 'founders', 'name' => 'Founders Strategic Council'],
            ['key' => 'board', 'name' => 'Board of Advisors'],
            ['key' => 'faculty', 'name' => 'Faculty'],
            ['key' => 'staff', 'name' => 'Our Staff'],
        ]);
        $this->command->info('✅ Sector users created:');
    }
}

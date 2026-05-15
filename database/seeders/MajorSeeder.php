<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            ['code' => 'TKJ', 'name' => 'Teknik Komputer Jaringan'],
            ['code' => 'TKR', 'name' => 'Teknik Kendaraan Ringan'],
            ['code' => 'TAV', 'name' => 'Teknik Audio Valenci'],
            ['code' => 'TSM', 'name' => 'Teknik Sepeda Motor'],
            ['code' => 'TPR', 'name' => 'Teknik Pendingin Ruangan'],
            ['code' => 'KA', 'name' => 'Kimia Analis'],
            ['code' => 'KI', 'name' => 'Kimia Industri'],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(['code' => $major['code']], $major);
        }
    }
}

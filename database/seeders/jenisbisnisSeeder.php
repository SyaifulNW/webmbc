<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class jenisbisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        'Bisnis Properti',
        'Bisnis Manufaktur',
        'Bisnis F&B (Food & Beverage)',
        'Bisnis Jasa',
        'Bisnis Digital',
        'Bisnis Online',
        'Bisnis Franchise',
        'Bisnis Edukasi & Pelatihan',
        'Bisnis Kreatif',
        'Bisnis Agribisnis',
        'Bisnis Kesehatan & Kecantikan',
        'Bisnis Keuangan',
        'Bisnis Transportasi & Logistik',
        'Bisnis Pariwisata & Hospitality',
        'Bisnis Sosial (Social Enterprise)',
        'Bisnis Retail',
        'Bisnis Teknologi Informasi',
        'Bisnis Energi & Lingkungan',
        'Bisnis Otomotif',
        'Bisnis Telekomunikasi',
        ];

        foreach ($data as $item) {
            \App\Models\jenisbisnis::create([
                'nama' => $item,
            ]);
        }
    }
}

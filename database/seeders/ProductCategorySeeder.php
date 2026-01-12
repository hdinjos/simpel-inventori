<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Barang elektronik dan perangkat listrik'
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'description' => 'Peralatan kebutuhan rumah tangga'
            ],
            [
                'name' => 'Alat Tulis Kantor',
                'description' => 'Perlengkapan alat tulis dan kebutuhan kantor'
            ],
            [
                'name' => 'Bahan Bangunan',
                'description' => 'Material dan perlengkapan konstruksi'
            ],
            [
                'name' => 'Peralatan Teknik',
                'description' => 'Peralatan kerja dan teknik'
            ],
            [
                'name' => 'Suku Cadang',
                'description' => 'Spare part dan komponen pengganti'
            ],
            [
                'name' => 'Perlengkapan Kebersihan',
                'description' => 'Alat dan bahan kebersihan'
            ],
            [
                'name' => 'Peralatan Keamanan',
                'description' => 'Perlengkapan keselamatan dan keamanan kerja'
            ],
            [
                'name' => 'Peralatan Gudang',
                'description' => 'Peralatan penunjang operasional gudang'
            ],
            [
                'name' => 'Kemasan',
                'description' => 'Barang kemasan dan pembungkus'
            ],
            [
                'name' => 'Peralatan Listrik',
                'description' => 'Kabel, lampu, dan komponen listrik'
            ],
            [
                'name' => 'Peralatan IT',
                'description' => 'Perangkat teknologi informasi'
            ],
            [
                'name' => 'Bahan Kimia',
                'description' => 'Bahan kimia untuk operasional'
            ],
            [
                'name' => 'Barang Konsumsi',
                'description' => 'Barang habis pakai'
            ],
            [
                'name' => 'Peralatan Transportasi',
                'description' => 'Peralatan dan suku cadang transportasi'
            ]
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}

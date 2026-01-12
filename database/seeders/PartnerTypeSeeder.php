<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PartnerType;

class PartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerTypes = [
            [
                'name' => 'supplier',
                'description' => 'Supplier partner type'
            ],
            [
                'name' => 'konsumen',
                'description' => 'Konsumen partner type'
            ],
            [
                'name' => 'toko',
                'description' => 'Store partner type'
            ],
            [
                'name' => 'teknisi',
                'description' => 'Technician partner type'
            ],
            [
                'name' => 'outlet',
                'description' => 'Outlet partner type'
            ],
            [
                'name' => 'distributor',
                'description' => 'Distributor partner type'
            ]
        ];

        foreach ($partnerTypes as $partnerType) {
            PartnerType::create($partnerType);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'buah', 'description' => 'Unit for buah items'],
            ['name' => 'box', 'description' => 'Unit for box items'],
            ['name' => 'pcs', 'description' => 'Unit for pieces items'],
            ['name' => 'kg', 'description' => 'Unit for kilogram items'],
            ['name' => 'gram', 'description' => 'Unit for gram items'],
            ['name' => 'liter', 'description' => 'Unit for liquid items'],
            ['name' => 'ml', 'description' => 'Unit for milliliter items'],
            ['name' => 'm', 'description' => 'Unit for meter items'],
            ['name' => 'cm', 'description' => 'Unit for centimeter items'],
            ['name' => 'roll', 'description' => 'Unit for roll items'],
            ['name' => 'pack', 'description' => 'Unit for pack items'],
            ['name' => 'set', 'description' => 'Unit for set items'],
            ['name' => 'lusin', 'description' => 'Unit for dozen items'],
            ['name' => 'karung', 'description' => 'Unit for sack items'],
            ['name' => 'unit', 'description' => 'Unit for unit items'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}

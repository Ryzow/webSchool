<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryNames = [
            'Bahasa Arab', 'Mtk', 'Bahasa inggris', 'Bahasa jerman', 'Bahasa mandarin',
            'Kimia', 'Biologi', 'Teologi', 'Geografi'
        ]; // 9

        $data = [];

        foreach ($categoryNames as $index => $name) {
            $data[] = [
                'category' => $name,
                'no_rak' =>str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('categories')->insert($data);
    }
}

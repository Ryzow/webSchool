<?php

namespace Database\Seeders;

use App\Models\book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class bookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $covers = [
            'https://images.unsplash.com/photo-1728241965088-25b5a03ca25f?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aWx1c3RyYXNpb258ZW58MHwxfDB8fHww',
            'https://plus.unsplash.com/premium_photo-1667668223835-19c104de847d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8aWx1c3RyYXNpb258ZW58MHwxfDB8fHww',
            'https://plus.unsplash.com/premium_photo-1673518604805-7502fdc30508?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8aWx1c3RyYXNpb258ZW58MHwxfDB8fHww',
        ];

        for ($i=0; $i < 50 ; $i++) { 
            book::create([
                'kategori' => rand(1,9),
                'nama_buku' => 'Judul Buku ke-'. $i,
                'nama_pengarang' => 'Pengarang ke-'. rand(1,10),
                'nama_penerbit' => 'Penerbit cab-'. rand(1,13),
                'tahun_terbit' => rand(1990,2025),
                'gambar' => $covers[array_rand($covers)],
            ]);
        }
    }
}

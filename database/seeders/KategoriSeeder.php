<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Descriptive Text', 'slug' => 'descriptive-text'],
            ['name' => 'Recount Text', 'slug' => 'recount-text'],
            ['name' => 'Sports & Health', 'slug' => 'sports-health'],
            ['name' => 'Healthy Foods', 'slug' => 'healthy-foods'],
        ];

        foreach ($data as $item) {
            Kategori::create($item);
        }
    }
}

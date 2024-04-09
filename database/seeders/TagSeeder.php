<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = ['php', 'go', 'C++', 'C#', 'java', 'js', 'rust', 'react', 'laravel'];

        foreach ($datas as $data){
            DB::table('tags')->insert([
                'title' => $data,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

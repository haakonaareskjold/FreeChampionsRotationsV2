<?php

namespace Database\Seeders;

use App\Models\FreeChampionRotation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FreeChampionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FreeChampionRotation::factory()->make();
    }
}

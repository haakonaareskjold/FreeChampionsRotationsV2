<?php

namespace Database\Factories;

use App\Models\FreeChampionRotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FreeChampionRotation>
 */
class FreeChampionRotationFactory extends Factory
{

    protected $model = FreeChampionRotation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'champions' => [
                "Bard",
                "Jhin",
                "Kindred",
                "K'Sante",
                "Lux",
                "Nunu & Willump",
                "Pantheon",
                "Rakan",
                "Rengar",
                "Samira",
                "Sejuani",
                "Skarner",
                "Trundle",
                "Vel'Koz",
                "Viktor",
                "Xin Zhao"
            ]
        ];
    }
}

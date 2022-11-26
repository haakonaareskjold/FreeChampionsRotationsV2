<?php

namespace Tests\Feature;

use App\Models\FreeChampionRotation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FreeChampionRotationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check if record exists after factory is run.
     *
     * @return void
     */
    public function test_if_model_exists_in_database()
    {
        $freeChampionRotation = FreeChampionRotation::factory()->create();
        $this->assertModelExists($freeChampionRotation);
    }

    public function test_if_data_can_be_fetched_from_model_and_has_correct_structure()
    {
        FreeChampionRotation::factory()->create();

        $this->json('GET', 'api/', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'title',
                    'blurb',
                    'imageUrl'
                ]]);
    }
}

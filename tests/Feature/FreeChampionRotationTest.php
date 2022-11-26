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
        FreeChampionRotation::factory()->create();
        $this->assertDatabaseCount('free_champion_rotations', 1);
    }

    public function test_if_data_can_be_fetched_from_model()
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

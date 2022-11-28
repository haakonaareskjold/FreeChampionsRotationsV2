<?php

namespace Tests\Feature;

use App\Jobs\FreeChampionRotationJob;
use App\Models\FreeChampionRotation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FreeChampionRotationTest extends TestCase
{
    use RefreshDatabase;

    private string $mostRecentPatch;

    public function test_if_can_get_mostRecentPatch_from_ddragon_api()
    {
        $this->mostRecentPatch = Http::get('https://ddragon.leagueoflegends.com/api/versions.json')->json([0]);

        $this->assertIsString($this->mostRecentPatch);
    }

    public function test_if_can_get_champions_from_ddragon_api()
    {
        $this->test_if_can_get_mostRecentPatch_from_ddragon_api();
        $response = Http::get("https://ddragon.leagueoflegends.com/cdn/{$this->mostRecentPatch}/data/en_US/champion.json");

        $data = $response->json('data');

        $this->assertArrayHasKey('Aatrox', $data);
    }

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

    public function test_auth_for_riotgames_api()
    {
        Http::fake();

        Http::withHeaders([
            'X-Riot-Token' => config('services.riotgames.token', 'RGAPI-2ce3f884-a7fa-4026-b6f1-e7e7b1a71130')
        ])->get('https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations');

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-Riot-Token');
        });
    }

    public function test_if_job_can_be_queued()
    {
        Queue::fake();

        FreeChampionRotationJob::dispatch();

        Queue::assertPushed(FreeChampionRotationJob::class);
    }

    public function test_if_job_can_run_at_scheduled_time()
    {
       Bus::fake();
       $this->travelTo(now()->startOfWeek()->days(1)->setTime(02, 01));
       $this->artisan('schedule:run');

       Bus::assertDispatched(FreeChampionRotationJob::class);
    }
}

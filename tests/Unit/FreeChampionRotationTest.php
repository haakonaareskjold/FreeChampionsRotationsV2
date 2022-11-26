<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FreeChampionRotationTest extends TestCase
{
    /**
     * @var array|mixed
     */
    private mixed $mostRecentPatch;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_if_can_get_mostRecentPatch()
    {
       $this->mostRecentPatch = Http::get('https://ddragon.leagueoflegends.com/api/versions.json')->json([0]);

       $this->assertIsString($this->mostRecentPatch);
    }

    public function test_if_can_get_champions()
    {
        $this->test_if_can_get_mostRecentPatch();
        $response = Http::get("https://ddragon.leagueoflegends.com/cdn/{$this->mostRecentPatch}/data/en_US/champion.json");

       $data = $response->json('data');

       $this->assertArrayHasKey('Aatrox', $data);
    }
}

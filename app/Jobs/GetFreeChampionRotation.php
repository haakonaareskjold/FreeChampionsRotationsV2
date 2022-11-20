<?php

namespace App\Jobs;

use App\Models\FreeChampionRotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetFreeChampionRotation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     * Map champions IDs to the ones that are in the free champion rotation and pushes them into a collection.
     *
     * @return void
     */
    public function handle(): void {
        $champions = $this->getChampions();
        $championsIDsInRotation = $this->getChampionsIDsInRotation();

        $freeChampionRotation = new FreeChampionRotation();
        $championNames = null;
        foreach ($champions as $champion) {
            if (in_array($champion['key'], $championsIDsInRotation)) {
                $championNames[] = $champion['name'];
            }
        }

        $freeChampionRotation->champions = json_encode($championNames, JSON_THROW_ON_ERROR);
        $freeChampionRotation->save();
    }

    /**
     * Gets a list of IDs of champions (in rotation) from the riot games v3 champions REST api.
     *
     * @return array|null
     */
    private function getChampionsIDsInRotation(): ?array {
        $response = Http::withHeaders([
            'X-Riot-Token' => config('services.riotgames.token'),
        ])->get(config('services.riotgames.url'));

        return $response->json('freeChampionIds');
    }

    /**
     * Gets a list of champions according to the newest patch.
     *
     * @return array|null
     */
    private function getChampions(): ?array {
        $response = Http::get("https://ddragon.leagueoflegends.com/cdn/{$this->getMostRecentPatch()}/data/en_US/champion.json");

        return  $response->json('data');
    }

    /**
     * Returns the most recent patch
     *
     * @return string|null
     */
    private function getMostRecentPatch(): ?string {
        return Http::get('https://ddragon.leagueoflegends.com/api/versions.json')->json(0);
    }
}

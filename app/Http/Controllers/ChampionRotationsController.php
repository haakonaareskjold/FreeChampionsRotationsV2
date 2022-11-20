<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ChampionRotationsController extends Controller
{
    /**
     * Maps champions IDs to the ones that are in the free champion rotation and pushes them into a collection.
     *
     * @return Collection
     */
    public function getChampionsInRotation(): Collection {
        $champions = $this->getChampions();
        $championsIDsInRotation = $this->getChampionsIDsInRotation();
        $collection = Collection::make();

        foreach ($champions as $champion) {
            if (in_array($champion['key'], $championsIDsInRotation)) {
                $collection->push($champion['name']);
            }
        }

        return $collection;
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

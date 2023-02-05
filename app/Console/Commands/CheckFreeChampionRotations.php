<?php

namespace App\Console\Commands;

use App\Jobs\FreeChampionRotationJob;
use App\Models\FreeChampionRotation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class CheckFreeChampionRotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FCRCheck:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there exist records for the FreeChampionRotation model';


    public function handle()
    {
        if (!FreeChampionRotation::query()->exists()) {
            Bus::dispatch(new FreeChampionRotationJob());
        }
    }
}

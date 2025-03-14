<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateWeatherJob;

class UpdateWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:update-weather-command';
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Fetch and update weather data periodically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new UpdateWeatherJob());
        $this->info('Weather data updated successfully.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiFootballService;
use App\Models\League;
use App\Models\Country;

class SyncLeagues extends Command
{
    protected $signature = 'sync:leagues';
    protected $description = 'Fetch and store leagues from API-Football';

    protected $apiService;

    public function __construct(ApiFootballService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    public function handle()
    {
        $this->info('Fetching leagues from API-Football...');

        $response = $this->apiService->getLeagues();

        if (!isset($response['response'])) {
            $this->error('❌ Invalid API response.');
            return;
        }

        $count = 0;

        foreach ($response['response'] as $item) {
            $leagueData = $item['league'];
            $countryData = $item['country'] ?? null;

            if (!$countryData || empty($countryData['name'])) continue;

            // Try to find or create the country
            $country = Country::updateOrCreate(
                ['name' => $countryData['name']],
                [
                    'code' => $countryData['code'] ?? null,
                    'flag' => $countryData['flag'] ?? null,
                ]
            );

            // Save the league
            if (empty($leagueData['id'])) {
    $this->warn("⚠️ Skipped league: {$leagueData['name']} (no API ID)");
    continue;
}

League::updateOrCreate(
    ['league_api_id' => $leagueData['id']],
    [
        'name' => $leagueData['name'],
        'country_id' => $country->id,
        'type' => $leagueData['type'] ?? null,
        'logo' => $leagueData['logo'] ?? null,
        'season' => $item['seasons'][0]['year'] ?? null,
        'country_api_id' => $countryData['id'] ?? null,
    ]
);


            $count++;
        }

        $this->info("✅ {$count} leagues synced successfully!");
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiFootballService;
use App\Models\Country;

class SyncCountries extends Command
{
    protected $signature = 'sync:countries';
    protected $description = 'Fetch and store countries from API-Football';

    protected $apiService;

    public function __construct(ApiFootballService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    public function handle()
    {
        $this->info('Fetching countries from API-Football...');

        $response = $this->apiService->getCountries();

        if (!isset($response['response'])) {
            $this->error('Invalid response from API');
            return;
        }

        $count = 0;

        foreach ($response['response'] as $item) {
            Country::updateOrCreate(
                ['name' => $item['name']],
                [
                    'code' => $item['code'] ?? null,
                    'flag' => $item['flag'] ?? null,
                ]
            );
            $count++;
        }

        $this->info("✅ {$count} countries synced successfully!");
    }
}

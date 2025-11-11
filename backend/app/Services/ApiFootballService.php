<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiFootballService
{
    protected $baseUrl;
    protected $apiKey;
    protected $headers;

    public function __construct()
    {
        $this->apiKey = env('API_FOOTBALL_KEY');
        $this->baseUrl = env('API_FOOTBALL_BASE', 'https://v3.football.api-sports.io');

        $this->headers = [
            'x-apisports-key' => $this->apiKey,
        ];
    }

    public function get($endpoint, $params = [])
    {
        $response = Http::withHeaders($this->headers)
            ->get($this->baseUrl . $endpoint, $params);

        return $response->json();
    }

    public function getLiveScores()
    {
        return $this->get('/fixtures', ['live' => 'all']);
    }

    public function getCountries()
    {
        return $this->get('/countries');
    }

    public function getLeagues()
    {
        return $this->get('/leagues');
    }

    public function getTeams($leagueId, $season)
    {
        return $this->get('/teams', [
            'league' => $leagueId,
            'season' => $season,
        ]);
    }
}

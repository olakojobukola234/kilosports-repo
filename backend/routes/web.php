<?php

use App\Services\ApiFootballService;
use Illuminate\Support\Facades\Route;

Route::get('/test-football', function (ApiFootballService $api) {
    return $api->getLeagues(); // test leagues
});

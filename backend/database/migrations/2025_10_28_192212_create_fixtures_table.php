<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('fixtures', function (Blueprint $table) {
        $table->id();
        $table->integer('fixture_api_id')->unique();
        $table->unsignedBigInteger('league_id');
        $table->unsignedBigInteger('home_team_id');
        $table->unsignedBigInteger('away_team_id');
        $table->string('status')->nullable();
        $table->integer('home_goals')->nullable();
        $table->integer('away_goals')->nullable();
        $table->timestamp('match_date')->nullable();
        $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
        $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
        $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};

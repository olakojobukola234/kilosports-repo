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
    Schema::create('leagues', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('country_id')
          ->nullable()
          ->constrained('countries')
          ->cascadeOnDelete();
    $table->string('type')->nullable();
    $table->string('logo')->nullable();
    $table->integer('season')->nullable();
    $table->integer('league_api_id')->unique()->nullable();
    $table->integer('country_api_id')->nullable();
    $table->timestamps();
});

}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};

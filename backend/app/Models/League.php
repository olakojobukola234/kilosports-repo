<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'type',
        'logo',
        'season',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

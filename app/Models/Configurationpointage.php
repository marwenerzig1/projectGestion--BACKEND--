<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configurationpointage extends Model
{
    protected $table = 'configurationpointage';
    protected $fillable = [ 
        'lantitudeSociete','longitudeSociete','distanceInKM','temps_denvoi','etat'
    ];
    public $timestamps = true;
}

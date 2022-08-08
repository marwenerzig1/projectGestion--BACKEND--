<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $table = 'historique';
    protected $fillable = [ 
        'id_pointage','latitude','longitude','etat','temps'   
    ];
    public $timestamps = true;
}

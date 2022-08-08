<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    protected $table = 'traitement';
    protected $fillable = [ 
        'id_conge','id_responsable','etat'   
    ];
    public $timestamps = true;
}

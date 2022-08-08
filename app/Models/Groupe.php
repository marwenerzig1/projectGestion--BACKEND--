<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $table = 'groupe';
    protected $fillable = [ 
        'id_responsable','nom_projet' , 'description'   
    ];
    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conges extends Model
{
    protected $table = 'conges';
    protected $fillable = [ 
        'id_employe','date_debut','date_fin','nombre_jours','cause','date_demande','etat'   
    ];
    public $timestamps = true;
}

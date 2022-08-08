<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    protected $table = 'pointage';
    protected $fillable = [ 
        'id_employe','date','temps_dentree','date_de_sortie','totale_heures','break_heures','net_heures','regular_heures','overtime'   
    ];
    public $timestamps = true;
}

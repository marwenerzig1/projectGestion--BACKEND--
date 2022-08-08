<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    protected $table = 'membre';
    protected $fillable = [ 
        'id_employe','id_groupe'   
    ];
    public $timestamps = true;
}

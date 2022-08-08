<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    protected $table = 'days';
    protected $fillable = [ 
        'day','date_debut','date_fin','break_houres','regular_houres','date_finale','etat'   
    ];
    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employe';
    protected $fillable = [ 
        'nom','prenom','cin' , 'telephone' , 'adresse' , 'date_de_naissance' , 'status' ,'solde_conge' ,'salaire','etat' , 'login' , 'password'   
    ];
    public $timestamps = true;
}

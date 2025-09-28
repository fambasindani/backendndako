<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'id_type_compte',
        'prenom',
        'nom_famille',
        'email',
        'telephone',
        'password',
        'role',
        'etat',
        'statut',
        'avatar'
    ];


}

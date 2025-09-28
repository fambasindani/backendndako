<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // Importez ce trait

class Authentification extends Authenticatable // Changez Model en Authenticatable
{
    use HasFactory, HasApiTokens; // Ajoutez HasApiTokens ici

    // Nom de la table dans la base de données
    protected $table = 'utilisateurs';

    // Champs autorisés à être remplis
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
    ];

    // Si vous souhaitez que le mot de passe soit automatiquement hashed
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($utilisateur) {
            if ($utilisateur->isDirty('password')) {
                $utilisateur->password = Hash::make($utilisateur->password);
            }
        });
    }
}
<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes'; // Optionnel si le nom de la table est bien "communes"

    protected $fillable = [
        'id_ville',
        'nom_commune',
        'etat',
    ];

    public $timestamps = false; // Si ta table n'a pas de colonnes created_at / updated_at

    // Relation avec la ville (si tu as un modèle Ville)
    public function ville()
    {
        return $this->belongsTo(Ville::class, 'id_ville');
    }
}

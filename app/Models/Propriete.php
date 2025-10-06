<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propriete extends Model
{
    use HasFactory;

    protected $table = 'proprietes';

    protected $fillable = [
        'id_utilisateur',
        'id_province',
        'id_ville',
        'id_commune',
        'id_type',
        'quartier',
        'avenue',
        'prix',
        'nombre_chambre',
        'nombre_salle_de_bain',
        'dimension',
        'description',
        'image_principale',
        'autres_images',
        'statut',
        'statut1',
        'etat',
        'date_enregistrement',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'statut' => 'boolean',
        'statut1' => 'boolean',
        'etat' => 'boolean',
        'date_enregistrement' => 'datetime',
        'autres_images' => 'array',
    ];

    // 🔗 Relations
    public function province()
    {
        return $this->belongsTo(Province::class, 'id_province');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'id_ville');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'id_commune');
    }

        public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

          public function typepropriete()
    {
        return $this->belongsTo(TypePropriete::class, 'id_type');
    }

    
}

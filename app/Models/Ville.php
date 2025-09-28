<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_ville',
        'id_province',
        'etat'
    ];

    // 🔗 Relation avec la province
    public function province()
    {
        return $this->belongsTo(Province::class, 'id_province');
    }
}

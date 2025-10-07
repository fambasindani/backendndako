<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommuneController extends Controller
{
    // 🔍 Liste des communes actives
  /*   public function get_commune()
    {
        return Commune::where('etat', 1)->get();
    } */

public function get_commune()
{
    return Commune::with('ville')
                ->where('etat', 1)
                ->get();
}

 public function create_commune(Request $request)
{
    try {
        $validated = $request->validate([
            'nom_commune' => 'required|string|unique:communes',
            'id_ville' => 'required|integer',
        ], [
            'nom_commune.required' => 'Le nom de la commune est obligatoire.',
            'nom_commune.unique' => 'Cette commune existe déjà.',
            'id_ville.required' => 'La ville associée est obligatoire.',
            'id_ville.integer' => 'L’identifiant de la ville doit être un entier.',
        ]);

        $commune = Commune::create([
            'nom_commune' => $validated['nom_commune'],
            'id_ville' => $validated['id_ville'],
            'etat' => 1
        ]);

        return response()->json($commune, 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    }
}


    // 👁️ Affichage d’une commune
    public function edit_commune($id)
    {
        return Commune::findOrFail($id);
    }

    // ✏️ Mise à jour d’une commune
    public function update_commune(Request $request, $id)
    {
        $commune = Commune::findOrFail($id);

        try {
            $validated = $request->validate([
                'nom_commune' => 'string|unique:communes,nom_commune,' . $id,
                'id_ville' => 'integer',
                'etat' => 'boolean'
            ], [
                'nom_commune.unique' => 'Ce nom de commune est déjà utilisé.',
                'nom_commune.string' => 'Le nom doit être une chaîne de caractères.',
                'id_ville.integer' => 'L’identifiant de la ville doit être un entier.',
                'etat.boolean' => 'Le champ "état" doit être vrai ou faux.'
            ]);

            $commune->update($validated);

            return response()->json([
                'message' => 'Commune mise à jour avec succès.',
                'data' => $commune
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // ❌ Désactivation logique
    public function delete_commune($id)
    {
        $commune = Commune::findOrFail($id);
        $commune->update(['etat' => 0]);

        return response()->json(['message' => 'Commune désactivée']);
    }
}

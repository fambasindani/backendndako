<?php



namespace App\Http\Controllers;

use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VilleController extends Controller
{
   // 🔍 Liste des villes actives avec leur province
public function get_villes()
{
    return Ville::with('province')
                ->where('etat', 1)
                ->get();
}


    // ➕ Création d’une ville
    public function create_ville(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom_ville' => 'required|string|unique:villes',
                'id_province' => 'required|exists:provinces,id'
            ], [
                'nom_ville.required' => 'Le nom de la ville est obligatoire.',
                'nom_ville.unique' => 'Cette ville existe déjà.',
                'id_province.required' => 'La province est obligatoire.',
                'id_province.exists' => 'La province spécifiée est introuvable.'
            ]);

            $ville = Ville::create([
                'nom_ville' => $validated['nom_ville'],
                'id_province' => $validated['id_province'],
                'etat' => 1
            ]);

            return response()->json($ville, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // 👁️ Affichage d’une ville
    public function edit_ville($id)
    {
        return Ville::findOrFail($id);
    }

    // ✏️ Mise à jour d’une ville
    public function update_ville(Request $request, $id)
    {
        $ville = Ville::findOrFail($id);

        try {
            $validated = $request->validate([
                'nom_ville' => 'string|unique:villes,nom_ville,' . $id,
                'id_province' => 'exists:provinces,id',
                'etat' => 'boolean'
            ], [
                'nom_ville.unique' => 'Ce nom de ville est déjà utilisé.',
                'id_province.exists' => 'La province spécifiée est introuvable.',
                'etat.boolean' => 'Le champ "état" doit être vrai ou faux.'
            ]);

            $ville->update($validated);

            return response()->json([
                'message' => 'Ville mise à jour avec succès.',
                'data' => $ville
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // ❌ Désactivation logique
    public function delete_ville($id)
    {
        $ville = Ville::findOrFail($id);
        $ville->update(['etat' => 0]);

        return response()->json(['message' => 'Ville désactivée']);
    }
}

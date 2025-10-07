<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProvinceController extends Controller
{
    // 🔍 Liste des provinces actives
    public function get_province()
    {
        return Province::where('etat', 1)->get();
    }

    // ➕ Création d’une province
    public function create_province(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom_province' => 'required|string|unique:provinces',
            ], [
                'nom_province.required' => 'Le nom de la province est obligatoire.',
                'nom_province.unique' => 'Cette province existe déjà.',
            ]);

            $province = Province::create([
                'nom_province' => $validated['nom_province'],
                'etat' => 1
            ]);

            return response()->json($province, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // 👁️ Affichage d’une province
    public function edit_province($id)
    {
        return Province::findOrFail($id);
    }

    // ✏️ Mise à jour d’une province
    public function update_province(Request $request, $id)
    {
        $province = Province::findOrFail($id);

        try {
            $validated = $request->validate([
                'nom_province' => 'string|unique:provinces,nom_province,' . $id,
                'etat' => 'boolean'
            ], [
                'nom_province.unique' => 'Ce nom de province est déjà utilisé.',
                'nom_province.string' => 'Le nom doit être une chaîne de caractères.',
                'etat.boolean' => 'Le champ "état" doit être vrai ou faux.'
            ]);

            $province->update($validated);

             return response()->json($province, 200);

          /*   return response()->json([
                'message' => 'Province mise à jour avec succès.',
                'data' => $province
            ], 200); */

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // ❌ Désactivation logique
    public function delete_province($id)
    {
        $province = Province::findOrFail($id);
        $province->update(['etat' => 0]);

        return response()->json(['message' => 'Province désactivée']);
    }
}

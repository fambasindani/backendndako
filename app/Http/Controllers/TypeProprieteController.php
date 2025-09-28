<?php



namespace App\Http\Controllers;

use App\Models\TypePropriete;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TypeProprieteController extends Controller
{
    // 🔍 Liste des propriétés actives
    public function get_propriete()
    {
        return TypePropriete::where('etat', 1)->get();
    }



public function create_propriete(Request $request)
{
    try {
        $validated = $request->validate([
            'nom_propriete' => 'required|string|unique:type_proprietes',
        ]);

        $type = TypePropriete::create([
            'nom_propriete' => $validated['nom_propriete'],
            'etat' => 1
        ]);

        return response()->json($type, 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    }
}

    // 👁️ Affichage d’une propriété
    public function edit($id)
    {
        return TypePropriete::findOrFail($id);
    }

  

public function update_propriete(Request $request, $id)
{
    $type = TypePropriete::findOrFail($id);

    try {
        $validated = $request->validate([
            'nom_propriete' => 'string|unique:type_proprietes,nom_propriete,' . $id,
            'etat' => 'boolean'
        ], [
            'nom_propriete.unique' => 'Ce nom de propriété est déjà utilisé.',
            'nom_propriete.string' => 'Le nom doit être une chaîne de caractères.',
            'etat.boolean' => 'Le champ "état" doit être vrai ou faux.'
        ]);

        $type->update($validated);

        return response()->json([
            'message' => 'Type de propriété mis à jour avec succès.',
            'data' => $type
        ], 200);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    }
}


    // ❌ Désactivation logique
    public function delete_propriete($id)
    {
        $type = TypePropriete::findOrFail($id);
        $type->update(['etat' => 0]);

        return response()->json(['message' => 'Type de propriété désactivé']);
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\TypeCompte;
use Illuminate\Http\Request;

class TypeCompteController extends Controller
{
    // Liste tous les types de comptes
 public function getcompte()
{
    return TypeCompte::where('etat', 1)->get();
}

public function create_compte(Request $request)
{
    $validated = $request->validate([
        'compte' => 'required|string|unique:type_comptes',
        // On ne valide plus 'etat' car on le force à 1
    ]);

    // Ajout explicite de etat = 1
    $validated['etat'] = 1;

    return TypeCompte::create($validated);
}


    // Affiche un type de compte spécifique
    public function edit_compte($id)
    {
        return TypeCompte::findOrFail($id);
    }

    // Mise à jour
    public function update_compte(Request $request, $id)
    {
        $typeCompte = TypeCompte::findOrFail($id);

        $validated = $request->validate([
            'compte' => 'string|unique:type_comptes,compte,' . $id,
             //'etat' => 'boolean'
        ]);

        $typeCompte->update($validated);

        return $typeCompte;
    }

// Désactivation logique
public function delete_compte($id)
{
    $typeCompte = TypeCompte::findOrFail($id);
    $typeCompte->update(['etat' => 0]);

    return response()->json(['message' => 'Type de compte désactivé avec succès']);
}

}

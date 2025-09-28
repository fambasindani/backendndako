<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;




class UtilisateurController extends Controller
{


  public function getUtilisateurs()
    {
        return Utilisateur::where('statut', 1)->paginate(50);
    }




public function create_utilisateur(Request $request)
{
    try {
        $validated = $request->validate([
            'id_type_compte' => 'required|integer',
            'nom_famille' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'telephone' => 'required|string|max:15',
        ]);

        $utilisateur = Utilisateur::create([
            'nom_famille' => $validated['nom_famille'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'statut' => 1,
            'etat' => 1,
            'avatar' => 'avatar.jpg', // Valeur par défaut
            'id_type_compte' => $validated['id_type_compte'],
            'telephone' => $validated['telephone'],
        ]);

        return response()->json([
            'message' => '✅ Utilisateur créé avec succès',
            'utilisateur' => $utilisateur
        ], 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => '❌ Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    }
}


public function update_utilisateur(Request $request, $id)
{
    try {
        $utilisateur = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            'id_type_compte' => 'sometimes|required|integer',
            'nom_famille' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:utilisateurs,email,' . $utilisateur->id,
            'password' => 'nullable|string|min:8',
            'role' => 'sometimes|required|string',
            'telephone' => 'sometimes|required|string|max:15',
        ]);

        // Mise à jour
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // ne pas écraser si vide
        }

        $utilisateur->update($validated);

        return response()->json([
            'message' => '✅ Utilisateur mis à jour avec succès',
            'utilisateur' => $utilisateur
        ], 200);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => '❌ Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => '❌ Utilisateur introuvable ou erreur',
            'error' => $e->getMessage()
        ], 404);
    }
}


public function delete_utilisateur($id)
{
    try {
        $utilisateur = Utilisateur::findOrFail($id);

        $utilisateur->etat = 0; // désactivation
        $utilisateur->save();

        return response()->json([
            'message' => '🗑️ Utilisateur désactivé avec succès',
            'utilisateur' => $utilisateur
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => '❌ Utilisateur introuvable',
            'error' => $e->getMessage()
        ], 404);
    }
}






}
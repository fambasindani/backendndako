<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authentification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    
public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $utilisateur = Authentification::where('email', $validated['email'])->first();

    if (!$utilisateur || !Hash::check($validated['password'], $utilisateur->password)) {
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    $token = $utilisateur->createToken('token_utilisateur')->plainTextToken;

    return response()->json([
        'token' => $token,
        'utilisateur' => [
            'id_type_compte' => $utilisateur->id_type_compte,
            'email' => $utilisateur->email,
            'telephone' => $utilisateur->telephone,
            'prenom' => $utilisateur->prenom,
            'nom_famille' => $utilisateur->nom_famille,
            'role' => $utilisateur->role,
            'id'=> $utilisateur->id,
        ],
    ]);
}

    // 🔹 Connexion
    public function loginkkk(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            $utilisateur = Utilisateur::where('email', $validated['email'])
                ->where('etat', 1)
                ->first();

            if (!$utilisateur || !Hash::check($validated['password'], $utilisateur->password)) {
                return response()->json([
                    'message' => '❌ Identifiants incorrects'
                ], 401);
            }

            // ⚡ Générer un token API (si Sanctum ou Passport est installé)
            $token = Str::random(60);

            // Stockage du token (optionnel selon ton système)
            $utilisateur->api_token = hash('sha256', $token);
            $utilisateur->save();

            return response()->json([
                'message' => '✅ Connexion réussie',
                'utilisateur' => $utilisateur,
                'token' => $token
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => '❌ Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // 🔹 Déconnexion
    public function logout(Request $request)
    {
        $utilisateur = $request->user();
        if ($utilisateur) {
            $utilisateur->api_token = null;
            $utilisateur->save();
        }

        return response()->json([
            'message' => '👋 Déconnecté avec succès'
        ], 200);
    }

    // 🔹 Récupérer l’utilisateur connecté
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}

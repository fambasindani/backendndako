<?php


namespace App\Http\Controllers;
use App\Models\Propriete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProprieteController extends Controller
{
    public function get_proprietes()
    {
        return Propriete::where('etat', true)->get();
    }



public function getallproprietes()
{ 
    return Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->get();
}



public function getAllProprietesFiltrees(Request $request)
{
    // 🛡️ Validation stricte
    $request->validate([
        'id_type' => 'required|integer',
        'nombre_chambre' => 'required|integer',
        'nombre_salle_de_bain' => 'required|integer',
        'prix_initiale' => 'required|numeric',
        'prix_final' => 'required|numeric',
    ]);

    // 🔍 Requête filtrée
    $query = Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->where('id_type', $request->id_type)
    ->where('nombre_chambre', $request->nombre_chambre)
    ->where('nombre_salle_de_bain', $request->nombre_salle_de_bain)
    ->whereBetween('prix', [$request->prix_initiale, $request->prix_final]);

    return response()->json($query->get());
}



public function getallproprieteIdUser($iduser)
{
    return Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->where('id_utilisateur', $iduser) // Utiliser la virgule pour les paramètres
    ->get();
}


public function getPremiersProprietes()
{
    return Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->orderBy('id', 'asc') // ou un autre champ pertinent
    ->take(10)
    ->get();
}

public function getDerniersProprietes()
{
    return Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->orderBy('id', 'desc') // ou 'created_at' si tu veux les plus récents
    ->take(10)
    ->get();
}



public function getToutPropriete()
{
    return Propriete::with([
        'province',
        'ville',
        'commune',
        'utilisateur',
        'typepropriete'
    ])
    ->orderBy('id', 'desc') // ou 'created_at' si tu veux les plus récents
    ->paginate(50);
}



public function getallproprietesId($id)
{ 
   return Propriete::with([
    'province',
    'ville',
    'commune',
    'utilisateur',
    'typepropriete'
])
->find($id);
}





   public function create_propriete(Request $request)
{
    try {
        $validated = $request->validate([
            'id_utilisateur' => 'required|integer',
            'id_type' => 'required|integer',
            'id_province' => 'required|integer',
            'id_ville' => 'required|integer',
            'id_commune' => 'required|integer',
            'quartier' => 'required|string|max:255',
            'avenue' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nombre_chambre' => 'required|numeric',
            'nombre_salle_de_bain' => 'required|numeric',
            'dimension' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'statut' => 'required|in:0,1',
            'image_principale' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'autres_images' => 'required|array',
            'autres_images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🔄 Cast explicite du statut en booléen
        $validated['statut'] = $validated['statut'] == 1;

        // 📁 Création des dossiers si nécessaires
        Storage::disk('public')->makeDirectory('images_principales');
        Storage::disk('public')->makeDirectory('autres_images');

        // 📥 Sauvegarde de l'image principale
        $validated['image_principale'] = $request->file('image_principale')->store('images_principales', 'public');

        // 📥 Sauvegarde des autres images
        $autresImagesPaths = [];
        if ($request->hasFile('autres_images')) {
            foreach ($request->file('autres_images') as $image) {
                $autresImagesPaths[] = $image->store('autres_images', 'public');
            }
        }
        $validated['autres_images'] = json_encode($autresImagesPaths);

        // 🏠 Création de la propriété
        $validated['statut1'] = false;
        $validated['etat'] = true;
        $validated['date_enregistrement'] = now();

        $propriete = Propriete::create($validated);

        return response()->json($propriete, 201);

    } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    }
}


    public function edit_propriete($id)
    {
        return Propriete::findOrFail($id);
    }

    public function update_propriete(Request $request, $id)
    {
        $propriete = Propriete::findOrFail($id);

        try {
            $validated = $request->validate([
                //'id_type' => 'required|integer',
                'quartier' => 'sometimes|string|max:255',
                'avenue' => 'sometimes|string|max:255',
                'prix' => 'sometimes|numeric',
                'nombre_chambre' => 'sometimes|numeric',
                'nombre_salle_de_bain' => 'sometimes|string|max:255',
                'dimension' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:500',
                'image_principale' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
                'autres_images.*' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
                 'latitude' => 'required|numeric',
                  'longitude' => 'required|numeric',
            ]);

            if ($request->hasFile('image_principale')) {
                $validated['image_principale'] = $request->file('image_principale')->store('images_principales', 'public');
            }

            if ($request->hasFile('autres_images')) {
                $autresImagesPaths = [];
                foreach ($request->file('autres_images') as $image) {
                    $autresImagesPaths[] = $image->store('autres_images', 'public');
                }
                $validated['autres_images'] = json_encode($autresImagesPaths);
            }

            $propriete->update($validated);

            return response()->json([
                'message' => 'Propriété mise à jour avec succès.',
                'data' => $propriete
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function delete_propriete($id)
    {
        $propriete = Propriete::findOrFail($id);
        $propriete->update(['etat' => false]);

        return response()->json(['message' => 'Propriété désactivée']);
    }
}


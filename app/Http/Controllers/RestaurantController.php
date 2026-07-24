<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    /**
     * Affiche ou permet de créer les informations du restaurant.
     */
    public function index(): View
    {
        $restaurant = Auth::user()->restaurant;

        return view('restaurant.index', compact('restaurant'));
    }

    /**
     * Enregistre ou met à jour le restaurant de l'utilisateur.
     */
    public function store(StoreRestaurantRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        // Gestion de l'upload du logo
        if ($request->hasFile('logo')) {
            // Si un ancien logo existe, on le supprime du stockage
            if ($user->restaurant && $user->restaurant->logo) {
                Storage::disk('public')->delete($user->restaurant->logo);
            }

            // Enregistrement de la nouvelle image dans storage/app/public/logos
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // updateOrCreate : crée si inexistant, ou met à jour si déjà présent
        $user->restaurant()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->route('restaurant.index')
            ->with('success', 'Les informations du restaurant ont été enregistrées avec succès !');
    }
}
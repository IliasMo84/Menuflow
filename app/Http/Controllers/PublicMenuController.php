<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMenuController extends Controller
{
    /**
     * Affiche le menu numérique du restaurant pour le client.
     */
    public function show(Request $request, string $slug): View
    {
        // Récupérer le restaurant actif avec ses catégories et leurs produits disponibles
        $restaurant = Restaurant::where('slug', $slug)
            ->with(['categories' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order', 'asc')
                    ->with(['products' => function ($pQuery) {
                        $pQuery->where('is_available', true);
                    }]);
            }])
            ->firstOrFail();

        // Récupérer les informations de la table si le code est présent
        $table = null;
        if ($request->has('table')) {
            $table = Table::where('restaurant_id', $restaurant->id)
                ->where('code', $request->query('table'))
                ->first();
        }

        return view('public.menu', compact('restaurant', 'table'));
    }
}
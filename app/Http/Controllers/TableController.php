<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTableRequest;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TableController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('restaurant.index')
                ->with('error', 'Veuillez d\'abord configurer votre restaurant.');
        }

        $tables = $restaurant->tables;

        return view('tables.index', compact('tables', 'restaurant'));
    }

    public function store(StoreTableRequest $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('restaurant.index')
                ->with('error', 'Veuillez d\'abord configurer votre restaurant.');
        }

        $restaurant->tables()->create([
            'number'   => $request->validated('number'),
            'capacity' => $request->validated('capacity'),
            'code'     => Str::random(12), // Génère un jeton unique pour l'URL du QR code
        ]);

        return redirect()->route('tables.index')
            ->with('success', 'Table ajoutée avec succès !');
    }

    public function destroy(Table $table): RedirectResponse
    {
        if ($table->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Table supprimée avec succès !');
    }
}
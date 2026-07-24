<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Affiche la liste des catégories du restaurant connecté.
     */
    public function index(): View|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('restaurant.index')
                ->with('error', 'Veuillez d\'abord configurer votre restaurant avant de gérer les catégories.');
        }

        $categories = $restaurant->categories;

        return view('categories.index', compact('categories'));
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('restaurant.index')
                ->with('error', 'Veuillez d\'abord configurer votre restaurant.');
        }

        $restaurant->categories()->create([
            'name'       => $request->validated('name'),
            'sort_order' => $request->validated('sort_order') ?? 0,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Met à jour une catégorie existante.
     */
    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {
        // Vérification de sécurité : la catégorie appartient bien au restaurant connecté
        if ($category->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $category->update([
            'name'       => $request->validated('name'),
            'sort_order' => $request->validated('sort_order') ?? 0,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprime une catégorie.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('restaurant.index')
                ->with('error', 'Veuillez d\'abord configurer votre restaurant.');
        }

        $products = Product::where('restaurant_id', $restaurant->id)
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(): View|RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $restaurant->categories->isEmpty()) {
            return redirect()->route('categories.index')
                ->with('error', 'Veuillez créer au moins une catégorie avant d\'ajouter des produits.');
        }

        $categories = $restaurant->categories;

        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->id;
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produit ajouté avec succès à la carte !');
    }

    public function edit(Product $product): View|RedirectResponse
    {
        if ($product->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $categories = Auth::user()->restaurant->categories;

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product): RedirectResponse
    {
        if ($product->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $data = $request->validated();
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produit supprimé de la carte !');
    }
}
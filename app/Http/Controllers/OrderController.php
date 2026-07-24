<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Enregistre une nouvelle commande venant du menu public.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id'      => 'nullable|exists:tables,id',
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
            'notes'         => 'nullable|string|max:500',
        ]);

        $restaurant = Restaurant::findOrFail($validated['restaurant_id']);

        // Calcul sécurisé du total côté serveur
        $total = 0;
        $orderItemsData = [];

        foreach ($validated['items'] as $itemData) {
            $product = Product::findOrFail($itemData['id']);
            $subtotal = $product->price * $itemData['qty'];
            $total += $subtotal;

            $orderItemsData[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'unit_price'   => $product->price,
                'quantity'     => $itemData['qty'],
                'subtotal'     => $subtotal,
            ];
        }

        // Création de la commande
        $order = Order::create([
            'restaurant_id'  => $restaurant->id,
            'table_id'       => $validated['table_id'] ?? null,
            'order_number'   => 'CMD-' . strtoupper(Str::random(6)),
            'total_amount'   => $total,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'notes'          => $validated['notes'] ?? null,
        ]);

        // Attachement des articles
        foreach ($orderItemsData as $item) {
            $order->items()->create($item);
        }

        return response()->json([
            'success'      => true,
            'message'      => 'Commande envoyée avec succès !',
            'order_number' => $order->order_number,
        ]);
    }
}
<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

    public function remove(Request $request, int $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->back()
            ->with('success', 'Item removed from cart.');
    }
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Get existing cart or empty array
        $cart = session()->get('cart', []);

        // If product already in cart → increase quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $validated['quantity'];
        } else {
            // Add new product
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'currency'   => $product->currency,
                'quantity'   => $validated['quantity'],
                'image'      => route('admin.images.preview', [
                    'model' => 'products',
                    'id'    => $product->id,
                ]),
                'is_digital' => $product->is_digital,
            ];
        }
        session()->put('cart', $cart);
        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
    }
}

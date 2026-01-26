<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $subtotal = $this->calculateSubtotal($cart);
        $shipping = $this->calculateShipping($cart);
        $total    = $subtotal + $shipping;

        return view('frontend.cart.index', compact(
            'cart',
            'subtotal',
            'shipping',
            'total'
        ));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => (float) $product->price,
                'currency'   => $product->currency,
                'quantity'   => (int) $validated['quantity'],
                'image'      => route('admin.images.preview', [
                    'model' => 'products',
                    'id'    => $product->id,
                ]),
                'is_digital' => (bool) $product->is_digital,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
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

    /* -------------------------------------------------
     |  Helpers
     | -------------------------------------------------
     */

    protected function calculateSubtotal(array $cart): float
    {
        return collect($cart)->sum(function ($item) {
            return (float) $item['price'] * (int) $item['quantity'];
        });
    }

    protected function calculateShipping(array $cart): float
    {
        $shippingPerItem = 3.99;

        return collect($cart)
            ->where('is_digital', false)
            ->sum(fn($item) => $shippingPerItem * (int) $item['quantity']);
    }
}

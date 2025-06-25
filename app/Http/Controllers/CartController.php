<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $cartItems = [];
        foreach ($products as $product) {
            $qty = $cart[$product->id] ?? 0;
            if ($qty > 0) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $qty,
                ];
            }
        }
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->inventory,
        ]);

        $cart = session()->get('cart', []);
        $newQty = ($cart[$product->id] ?? 0) + $request->quantity;

        if ($newQty > $product->inventory) {
            return back()->withErrors(['quantity' => "Cannot add more than available inventory ({$product->inventory})."]);
        }

        $cart[$product->id] = $newQty;

        session()->put('cart', $cart);

        return back()->with('success', "{$product->name} added to cart.");
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:' . $product->inventory,
        ]);

        $cart = session()->get('cart', []);

        if ($request->quantity == 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $request->quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', "{$product->name} removed from cart.");
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Your cart is empty.']);
        }

        DB::beginTransaction();

        try {
            $orderTotal = 0;
            $orderItemsData = [];

            foreach ($cart as $productId => $quantity) {
                $product = Product::lockForUpdate()->findOrFail($productId);

                if ($product->inventory < $quantity) {
                    return back()->withErrors(['cart' => "Not enough inventory for product {$product->name}."]);
                }

                $orderTotal += $product->price * $quantity;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price_each' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => $orderTotal,
            ]);

            foreach ($orderItemsData as $data) {
                $order->items()->create($data);
                // Deduct inventory
                $product = Product::find($data['product_id']);
                $product->inventory -= $data['quantity'];
                $product->save();
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['cart' => 'Failed to place order, please try again later.']);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->is_admin) {
            $orders = Order::paginate(10);
        } else {
            
            $orders = $user->orders()->with('items')->paginate(10);
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('inventory', '>', 0)->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        $orderTotal = 0;
        $orderItemsData = [];

        DB::beginTransaction();

        try {
            // Check inventory and total
            foreach ($validated['products'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);
                if ($product->inventory < $item['quantity']) {
                    return back()->withErrors(['inventory' => "Not enough inventory for product {$product->name}"]);
                }
                $orderTotal += $product->price * $item['quantity'];

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_each' => $product->price,
                ];

                // Deduct inventory
                $product->inventory -= $item['quantity'];
                $product->save();
            }

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total_price' => $orderTotal,
            ]);

            foreach ($orderItemsData as $data) {
                $order->items()->create($data);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to place order. Please try again.']);
        }
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        if (!$user->is_admin && $order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        abort(403); // Editing orders not supported for simplicity
    }

    public function update(Request $request, Order $order)
    {
        abort(403);
    }

    public function destroy(Order $order)
    {
        abort(403);
    }
}
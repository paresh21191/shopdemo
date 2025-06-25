<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();

        // Prepare last 7 days labels and order counts for chart
        $last7DaysLabels = [];
        $ordersLast7Days = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7DaysLabels[] = $date->format('M d'); // e.g. Apr 20

            // Count orders created on this date
            $ordersCount = Order::whereDate('created_at', $date)->count();
            $ordersLast7Days[] = $ordersCount;
        }

        return view('dashboard.index', compact(
            'totalPosts',
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'last7DaysLabels',
            'ordersLast7Days'
        ));
    }
}
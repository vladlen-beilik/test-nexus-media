<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'orders' => Order::with('customer')->paginate(5)
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        if($request->get('truncated')) {
            DB::table('customers')->truncate();
            DB::table('orders')->truncate();

            Artisan::call('app:get-shopify-data');

            DB::statement('ANALYZE TABLE customers');
            DB::statement('ANALYZE TABLE orders');
        }

        $orders = Order::with('customer')
            ->when($request->get('financialStatus'), function ($query) use ($request) {
                $query->where('financial_status', $request->get('financialStatus'));
            })->paginate(5, ['*'], 'page', $request->get('page'));

        return response()->json($orders);
    }
}

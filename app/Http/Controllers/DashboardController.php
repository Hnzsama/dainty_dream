<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        try {
            // Get total products
            $totalProducts = Product::count();
            
            // Get total stock value
            $totalStock = Product::sum(DB::raw('price * stock')) ?? 0;
            
            // Get total incoming transactions (Stock In)
            $totalStockIn = IncomingTransaction::sum('quantity') ?? 0;
            
            // Get total outgoing transactions (Stock Out)
            $totalStockOut = OutgoingTransaction::sum('quantity') ?? 0;
            
            // Get total transactions count
            $totalTransactions = IncomingTransaction::count() + OutgoingTransaction::count();
            
            // Get monthly revenue (from outgoing transactions)
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $monthlyRevenue = OutgoingTransaction::whereMonth('transaction_date', $currentMonth)
                ->whereYear('transaction_date', $currentYear)
                ->join('m_products', 't_outgoing_transactions.product_id', '=', 'm_products.id')
                ->sum(DB::raw('t_outgoing_transactions.quantity * m_products.price')) ?? 0;
            
            // Get monthly transaction data for the chart (current year)
            $monthlyData = [];
            for ($month = 1; $month <= 12; $month++) {
                $incomingCount = IncomingTransaction::whereMonth('transaction_date', $month)
                    ->whereYear('transaction_date', $currentYear)
                    ->count();
                
                $outgoingCount = OutgoingTransaction::whereMonth('transaction_date', $month)
                    ->whereYear('transaction_date', $currentYear)
                    ->count();
                
                $monthlyData[$month] = [
                    'incoming' => $incomingCount,
                    'outgoing' => $outgoingCount
                ];
            }
            
            // Get recent transactions (last 10, combined and sorted by date)
            $incomingTransactions = IncomingTransaction::with('product')
                ->orderBy('transaction_date', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($tx) {
                    return (object) [
                        'type' => 'Incoming',
                        'product_name' => $tx->product->name ?? 'Unknown Product',
                        'quantity' => $tx->quantity,
                        'transaction_date' => $tx->transaction_date,
                        'price' => $tx->price
                    ];
                });
            
            $outgoingTransactions = OutgoingTransaction::with('product')
                ->orderBy('transaction_date', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($tx) {
                    return (object) [
                        'type' => 'Outgoing',
                        'product_name' => $tx->product->name ?? 'Unknown Product',
                        'quantity' => $tx->quantity,
                        'transaction_date' => $tx->transaction_date,
                        'price' => $tx->price
                    ];
                });
            
            // Merge and sort by transaction date (most recent first)
            $recentTransactions = $incomingTransactions->concat($outgoingTransactions)
                ->sortByDesc('transaction_date')
                ->take(10);
                
        } catch (\Exception $e) {
            $totalProducts = 0;
            $totalStock = 0;
            $totalStockIn = 0;
            $totalStockOut = 0;
            $totalTransactions = 0;
            $monthlyRevenue = 0;
            $monthlyData = array_fill(1, 12, ['incoming' => 0, 'outgoing' => 0]);
            $recentTransactions = collect();
        }
        
        return view('dashboard', [
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalStockIn' => $totalStockIn,
            'totalStockOut' => $totalStockOut,
            'totalTransactions' => $totalTransactions,
            'monthlyRevenue' => $monthlyRevenue,
            'recentTransactions' => $recentTransactions,
            'monthlyData' => $monthlyData ?? array_fill(1, 12, ['incoming' => 0, 'outgoing' => 0]),
        ]);
    }
}

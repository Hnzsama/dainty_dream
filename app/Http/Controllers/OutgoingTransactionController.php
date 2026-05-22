<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = OutgoingTransaction::with('product', 'customer');
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('customer', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $transactions = $query->paginate(5)->appends(request()->query());
        return view('outgoing.index', ['transactions' => $transactions, 'products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function create(): View
    {
        return view('outgoing.create', ['products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        OutgoingTransaction::create($request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/outgoing')->with('msg', 'Stock out recorded!');
    }

    public function edit(OutgoingTransaction $outgoing): View
    {
        return view('outgoing.edit', ['transaction' => $outgoing, 'products' => Product::all(), 'customers' => Customer::all()]);
    }

    public function update(Request $request, OutgoingTransaction $outgoing): RedirectResponse
    {
        $outgoing->update($request->validate([
            'product_id' => 'required',
            'customer_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/outgoing')->with('msg', 'Stock out updated!');
    }

    public function destroy(OutgoingTransaction $outgoing): RedirectResponse
    {
        $outgoing->delete();
        return redirect('/outgoing')->with('msg', 'Stock out deleted!');
    }
}

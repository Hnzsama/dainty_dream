<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomingTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = IncomingTransaction::with('product', 'supplier');
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('supplier', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $transactions = $query->paginate(5)->appends(request()->query());
        return view('incoming.index', ['transactions' => $transactions, 'products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function create(): View
    {
        return view('incoming.create', ['products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        IncomingTransaction::create($request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/incoming')->with('msg', 'Stock in recorded!');
    }

    public function edit(IncomingTransaction $incoming): View
    {
        return view('incoming.edit', ['transaction' => $incoming, 'products' => Product::all(), 'suppliers' => Supplier::all()]);
    }

    public function update(Request $request, IncomingTransaction $incoming): RedirectResponse
    {
        $incoming->update($request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_date' => 'required|date'
        ]));
        return redirect('/incoming')->with('msg', 'Stock in updated!');
    }

    public function destroy(IncomingTransaction $incoming): RedirectResponse
    {
        $incoming->delete();
        return redirect('/incoming')->with('msg', 'Stock in deleted!');
    }
}

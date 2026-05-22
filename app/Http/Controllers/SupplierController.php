<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $query = Supplier::query();
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return view('suppliers.index', ['suppliers' => $query->paginate(5)->appends(request()->query())]);
    }

    public function create(): View
    {
        return view('suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Supplier::create($request->validate(['name' => 'required', 'address' => 'nullable', 'phone' => 'nullable']));
        return redirect('/suppliers')->with('msg', 'Supplier added!');
    }

    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validate(['name' => 'required', 'address' => 'nullable', 'phone' => 'nullable']));
        return redirect('/suppliers')->with('msg', 'Supplier updated!');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();
        return redirect('/suppliers')->with('msg', 'Supplier deleted!');
    }
}

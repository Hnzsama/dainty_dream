<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::query();
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return view('customers.index', ['customers' => $query->paginate(5)->appends(request()->query())]);
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Customer::create($request->validate(['name' => 'required', 'address' => 'nullable', 'phone' => 'nullable']));
        return redirect('/customers')->with('msg', 'Customer added!');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validate(['name' => 'required', 'address' => 'nullable', 'phone' => 'nullable']));
        return redirect('/customers')->with('msg', 'Customer updated!');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect('/customers')->with('msg', 'Customer deleted!');
    }
}

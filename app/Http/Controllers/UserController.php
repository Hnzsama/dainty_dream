<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }
        
        return view('users.index', ['users' => $query->paginate(5)->appends(request()->query())]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:m_users',
            'password' => 'required|min:3',
            'phone' => 'nullable'
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect('/users')->with('msg', 'User added!');
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:3',
            'phone' => 'nullable'
        ]);
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect('/users')->with('msg', 'User updated!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect('/users')->with('msg', 'User deleted!');
    }
}

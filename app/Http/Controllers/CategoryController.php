<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::query();
        
        if ($request->has('search') && $request->get('search') !== '') {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        return view('categories.index', ['categories' => $query->paginate(5)->appends(request()->query())]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Category::create($request->validate(['name' => 'required']));
        return redirect('/categories')->with('msg', 'Category added!');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->update($request->validate(['name' => 'required']));
        return redirect('/categories')->with('msg', 'Category updated!');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect('/categories')->with('msg', 'Category deleted!');
    }
}

@extends('layouts.app')

@section('page-title', 'Edit Category')

@section('content')
<div class="form-container">
    <div class="form-title">🏷️ Edit Category</div>

    <form method="POST" action="{{ url('/categories/' . $category->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Category</button>
            <a href="{{ url('/categories') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

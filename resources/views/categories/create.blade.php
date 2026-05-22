@extends('layouts.app')

@section('page-title', 'Add Category')

@section('content')
<div class="form-container">
    <div class="form-title">🏷️ Add New Category</div>

    <form method="POST" action="{{ url('/categories') }}">
        @csrf

        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Category</button>
            <a href="{{ url('/categories') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

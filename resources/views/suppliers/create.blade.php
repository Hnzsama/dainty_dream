@extends('layouts.app')

@section('page-title', 'Add Supplier')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('SupplierAdd.png') }}" alt="supplier icon" class="form-icon"> Add New Supplier</div>

    <form method="POST" action="{{ url('/suppliers') }}">
        @csrf

        <div class="form-group">
            <label>Supplier Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="4">{{ old('address') }}</textarea>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Supplier</button>
            <a href="{{ url('/suppliers') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

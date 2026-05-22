@extends('layouts.app')

@section('page-title', 'Edit Customer')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('CustomerAdd.png') }}" alt="customer icon" class="form-icon"> Edit Customer</div>

    <form method="POST" action="{{ url('/customers/' . $customer->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="4">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Customer</button>
            <a href="{{ url('/customers') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('page-title', 'Edit Incoming Goods')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('StockInAdd.png') }}" alt="incoming icon" class="form-icon"> Edit Incoming Goods</div>

    @if ($errors->any())
        <div style="background: #FFE8E8; color: #A04040; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #F5A8A8;">
            <strong>Please fix the errors below:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/incoming/' . $transaction->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Product</label>
            <select name="product_id" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $transaction->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity', $transaction->quantity) }}" required>
            </div>
            <div class="form-group">
                <label>Unit Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $transaction->price) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Incoming</button>
            <a href="{{ url('/incoming') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection

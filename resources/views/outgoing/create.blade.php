@extends('layouts.app')

@section('page-title', 'Add Outgoing Goods')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('StockOutAdd.png') }}" alt="outgoing icon" class="form-icon"> Add Outgoing Goods</div>

    <form method="POST" action="{{ url('/outgoing') }}">
        @csrf

        <div class="form-group">
            <label>Product</label>
            <select name="product_id" id="product_id" required onchange="autoFillPrice()">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Customer</label>
            <select name="customer_id" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="{{ old('quantity') }}" required>
            </div>
            <div class="form-group">
                <label>Unit Price</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Outgoing</button>
            <a href="{{ url('/outgoing') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
    function autoFillPrice() {
        const productSelect = document.getElementById('product_id');
        const priceInput = document.getElementById('price');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        if (price) {
            priceInput.value = price;
        }
    }
</script>
@endsection

@extends('layouts.app')

@section('page-title', 'Add Incoming Goods')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('StockInAdd.png') }}" alt="incoming icon" class="form-icon"> Add Incoming Goods</div>

    <form method="POST" action="{{ url('/incoming') }}">
        @csrf

        <div class="form-group">
            <label>Product</label>
            <select name="product_id" id="product_id" required onchange="autoFillSupplier()">
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-supplier-id="{{ $product->supplier_id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" id="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
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
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Add Incoming</button>
            <a href="{{ url('/incoming') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<script>
    function autoFillSupplier() {
        const productSelect = document.getElementById('product_id');
        const supplierSelect = document.getElementById('supplier_id');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const supplierId = selectedOption.getAttribute('data-supplier-id');
        
        if (supplierId) {
            supplierSelect.value = supplierId;
        }
    }
</script>
@endsection

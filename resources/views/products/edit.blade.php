@extends('layouts.app')

@section('page-title', 'Edit Product')

@section('content')
<div class="form-container">
    <div class="form-title"><img src="{{ asset('ClothingItemAdd.png') }}" alt="product icon" class="form-icon"> Edit Item</div>

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

    <form method="POST" action="{{ url('/products/' . $product->id) }}">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Product</button>
            <a href="{{ url('/products') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
                    <div class="form-group">
                        <label for="name">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id">Category *</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier_id">Supplier *</label>
                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock Quantity *</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="condition_status">Condition Status</label>
                    <input type="text" id="condition_status" name="condition_status" placeholder="e.g., Like New, Good, Fair" value="{{ old('condition_status', $product->condition_status) }}">
                </div>

                <div class="btn-group">
                    <button type="submit">Update Product</button>
                    <a href="{{ url('/products') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

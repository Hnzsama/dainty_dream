<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Incoming - Dainty Dream</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
            padding: 15px 40px;
            box-shadow: 0 5px 20px rgba(6, 182, 212, 0.2);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.1);
        }

        h1 {
            color: #0c4a6e;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #0c4a6e;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #cffafe;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #f0f9ff;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        button, .btn-cancel {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        button {
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 100%);
            color: white;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #0c4a6e;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #dc2626;
        }

        @media (max-width: 480px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>👗 Dainty Dream - Edit Incoming</h2>
    </div>

    <div class="container">
        <div class="form-card">
            <h1><img src="{{ asset('StockInAdd.png') }}" alt="incoming icon" style="height: 30px; width: 30px; margin-right: 10px; vertical-align: middle;"> Edit Incoming Transaction</h1>

            @if ($errors->any())
                <div class="error-message">
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

                <div class="form-row">
                    <div class="form-group">
                        <label for="product_id">Product *</label>
                        <select id="product_id" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier_id">Supplier *</label>
                        <select id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $transaction->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $transaction->quantity) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction_date">Date *</label>
                        <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date) }}" required>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit">Update Transaction</button>
                    <a href="{{ url('/incoming') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

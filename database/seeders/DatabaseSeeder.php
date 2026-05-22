<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Customer;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dainty.com',
            'password' => Hash::make('123'),
            'phone' => '08123456789'
        ]);

        // Create categories
        Category::create(['name' => 'T-Shirt']);
        Category::create(['name' => 'Jacket']);
        Category::create(['name' => 'Pants']);

        // Create supplier
        $supplier = Supplier::create([
            'name' => 'Thrift Supplier',
            'address' => 'Surabaya',
            'phone' => '082233445566'
        ]);

        // Create product
        Product::create([
            'sku' => 'SKU001',
            'name' => 'Vintage T-Shirt',
            'category_id' => 1,
            'supplier_id' => 1,
            'price' => 75000,
            'stock' => 10
        ]);

        // Create customer
        $customer = Customer::create([
            'name' => 'Budi',
            'address' => 'Surabaya',
            'phone' => '081298765432'
        ]);

        // Create sample transactions
        IncomingTransaction::create([
            'product_id' => 1,
            'supplier_id' => 1,
            'quantity' => 10,
            'price' => 5.00,
            'transaction_date' => now()->toDateString()
        ]);

        OutgoingTransaction::create([
            'product_id' => 1,
            'customer_id' => 1,
            'quantity' => 2,
            'price' => 10.00,
            'transaction_date' => now()->toDateString()
        ]);
    }
}

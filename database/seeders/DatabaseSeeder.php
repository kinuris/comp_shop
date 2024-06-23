<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Gender;
use App\Models\GeneralDiscount;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductSnapshot;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gender::create([
        //     'gender' => 'Male'
        // ]);

        // Gender::create([
        //     'gender' => 'Female'
        // ]);

        // Role::create([
        //     'role' => 'Employee'
        // ]);

        // Role::create([
        //     'role' => 'Manager'
        // ]);

        // Role::create([
        //     'role' => 'Admin'
        // ]);

        // Category::create([
        //     'category' => 'Laptops'
        // ]);

        // Category::create([
        //     'category' => 'Monitors'
        // ]);

        // Category::create([
        //     'category' => 'Power Supply'
        // ]);

        // Category::create([
        //     'category' => 'Storage'
        // ]);

        // Category::create([
        //     'category' => 'Memory'
        // ]);

        // Category::create([
        //     'category' => 'Motherboard'
        // ]);

        // Category::create([
        //     'category' => 'CPU'
        // ]);

        // Category::create([
        //     'category' => 'GPU'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Asus'
        // ]);

        // Supplier::create([
        //     'company_name' => 'MSI'
        // ]);

        // Supplier::create([
        //     'company_name' => 'HP'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Apple'
        // ]);

        // Supplier::create([
        //     'company_name' => 'AMD'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Intel'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Logitech'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Lenovo'
        // ]);

        // Supplier::create([
        //     'company_name' => 'LG'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Samsung'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Seasonic'
        // ]);

        // Supplier::create([
        //     'company_name' => 'EVGA'
        // ]);

        // Supplier::create([
        //     'company_name' => 'Gigabyte'
        // ]);

        // PaymentMethod::create([
        //     'method_name' => 'Credit Card',
        //     'available' => true,
        // ]);

        // PaymentMethod::create([
        //     'method_name' => 'Debit Card',
        //     'available' => true,
        // ]);

        // PaymentMethod::create([
        //     'method_name' => 'Cash',
        //     'available' => true,
        // ]);

        // Discount::createPercentageDiscount("Senior's Discount", 20);
        // Discount::createPercentageDiscount('PWD Discount', 20);

        // GeneralDiscount::create([
        //     'fk_discount' => 1
        // ]);

        // GeneralDiscount::create([
        //     'fk_discount' => 2
        // ]);

        // User::factory(10)->create();
        // // Product::factory(20)->create();

        // foreach (Product::all() as $product) {
        //     ProductSnapshot::create([
        //         'product_name' => $product->product_name,
        //         'fk_product' => $product->id,
        //         'fk_category' => $product->fk_category,
        //         'fk_supplier' => $product->fk_supplier,
        //         'price' => $product->price,
        //         'fk_user' => 1,
        //     ]);
        // }
        $file = file_get_contents('database/migrations/comp_shop_db.sql');

        DB::unprepared('DROP DATABASE comp_shop_db; CREATE DATABASE comp_shop_db; USE comp_shop_db;' . $file);
    }
}

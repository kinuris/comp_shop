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
        $male = Gender::create([
            'gender' => 'Male'
        ]);

        $female = Gender::create([
            'gender' => 'Female'
        ]);

        $manager = Role::create([
            'role' => 'Manager'
        ]);

        $admin = Role::create([
            'role' => 'Admin'
        ]);

        // Category::create(['category' => 'Engine Components']);
        // Category::create(['category' => 'Electrical Components']);
        // Category::create(['category' => 'Braking System']);
        // Category::create(['category' => 'Suspension and Steering']);
        // Category::create(['category' => 'Fuel System']);
        // Category::create(['category' => 'Transmission and Drivetrain']);
        // Category::create(['category' => 'Exhaust System']);
        // Category::create(['category' => 'Wheels and Tires']);
        // Category::create(['category' => 'Body and Frame']);
        // Category::create(['category' => 'Control and Handlebar']);
        // Category::create(['category' => 'Lighting and Indicators']);
        // Category::create(['category' => 'Cooling System']);
        // Category::create(['category' => 'Accessories and Add-ons']);
        Category::create(['category' => 'NOCATEGORY']);

        // Supplier::create(['company_name' => 'Shimano']);
        // Supplier::create(['company_name' => 'SRAM']);
        // Supplier::create(['company_name' => 'Campagnolo']);
        // Supplier::create(['company_name' => 'Crankbrothers']);
        // Supplier::create(['company_name' => 'FSA (Full Speed Ahead)']);
        // Supplier::create(['company_name' => 'Rocky Mountain']);
        // Supplier::create(['company_name' => 'Rotor Components']);
        // Supplier::create(['company_name' => 'HED Wheels']);
        // Supplier::create(['company_name' => 'Giro']);
        // Supplier::create(['company_name' => 'Bell Helmets']);
        // Supplier::create(['company_name' => 'Castelli']);
        // Supplier::create(['company_name' => 'Wahoo Fitness']);
        // Supplier::create(['company_name' => 'Blackburn']);
        // Supplier::create(['company_name' => 'Xlab']);
        // Supplier::create(['company_name' => 'SeaSucker']);
        Supplier::create(['company_name' => 'NOCOMPANY']);

        PaymentMethod::create([
            'method_name' => 'GCash',
            'available' => true,
        ]);

        PaymentMethod::create([
            'method_name' => 'Bank Transfer',
            'available' => true,
        ]);

        PaymentMethod::create([
            'method_name' => 'Home Credit',
            'available' => true,
        ]);

        PaymentMethod::create([
            'method_name' => 'Cash',
            'available' => true,
        ]);

        Discount::createPercentageDiscount("Senior's Discount", 20);
        Discount::createPercentageDiscount('PWD Discount', 20);

        GeneralDiscount::create([
            'fk_discount' => 1
        ]);

        GeneralDiscount::create([
            'fk_discount' => 2
        ]);

        // User::factory(10)->create();
        User::query()->create([
            'fk_role' => $admin->id,
            'fk_gender' => $male->id,
            'first_name' => 'Bhon',
            'middle_name' => null,
            'last_name' => 'Durana',
            'company_id' => 'HP-0000',
            'birthdate' => '2024-12-12',
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'suspended' => false,
            'contact_number' => '09999999999',
        ]);

        User::query()->create([
            'fk_role' => $manager->id,
            'fk_gender' => $male->id,
            'first_name' => 'Bhon',
            'middle_name' => null,
            'last_name' => 'Durana',
            'company_id' => 'HP-0001',
            'birthdate' => '2024-12-12',
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'suspended' => false,
            'contact_number' => '09999999999',
        ]);

        // User::query()->create([
        //     'fk_role' => $employee->id,
        //     'fk_gender' => $male->id,
        //     'first_name' => 'Employee',
        //     'middle_name' => 'Zekie',
        //     'last_name' => 'Nigeria',
        //     'company_id' => 'HP-0002',
        //     'birthdate' => '2024-12-12',
        //     'password' => password_hash('password', PASSWORD_BCRYPT),
        //     'suspended' => false,
        //     'contact_number' => '09999999999',
        // ]);

        foreach (Product::all() as $product) {
            ProductSnapshot::create([
                'product_name' => $product->product_name,
                'fk_product' => $product->id,
                'fk_category' => $product->fk_category,
                'fk_supplier' => $product->fk_supplier,
                'price' => $product->price,
                'fk_user' => 1,
            ]);
        }
        // $file = file_get_contents('database/migrations/comp_shop_db.sql');

        // DB::unprepared('DROP DATABASE comp_shop_db; CREATE DATABASE comp_shop_db; USE comp_shop_db;' . $file);
    }
}

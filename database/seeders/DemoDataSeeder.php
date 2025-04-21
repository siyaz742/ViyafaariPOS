<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Faker\Generator as Faker;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        Customer::insert([
            ['name' => 'Walk-in Customer', 'email' => 'N/A', 'phone' => 'N/A', 'address' => 'N/A', 'tin' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alice Smith', 'email' => 'alice.smith@email.com', 'phone' => '759-123', 'address' => '456 Oak St, Town B', 'tin' => '9876543', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Michael Johnson', 'email' => 'michael.j@email.com', 'phone' => '912-456', 'address' => '789 Pine St, City C', 'tin' => '7239874', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emma Brown', 'email' => 'emma.brown@email.com', 'phone' => '784-789', 'address' => '321 Maple Ave, City D', 'tin' => '7543219', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oliver Wilson', 'email' => 'oliver.w@email.com', 'phone' => '934-567', 'address' => '654 Elm St, City E', 'tin' => '7894561', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sophia Davis', 'email' => 'sophia.d@email.com', 'phone' => '798-234', 'address' => '987 Cedar Blvd, City F', 'tin' => '7567893', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'James Martinez', 'email' => 'james.m@email.com', 'phone' => '723-567', 'address' => '258 Walnut St, City G', 'tin' => '9216549', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Isabella Garcia', 'email' => 'isabella.g@email.com', 'phone' => '905-876', 'address' => '147 Cherry Ln, City H', 'tin' => '7541237', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'William Rodriguez', 'email' => 'william.r@email.com', 'phone' => '766-543', 'address' => '369 Birch St, City I', 'tin' => '9873216', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mia Hernandez', 'email' => 'mia.h@email.com', 'phone' => '976-321', 'address' => '258 Spruce Ct, City J', 'tin' => '9234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ethan Lee', 'email' => 'ethan.l@email.com', 'phone' => '718-654', 'address' => '789 Fir St, City K', 'tin' => '9871236', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Vendor::insert([
            ['name' => 'Gemstone Gallery', 'email' => 'info@gemstonegallery.com', 'phone' => '759321', 'address' => '123 Jewel St, Crystal City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Precious Stones Co.', 'email' => 'contact@preciousstones.com', 'phone' => '912654', 'address' => '456 Gem Ave, Sparkle Town', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'The Jewel Box', 'email' => 'hello@jewelbox.com', 'phone' => '784123', 'address' => '789 Diamond Rd, Gem City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Elite Gem Traders', 'email' => 'support@elitegemtraders.com', 'phone' => '934567', 'address' => '321 Ruby Ln, Luxury Valley', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Crystal Clear Gems', 'email' => 'sales@crystalcleargems.com', 'phone' => '798765', 'address' => '654 Opal Way, Radiant Hills', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nature’s Gems', 'email' => 'info@naturesgems.com', 'phone' => '723456', 'address' => '987 Emerald Blvd, Shiny City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gems of Distinction', 'email' => 'contact@gemsofdistinction.com', 'phone' => '905321', 'address' => '258 Sapphire St, Precious Valley', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'The Gem Emporium', 'email' => 'info@thegememporium.com', 'phone' => '766543', 'address' => '369 Topaz Ct, Glittering Shores', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Treasured Gems', 'email' => 'sales@treasuredgems.com', 'phone' => '976321', 'address' => '147 Citrine Pl, Jewel City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bespoke Gemstones', 'email' => 'hello@bespokegemstones.com', 'phone' => '718765', 'address' => '258 Amethyst Way, Radiant Hills', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Product::insert([
            ['name' => 'Ruby', 'description' => 'Vibrant red gemstone, 1.5 carats, excellent clarity', 'price' => 2000, 'stock_quantity' => 308, 'vendor_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sapphire', 'description' => 'Deep blue sapphire, 2.0 carats, exquisite cut', 'price' => 2500, 'stock_quantity' => 258, 'vendor_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emerald', 'description' => 'Rich green emerald, 1.2 carats, eye-clean', 'price' => 3000, 'stock_quantity' => 158, 'vendor_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Amethyst', 'description' => 'Beautiful purple amethyst, 3.0 carats, premium quality', 'price' => 500, 'stock_quantity' => 100, 'vendor_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Topaz', 'description' => 'Golden yellow topaz, 2.5 carats, stunning brilliance', 'price' => 700, 'stock_quantity' => 400, 'vendor_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Diamond', 'description' => 'Round brilliant diamond, 1.0 carat, D color, VVS1 clarity', 'price' => 5000, 'stock_quantity' => 200, 'vendor_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Opal', 'description' => 'Fire opal, 1.8 carats, vivid play-of-color', 'price' => 1200, 'stock_quantity' => 350, 'vendor_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Garnet', 'description' => 'Deep red garnet, 2.0 carats, excellent luster', 'price' => 300, 'stock_quantity' => 150, 'vendor_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aquamarine', 'description' => 'Light blue aquamarine, 2.2 carats, stunning clarity', 'price' => 800, 'stock_quantity' => 600, 'vendor_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        User::create([
            'name' => 'Cashier',
            'email' => 'cashier@example.com',
            'password' => bcrypt('password'),
            'role' => 'Staff',
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
            'role' => 'Admin',
            'permissions' => ['C1','C2','C3','C4', 'C5',
                'O1','O2','O3',
                'P1','P2','P3','P4', 'P5', 'P6',
                'R1',
                'U1','U2','U3','U4', 'U5',
                'V1', 'V2', 'V3', 'V4', 'V5'],
        ]);

        $this->createOrders(500);

    }


    private function createOrders($orderCount)
    {
        // Get some sample customers, employees (users), and products from the database
        $customers = Customer::all();
        $employees = User::where('role', 'Staff')->get(); // Assuming staff for employees
        $products = Product::all();

        // Create Faker instance for random data
        $faker = \Faker\Factory::create();

        // Create multiple orders
        foreach (range(1, $orderCount) as $index) {
            $customer = $customers->random();
            $employee = $employees->random();

            // Generate a random date within the range
            $startDate = Carbon::create('2024', '01', '01');
            $endDate = Carbon::create('2024', '12', '31');
            $randomDate = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
            $randomTime = $faker->time('H:i:s');

            // Create an order without the total for now
            $order = Order::create([
                'customer_id' => $customer->id,
                'employee_id' => $employee->id,
                'invoice_date' => $randomDate,
                'invoice_time' => $randomTime,
                'total' => 0, // Temporary value, will update later
                'payment_method' => $this->getRandomPaymentMethod(),
            ]);

            // Create order items for the order
            $this->createOrderItems($order, $products);

            // Calculate the total for the order
            $orderTotal = OrderItem::where('order_id', $order->id)->sum('item_total');

            // Update the order with the calculated total
            $order->update(['total' => $orderTotal]);
        }
    }



    private function getRandomPaymentMethod()
    {
        $paymentMethods = ['Cash', 'Credit Card', 'Bank Transfer', 'Mobile Payment'];
        return $paymentMethods[array_rand($paymentMethods)];
    }

    private function createOrderItems(Order $order, $products)
    {
        $addedProductIds = []; // Keep track of product IDs already added to the order

        foreach (range(1, rand(1, 5)) as $index) {
            // Randomly pick a product, but ensure it's not already added
            do {
                $product = $products->random();
            } while (in_array($product->id, $addedProductIds)); // Keep looping until a new product is selected

            // Add the product to the list of added product IDs
            $addedProductIds[] = $product->id;

            $discount = rand(0, 10);

            // Random quantity for the product
            $quantity = rand(1, 3);
            $itemTotal = ($product->price * (1 - ($discount / 100))) * $quantity;


            // Create the order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'item_sale_price' => $product->price,
                'discount' => $discount, // Random discount between 0 and 10%
                'quantity' => $quantity,
                'item_total' => $itemTotal,
            ]);
        }
    }


}

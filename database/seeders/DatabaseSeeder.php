<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('adminpassword'),
            'role' => 'Admin',
            'permissions' => ['C1','C2','C3','C4', 'C5',
                'O1','O2','O3',
                'P1','P2','P3','P4', 'P5', 'P6',
                'R1',
                'U1','U2','U3','U4', 'U5',
                'V1', 'V2', 'V3', 'V4', 'V5'],
        ]);


    }

}


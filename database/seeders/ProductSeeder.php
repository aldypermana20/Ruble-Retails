<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Vegetables
            [
                'name' => 'Beetroot',
                'type' => 'Vegetables',
                'weight' => '500 gm',
                'price' => 20000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/1514/1514935.png'
            ],
            [
                'name' => 'Broccoli',
                'type' => 'Vegetables',
                'weight' => '1 pc',
                'price' => 30000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/234/234661.png'
            ],
            [
                'name' => 'Organic Carrot',
                'type' => 'Vegetables',
                'weight' => '1 kg',
                'price' => 15000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/4056/4056825.png'
            ],
            [
                'name' => 'Fresh Spinach',
                'type' => 'Vegetables',
                'weight' => '1 bunch',
                'price' => 12000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/234/234694.png'
            ],
            [
                'name' => 'Red Tomato',
                'type' => 'Vegetables',
                'weight' => '1 kg',
                'price' => 18000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2909/2909841.png'
            ],
            [
                'name' => 'Cucumber',
                'type' => 'Vegetables',
                'weight' => '500 gm',
                'price' => 10000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/3143/3143632.png'
            ],
            [
                'name' => 'Bell Pepper',
                'type' => 'Vegetables',
                'weight' => '1 pc',
                'price' => 8000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/765/765587.png'
            ],

            // Fruits
            [
                'name' => 'Avocado',
                'type' => 'Fruits',
                'weight' => '500 gm',
                'price' => 19000,
                'image' => 'https://cdn-icons-png.flaticon.com/128/2079/2079249.png'
            ],
            [
                'name' => 'Banana',
                'type' => 'Fruits',
                'weight' => '1 kg',
                'price' => 22000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2909/2909761.png'
            ],
            [
                'name' => 'Fuji Apple',
                'type' => 'Fruits',
                'weight' => '1 kg',
                'price' => 35000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2909/2909787.png'
            ],
            [
                'name' => 'Sweet Orange',
                'type' => 'Fruits',
                'weight' => '1 kg',
                'price' => 30000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2909/2909832.png'
            ],
            [
                'name' => 'Grapes',
                'type' => 'Fruits',
                'weight' => '500 gm',
                'price' => 40000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/590/590708.png'
            ],
            [
                'name' => 'Watermelon',
                'type' => 'Fruits',
                'weight' => '1 pc',
                'price' => 500,
                'image' => 'https://cdn-icons-png.flaticon.com/512/3143/3143636.png'
            ],

            // Meat & Fish
            [
                'name' => 'Beef Mixed',
                'type' => 'Meat & Fish',
                'weight' => '1 kg',
                'price' => 120000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/3082/3082055.png'
            ],
            [
                'name' => 'Chicken Breast',
                'type' => 'Meat & Fish',
                'weight' => '1 kg',
                'price' => 55000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/10609/10609235.png'
            ],
            [
                'name' => 'Salmon Fillet',
                'type' => 'Meat & Fish',
                'weight' => '500 gm',
                'price' => 150000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/4809/4809697.png'
            ],
            [
                'name' => 'Burger Patty',
                'type' => 'Meat & Fish',
                'weight' => '1 kg',
                'price' => 95000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/9160/9160549.png'
            ],
            [
                'name' => 'Tuna Steak',
                'type' => 'Meat & Fish',
                'weight' => '500 gm',
                'price' => 85000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/1158/1158869.png'
            ],

            // Dairy & Milk
            [
                'name' => 'Fresh Milk',
                'type' => 'Dairy & Milk',
                'weight' => '1 L',
                'price' => 29000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2405/2405458.png'
            ],
            [
                'name' => 'Cheddar Cheese',
                'type' => 'Dairy & Milk',
                'weight' => '200 gm',
                'price' => 45000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/819/819827.png'
            ],
            [
                'name' => 'Yogurt',
                'type' => 'Dairy & Milk',
                'weight' => '500 ml',
                'price' => 65000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/5029/5029324.png'
            ],
            [
                'name' => 'Salted Butter',
                'type' => 'Dairy & Milk',
                'weight' => '200 gm',
                'price' => 35000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/837/837560.png'
            ],
            [
                'name' => 'Eggs',
                'type' => 'Dairy & Milk',
                'weight' => '10 pcs',
                'price' => 28000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/1047/1047759.png'
            ],

            // Snacks
            [
                'name' => 'Cold Sprite',
                'type' => 'Snacks',
                'weight' => '500 ml',
                'price' => 15000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2405/2405479.png'
            ],
            [
                'name' => 'Potato Chips',
                'type' => 'Snacks',
                'weight' => '150 gm',
                'price' => 25000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2553/2553629.png'
            ],
            [
                'name' => 'Chocolate Cookies',
                'type' => 'Snacks',
                'weight' => '200 gm',
                'price' => 35000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/541/541732.png',
            ],
            [
                'name' => 'Popcorn',
                'type' => 'Snacks',
                'weight' => '100 gm',
                'price' => 20000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/2553/2553663.png'
            ],
            [
                'name' => 'Pretzels',
                'type' => 'Snacks',
                'weight' => '150 gm',
                'price' => 28000,
                'image' => 'https://cdn-icons-png.flaticon.com/512/1468/1468950.png'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
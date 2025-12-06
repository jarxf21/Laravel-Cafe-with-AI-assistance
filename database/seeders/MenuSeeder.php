<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categories
        $categories = [
            [
                'name' => 'Coffee',
                'slug' => 'coffee',
                'is_active' => true,
                'image' => 'categories/coffee.jpg', 
            ],
            [
                'name' => 'Non-Coffee',
                'slug' => 'non-coffee',
                'is_active' => true,
                'image' => 'categories/non-coffee.jpg',
            ],
            [
                'name' => 'Snack',
                'slug' => 'snack',
                'is_active' => true,
                'image' => 'categories/snack.jpg',
            ],
            [
                'name' => 'Main Course',
                'slug' => 'main-course',
                'is_active' => true,
                'image' => 'categories/main-course.jpg',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Get Category IDs
        $coffee = Category::where('slug', 'coffee')->first();
        $nonCoffee = Category::where('slug', 'non-coffee')->first();
        $snack = Category::where('slug', 'snack')->first();
        $mainCourse = Category::where('slug', 'main-course')->first();

        // 2. Products
        $products = [
            // Coffee
            [
                'category_id' => $coffee->id,
                'name' => 'Espresso',
                'slug' => 'espresso',
                'description' => 'Rich and intense shot of pure coffee.',
                'price' => 18000,
                'is_available' => true,
                'stock' => 100,
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Americano',
                'slug' => 'americano',
                'description' => 'Espresso diluted with hot water.',
                'price' => 20000,
                'is_available' => true,
                'stock' => 100,
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Cappuccino',
                'slug' => 'cappuccino',
                'description' => 'Espresso with steamed milk and thick foam.',
                'price' => 25000,
                'is_available' => true,
                'stock' => 100,
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Caffe Latte',
                'slug' => 'caffe-latte',
                'description' => 'Espresso with steamed milk and light foam.',
                'price' => 28000,
                'is_available' => true,
                'stock' => 100,
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Caramel Macchiato',
                'slug' => 'caramel-macchiato',
                'description' => 'Espresso with vanilla syrup, milk, and caramel drizzle.',
                'price' => 32000,
                'is_available' => true,
                'stock' => 50,
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Kopi Gula Aren',
                'slug' => 'kopi-gula-aren',
                'description' => 'Iced coffee with milk and palm sugar.',
                'price' => 22000,
                'is_available' => true,
                'stock' => 100,
            ],

            // Non-Coffee
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Signature Chocolate',
                'slug' => 'signature-chocolate',
                'description' => 'Creamy and rich chocolate drink.',
                'price' => 25000,
                'is_available' => true,
                'stock' => 80,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Matcha Latte',
                'slug' => 'matcha-latte',
                'description' => 'Premium Japanese matcha with milk.',
                'price' => 28000,
                'is_available' => true,
                'stock' => 60,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Lemon Tea',
                'slug' => 'lemon-tea',
                'description' => 'Refreshing black tea with lemon.',
                'price' => 18000,
                'is_available' => true,
                'stock' => 100,
            ],
            [
                'category_id' => $nonCoffee->id,
                'name' => 'Lychee Tea',
                'slug' => 'lychee-tea',
                'description' => 'Sweet jasmine tea with lychee fruit.',
                'price' => 22000,
                'is_available' => true,
                'stock' => 100,
            ],

            // Snack
            [
                'category_id' => $snack->id,
                'name' => 'Butter Croissant',
                'slug' => 'butter-croissant',
                'description' => 'Flaky and buttery French pastry.',
                'price' => 22000,
                'is_available' => true,
                'stock' => 30,
            ],
            [
                'category_id' => $snack->id,
                'name' => 'Pain Au Chocolat',
                'slug' => 'pain-au-chocolat',
                'description' => 'Croissant pastry filled with chocolate.',
                'price' => 25000,
                'is_available' => true,
                'stock' => 30,
            ],
            [
                'category_id' => $snack->id,
                'name' => 'French Fries',
                'slug' => 'french-fries',
                'description' => 'Crispy golden potato fries.',
                'price' => 20000,
                'is_available' => true,
                'stock' => 50,
            ],
            [
                'category_id' => $snack->id,
                'name' => 'Mix Platter',
                'slug' => 'mix-platter',
                'description' => 'Fries, sausages, and nuggets to share.',
                'price' => 35000,
                'is_available' => true,
                'stock' => 50,
            ],
            
             // Main Course
            [
                'category_id' => $mainCourse->id,
                'name' => 'Nasi Goreng Special',
                'slug' => 'nasi-goreng-special',
                'description' => 'Indonesian fried rice with egg and chicken satay.',
                'price' => 35000,
                'is_available' => true,
                'stock' => 50,
            ],
             [
                'category_id' => $mainCourse->id,
                'name' => 'Spaghetti Aglio Olio',
                'slug' => 'spaghetti-aglio-olio',
                'description' => 'Pasta with garlic, olive oil, and chili flakes.',
                'price' => 32000,
                'is_available' => true,
                'stock' => 40,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $categories = Category::all();

        foreach ($categories as $category) {
            for($i = 0; $i < 4; $i++) {
                $name = $faker->name;
                $price = $faker->numberBetween(100, 10000);
                Product::create(
                    [
                        'name' => $name,
                        'category_id' => $category->id,
                        'url' => Str::slug($name),
                        'description' => $faker->text(),
                        'price' => $price,
                        'sale_price' => $price * 0.7,
                        'popular' => random_int(0, 1),
                        'order' => random_int(0, 10),
                    ]
                );
            }
        }

        $products = Product::select('products.*')
            ->leftJoinContent()
            ->whereNull('products_content.id')
            ->get();

        foreach ($products as $product) {
            Product\Content::create(
                [
                    'product_id' => $product->id,
                    'type' => 'text',
                    'content' => '<p>123123123</p>'

                ]
            );
        }


        // \App\Models\User::factory(10)->create();

//         \App\Models\User::create([
//             'name' => 'Andrey Tarasov',
//             'phone_number' => '+7 (999) 999-99-99',
//             'email' => 'admin@mail.ru',
//             'password' => Hash::make('admin'),
//             'remember_token' => Str::random(10),
//         ]);
    }
}

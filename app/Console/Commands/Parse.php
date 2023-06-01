<?php

namespace App\Console\Commands;

use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Parse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill_fake';

    /**
     * The console command description.
     *
     * @var string
     */
    private \Illuminate\Support\MessageBag $errors;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.escuelajs.co/api/v1/']);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Начало заполнение базы данных!');

        $this->info('Начало заполнение категориями: Начало');
        $this->fillCategories();
        $this->info('Начало заполнение категориями: Завершение');

        $this->info('Начало заполнение товаров: Начало');
        $this->fillProducts();
        $this->info('Начало заполнение товаров: Завершение');

        return Command::SUCCESS;
    }

    private function fillCategories()
    {
        DB::table('categories')->truncate();
        \Storage::delete(\Storage::allFiles(storage_path('app/images/categories')));
        $categories = json_decode($this->client->get('categories')->getBody(), true);
        foreach ($categories as $category) {
            try {
                $file = (new Client)->get($category['image']);
                $info = getimagesizefromstring($file->getBody()->getContents());
                $save = \Storage::disk('images')->put(
                    'categories/' . md5($category['name']) . image_type_to_extension($info[2]),
                    $file->getBody()
                );
            } catch (\Throwable $e) {
                $this->error('[ID]:' . $category['id'] . ' [ERROR]:' . $e->getMessage());
                $save = false;
            }
            try {
                DB::table('categories')
                    ->insert([
                        'parent_id' => 0,
                        'name' => $category['name'],
                        'url' => Str::slug($category['name']),
                        'image' => $save ? 'categories/' . md5($category['name']) . image_type_to_extension($info[2]) : null
                    ]);
            } catch (\Throwable $e) {
                $this->error('[ID]:' . $category['id'] . ' [ERROR]:' . $e->getMessage());
                continue;
            }
        }
        $this->comment('Количество внесёных категорий: ' . count($categories));
    }

    private function fillProducts()
    {
        \Storage::delete(\Storage::allDirectories(storage_path('app/images/products')));
        DB::table('products')->truncate();
        DB::table('products_content')->truncate();

        $products = json_decode($this->client->get('products')->getBody(), true);

        foreach ($products as $product) {
            $category = Category::where('name', $product['category']['name'])->first();
            $images = [];
            $nameDir = md5($product['title']);

            foreach ($product['images'] as $idx => $image) {
                try {
                    $file = (new Client)->get($image);
                    $info = getimagesizefromstring($file->getBody()->getContents());

                    if (\Storage::disk('images')->put(
                        'products/' . $nameDir . '/'
                            . ($idx + 1) . image_type_to_extension($info[2]),
                        $file->getBody()
                    )) {
                        $images[] = 'products/' . $nameDir . '/'
                            . ($idx + 1) . image_type_to_extension($info[2]);
                    }
                } catch (\Throwable $e) {
                    $this->error('[ID]:' . $product['id'] . ' [ERROR]:' . $e->getMessage());
                }
            }

            try {
                DB::table('products')
                    ->insert([
                        'old_id' => $product['id'],
                        'category_id' => $category->id,
                        'name' => $product['title'],
                        'url' => Str::slug($product['title']),
                        'description' => $product['description'],
                        'price' => $product['price'] * 10,
                        'sale_price' => 0,
                        'images' => empty($images) ? null : json_encode($images),
                        'popular' => 0,
                        'order' => 0,
                    ]);
            } catch (\Throwable $e) {
                $this->error('[ID]:' . $product['id'] . ' [ERROR]:' . $e->getMessage());
                continue;
            }

            try {
                $productIdDB = DB::table('products')->select('id')->where('old_id', $product['id'])->first()->id;
                for ($i = 0; $i < rand(1, 20); $i++) {
                    DB::table('products_content')
                        ->insert([
                            'product_id' => $productIdDB,
                            'type' => 'text',
                            'content' => md5($product['title'] . date('j-m-Y')),
                        ]);
                }
            } catch (\Throwable $e) {
                $this->error('[ID]:' . $product['id'] . ' [ERROR]:' . $e->getMessage());
                continue;
            }
        }

        $this->comment('Количество внесёных товаров: ' . count($products));
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class SyncProducts extends Command
{
    // Define command name
    protected $signature = 'sync:products';

    // Command description
    protected $description = 'Fetch and update products from FakeStore API';

    public function handle()
    {
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->failed()) {
            $this->error('Failed to fetch products.');
            return;
        }

        $products = $response->json();

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['id' => $productData['id']], // Prevent duplication
                [
                    'title' => $productData['title'],
                    'price' => $productData['price'],
                    'description' => $productData['description'],
                    'image' => $productData['image'],
                    'category' => $productData['category']
                ]
            );
        }

        $this->info('Products synchronized successfully.');
    }
}

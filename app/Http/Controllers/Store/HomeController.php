<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->latest()
            ->paginate(12)
            ->through(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'category' => $product->category,
                'brand' => $product->brand,
                'stock' => $product->stock,
                'image_url' => $product->image_url,
            ]);

        $categories = Product::query()
            ->where('is_active', true)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return Inertia::render('Shop/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}

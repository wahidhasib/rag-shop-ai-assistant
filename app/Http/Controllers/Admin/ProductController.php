<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display products with search and pagination.
     */
    public function index(Request $request): Response
    {
        $search = trim($request->string('search')->toString());

        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Show the product creation page.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Products/Create');
    }

    /**
     * Store a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],

            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],

            'specifications' => ['nullable', 'array'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $imagePath = null;

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('products', 'public');
            }

            $validated['slug'] = $this->makeUniqueSlug(
                $validated['slug'] ?: $validated['name']
            );

            $validated['image'] = $imagePath;

            Product::create($validated);

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            Log::error('Product creation failed.', [
                'message' => $exception->getMessage(),
                'exception' => $exception,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Unable to create product. Please try again.');
        }
    }

    /**
     * Show the product editing page.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            'category' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],

            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],

            'specifications' => ['nullable', 'array'],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $newImagePath = null;
        $oldImagePath = $product->image;

        try {
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')
                    ->store('products', 'public');

                $validated['image'] = $newImagePath;
            }

            $validated['slug'] = $this->makeUniqueSlug(
                $validated['slug'] ?: $validated['name'],
                $product->id
            );

            $product->update($validated);

            // Delete the old image only after the update succeeds.
            if ($newImagePath && $oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Throwable $exception) {
            // Remove the newly uploaded image if updating fails.
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            Log::error('Product update failed.', [
                'product_id' => $product->id,
                'message' => $exception->getMessage(),
                'exception' => $exception,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Unable to update product. Please try again.');
        }
    }

    /**
     * Delete a product and its stored image.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $imagePath = $product->image;

            $product->delete();

            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (Throwable $exception) {
            Log::error('Product deletion failed.', [
                'product_id' => $product->id,
                'message' => $exception->getMessage(),
                'exception' => $exception,
            ]);

            return back()
                ->with('error', 'Unable to delete product. Please try again.');
        }
    }

    /**
     * Generate a unique product slug.
     */
    private function makeUniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);

        if ($slug === '') {
            $slug = 'product';
        }

        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn($query) => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}

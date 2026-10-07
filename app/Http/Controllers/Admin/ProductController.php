<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Subcategory;
use App\Services\ImageService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private ImageService $imageService
    ) {}

    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory'])->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $request->category_id));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products   = $query->paginate(10)->withQueryString();
        // $products   = $query->get();
        // dd($products);
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()  
    {
        $categories = Category::with('subcategories')->active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data   = $request->validated();
        $images = $request->file('gallery', []);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->imageService->store($request->file('thumbnail'), 'products/thumbnails');
        }

        $product = $this->productService->create($data, $images);

        $this->syncVariants($product, $request->input('variants', []), $request->input('deleted_variant_ids', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'allVariants', 'category', 'subcategory', 'categories', 'subcategories']);
        $categories = Category::with('subcategories')->active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        // dd($request->all());

        $data   = $request->validated();
        $images = $request->file('gallery', []);

        if ($request->hasFile('thumbnail')) {

            // Delete old image
            if ($product->thumbnail) {
                $this->imageService->delete($product->thumbnail);
            }

            // Upload new image
            $data['thumbnail'] = $this->imageService->store(
                $request->file('thumbnail'),
                'products/thumbnails'
            );
        }

        $this->productService->update($product, $data, $images);

        $this->syncVariants($product, $request->input('variants', []), $request->input('deleted_variant_ids', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Create/update/delete a product's variants from the admin form in one go.
     * Rows with an `id` update that variant (scoped to this product, so one
     * product can never edit another's row). Rows without an `id` but with a
     * sku/color/size are created fresh. Fully blank template rows are ignored.
     */
    private function syncVariants(Product $product, array $rows, array $deletedIds = []): void
    {
        if (!empty($deletedIds)) {
            ProductVariant::where('product_id', $product->id)
                ->whereIn('id', $deletedIds)
                ->delete();
        }

        foreach ($rows as $row) {
            $hasContent = !empty($row['sku']) || !empty($row['color']) || !empty($row['size']);
            if (!$hasContent) {
                continue;
            }

            $payload = [
                'sku'        => $row['sku'] ?? null,
                'color'      => $row['color'] ?? null,
                'color_hex'  => $row['color_hex'] ?? null,
                'size'       => $row['size'] ?? null,
                'price'      => ($row['price'] ?? '') !== '' ? $row['price'] : null,
                'sale_price' => ($row['sale_price'] ?? '') !== '' ? $row['sale_price'] : null,
                'stock'      => $row['stock'] ?? 0,
                'is_active'  => !empty($row['is_active']),
            ];

            // Auto-generate a SKU from the product SKU + color/size when left blank
            if (empty($payload['sku'])) {
                $payload['sku'] = strtoupper($product->sku . '-' . Str::slug(($row['color'] ?? '') . '-' . ($row['size'] ?? ''), '-'));
            }

            if (!empty($row['id'])) {
                ProductVariant::where('product_id', $product->id)
                    ->where('id', $row['id'])
                    ->update($payload);
            } else {
                ProductVariant::create(array_merge($payload, ['product_id' => $product->id]));
            }
        }
    }

    public function destroy(Product $product)
    {
        $this->imageService->delete($product->thumbnail);
        $product->images->each(function ($img) {
            $this->imageService->delete($img->image);
            $img->delete();
        });
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    public function deleteImage(ProductImage $image)
    {
        $this->imageService->delete($image->image);
        $image->delete();
        return response()->json(['success' => true]);
    }

    public function getSubcategories(Category $category)
    {
        return response()->json($category->subcategories()->where('is_active', true)->get(['id', 'name']));
    }
}

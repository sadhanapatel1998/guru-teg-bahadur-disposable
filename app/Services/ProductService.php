<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
   public function create(array $data, array $images = []): Product
{
    $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

    $data['sku'] = $data['sku'] ?? $this->generateSku($data['name']);

    [$data, $categoryIds, $subcategoryIds] = $this->extractCategoryIds($data);

    $product = Product::create($data);

    $product->categories()->sync($categoryIds);
    $product->subcategories()->sync($subcategoryIds);

    foreach ($images as $index => $image) {

        $path = app(ImageService::class)->store(
            $image,
            'products/gallery'
        );

        ProductImage::create([
            'product_id' => $product->id,
            'image'      => $path,
            'is_primary' => $index === 0,
            'sort_order' => $index,
        ]);
    }

    return $product;
}

   public function update(Product $product, array $data, array $newImages = []): Product
    {
        [$data, $categoryIds, $subcategoryIds] = $this->extractCategoryIds($data);

        // Update Product Data
        $product->update($data);

        $product->categories()->sync($categoryIds);
        $product->subcategories()->sync($subcategoryIds);

        // Upload New Gallery Images
        foreach ($newImages as $index => $image) {

            $path = app(ImageService::class)->store(
                $image,
                'products/gallery'
            );

            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $path,
                'sort_order' => $product->images()->count() + $index,
            ]);
        }

        return $product->fresh();
    }

    private function generateSku(string $name): string
    {
        return strtoupper(Str::limit(Str::slug($name, ''), 8, '')) . '-' . strtoupper(Str::random(4));
    }

    /**
     * Pull category_ids / subcategory_ids out of the incoming data array (they are
     * not columns on the products table, they're for the many-to-many pivots) and
     * return the cleaned data alongside the two id lists.
     */
    private function extractCategoryIds(array $data): array
    {
        $categoryIds    = array_values(array_filter((array) ($data['category_ids'] ?? [])));
        $subcategoryIds = array_values(array_filter((array) ($data['subcategory_ids'] ?? [])));

        unset($data['category_ids'], $data['subcategory_ids']);

        return [$data, $categoryIds, $subcategoryIds];
    }
}

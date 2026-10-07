<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;
        return [
            'name'              => 'required|string|max:200',
            'slug'              => 'nullable|string|unique:products,slug,' . $productId,
            'sku'               => 'nullable|string|unique:products,sku,' . $productId . '|max:100',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0|lt:price',
            'cost_price'        => 'nullable|numeric|min:0',
            'stock'             => 'integer|min:0',
            'low_stock_threshold' => 'integer|min:0',
            'manage_stock'      => 'boolean',
            'tax_rate'          => 'numeric|min:0|max:100',
            'category_id'       => 'nullable|exists:categories,id',
            'subcategory_id'    => 'nullable|exists:subcategories,id',
            'category_ids'      => 'required|array|min:1',
            'category_ids.*'    => 'exists:categories,id',
            'subcategory_ids'   => 'nullable|array',
            'subcategory_ids.*' => 'exists:subcategories,id',
            'thumbnail'         => 'nullable|image|max:2048',
            'gallery.*'         => 'nullable|image|max:2048',
            'status'            => 'required|in:active,inactive,draft',
            'is_featured'       => 'boolean',
            'is_trending'       => 'boolean',
            'is_new_arrival'    => 'boolean',
            'is_best_seller'    => 'boolean',
            'is_on_sale'        => 'boolean',
            'meta_title'        => 'nullable|string|max:160',
            'meta_description'  => 'nullable|string|max:300',
            'meta_keywords'     => 'nullable|string',

            // Variants (Brass / Silver-Plated, sizes, etc.)
            'variants'                  => 'nullable|array',
            'variants.*.id'             => 'nullable|integer|exists:product_variants,id',
            'variants.*.sku'            => 'nullable|string|max:100',
            'variants.*.color'          => 'nullable|string|max:100',
            'variants.*.color_hex'      => 'nullable|string|max:20',
            'variants.*.size'           => 'nullable|string|max:100',
            'variants.*.price'          => 'nullable|numeric|min:0',
            'variants.*.sale_price'     => 'nullable|numeric|min:0',
            'variants.*.stock'          => 'nullable|integer|min:0',
            'variants.*.is_active'      => 'nullable|boolean',
            'deleted_variant_ids'       => 'nullable|array',
            'deleted_variant_ids.*'     => 'integer|exists:product_variants,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $bools = ['manage_stock','is_featured','is_trending','is_new_arrival','is_best_seller','is_on_sale'];
        foreach ($bools as $field) {
            $this->merge([$field => $this->has($field) ? 1 : 0]);
        }
        if (!$this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->name)]);
        }
        if (!$this->filled('sku') && $this->filled('name')) {
            $this->merge(['sku' => 'SCC-' . strtoupper(substr(md5($this->name . time()), 0, 8))]);
        }

        // The product still keeps a single "primary" category_id / subcategory_id
        // (used across the existing views/breadcrumbs). Derive it automatically
        // from the first selected checkbox so the old columns keep working.
        if ($this->has('category_ids')) {
            $this->merge(['category_id' => $this->category_ids[0] ?? null]);
        }
        if ($this->has('subcategory_ids')) {
            $this->merge(['subcategory_id' => $this->subcategory_ids[0] ?? null]);
        }
    }
}

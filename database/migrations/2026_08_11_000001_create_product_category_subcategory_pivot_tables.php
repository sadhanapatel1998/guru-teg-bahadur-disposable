<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Pivot table: a product can belong to many categories, a category can have many products
        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['product_id', 'category_id']);
        });

        // Pivot table: a product can belong to many subcategories, a subcategory can have many products
        Schema::create('product_subcategory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['product_id', 'subcategory_id']);
        });

        // Backfill pivot tables from the existing single category_id / subcategory_id
        // columns so every product that already had a category/subcategory keeps it
        // after upgrading to the many-to-many relationship. This does not touch or
        // remove the original columns, they remain as the product's "primary" category.
        $now = now();

        $products = DB::table('products')
            ->select('id', 'category_id', 'subcategory_id')
            ->get();

        $categoryRows = [];
        $subcategoryRows = [];

        foreach ($products as $product) {
            if (!empty($product->category_id)) {
                $categoryRows[] = [
                    'product_id'  => $product->id,
                    'category_id' => $product->category_id,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
            if (!empty($product->subcategory_id)) {
                $subcategoryRows[] = [
                    'product_id'     => $product->id,
                    'subcategory_id' => $product->subcategory_id,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ];
            }
        }

        foreach (array_chunk($categoryRows, 500) as $chunk) {
            DB::table('product_category')->insertOrIgnore($chunk);
        }

        foreach (array_chunk($subcategoryRows, 500) as $chunk) {
            DB::table('product_subcategory')->insertOrIgnore($chunk);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_subcategory');
        Schema::dropIfExists('product_category');
    }
};

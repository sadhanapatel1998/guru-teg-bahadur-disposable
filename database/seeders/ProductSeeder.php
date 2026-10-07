<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        |
        | Product data taken from Finesse By Design catalogue.
        |
        */

        $products = [

            /*
            |--------------------------------------------------------------------------
            | BAR RANGE
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Bar Range',
                'subcategory' => 'Wine Cooler',
                'name' => 'Wine Cooler',
                'code' => 'WC-001',
                'dimensions' => 'T 8.7" x B 4.6" x H 8.25"',
                'weight' => '1110 grams',
                'brass_price' => 7500,
                'silver_price' => 12999,
                'finish' => '100% Handcrafted Brass / Silver-Plated',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Wine Cooler',
                'name' => 'Wine Cooler',
                'code' => 'WC-002',
                'dimensions' => 'T 7.25" x L 8.25" x W 5.8"',
                'weight' => '1160 grams',
                'brass_price' => 7500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Ice Bucket',
                'name' => 'Ice Bucket',
                'code' => 'IB-001',
                'dimensions' => 'T 5.5" x B 3.6" x H 5.6"',
                'weight' => '690 gram',
                'brass_price' => 4500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Ice Bucket',
                'name' => 'Ice Bucket',
                'code' => 'IB-002',
                'dimensions' => 'T 5.25" x B 3.6" x H 5.4"',
                'weight' => '950 gram',
                'brass_price' => 4500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Wine Bottle Holder',
                'name' => 'Wine Bottle Holder',
                'code' => 'BHW-002',
                'dimensions' => 'T 9.25" x W 3.25" x H 6.35"',
                'weight' => '660 grams',
                'brass_price' => 3500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Wine Bottle Holder',
                'name' => 'Wine Bottle Holder',
                'code' => 'WC-001',
                'dimensions' => 'T 9.25" x W 3.6" x H 6.5"',
                'weight' => '1120 grams',
                'brass_price' => 3500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Beer Mug',
                'name' => 'Beer Mug',
                'code' => 'BM-001',
                'dimensions' => 'H 4.25" x ID 3" x BD 3.75"',
                'weight' => '300 grams',
                'brass_price' => 1900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Bar Range',
                'subcategory' => 'Beer Mug',
                'name' => 'Beer Mug',
                'code' => 'BM-002',
                'dimensions' => 'H 4.5" x TD 3" x BD 4"',
                'weight' => '380 grams',
                'brass_price' => 1900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | CUTLERY
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-001',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-002',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-003',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-004',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-005',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-007',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Cutlery',
                'subcategory' => 'Spoon & Fork Set',
                'name' => 'All Purpose Spoon / Fork',
                'code' => 'CHS-008',
                'dimensions' => 'Standard',
                'weight' => '40-45 gram',
                'brass_price' => 900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | SERVER
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Server',
                'subcategory' => 'Decorative Server',
                'name' => 'Server',
                'code' => 'SC-001',
                'dimensions' => 'L 11.5" x W 2"',
                'weight' => '135 gram',
                'brass_price' => 1300,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Server',
                'subcategory' => 'Decorative Server',
                'name' => 'Server',
                'code' => 'SC-002',
                'dimensions' => 'L 11" x W 3"',
                'weight' => '135 gram',
                'brass_price' => 1300,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Server',
                'subcategory' => 'Decorative Server',
                'name' => 'Server',
                'code' => 'SC-003',
                'dimensions' => 'L 14.25"',
                'weight' => '165 grams',
                'brass_price' => 1300,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Server',
                'subcategory' => 'Decorative Server',
                'name' => 'Server',
                'code' => 'SC-004',
                'dimensions' => 'L 10.3"',
                'weight' => '150 grams',
                'brass_price' => 4500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Server',
                'subcategory' => 'Serving Ladle',
                'name' => 'Server',
                'code' => 'SC-005',
                'dimensions' => 'L 11.4" x W 4.25"',
                'weight' => '300 grams',
                'brass_price' => 1700,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | GIFT BASKET
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Gift Basket',
                'subcategory' => 'Fruit Basket',
                'name' => 'Fruit Basket',
                'code' => 'FBJ-001',
                'dimensions' => 'H 2" x D 8"',
                'weight' => '390 gram',
                'brass_price' => 1900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Gift Basket',
                'subcategory' => 'Hammered Fruit Basket',
                'name' => 'Hammered Fruit Basket',
                'code' => 'FBH-001',
                'dimensions' => 'H 2.25" x L 10.5" x W 7.7"',
                'weight' => '450 gram',
                'brass_price' => 2900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Gift Basket',
                'subcategory' => 'Fruit Basket',
                'name' => 'Fruit Basket',
                'code' => 'FBG-001',
                'dimensions' => 'H 2.2" to 2.4" x D 10.75"',
                'weight' => '620 gram',
                'brass_price' => 3500,
                'silver_price' => 9500,
                'finish' => '100% Handcrafted Brass / Silver-Plated',
            ],

            [
                'category' => 'Gift Basket',
                'subcategory' => 'Fruit Basket',
                'name' => 'Fruit Basket',
                'code' => 'FBO-001',
                'dimensions' => 'H 2.7" x L 10.25" x W 6.75"',
                'weight' => '340 gram',
                'brass_price' => 2900,
                'silver_price' => 8300,
                'finish' => '100% Handcrafted Brass / Silver-Plated',
            ],

            [
                'category' => 'Gift Basket',
                'subcategory' => 'Decorative Basket',
                'name' => 'Basket',
                'code' => 'BB-001',
                'dimensions' => 'L 11" x W 7.25" x H 5.25"',
                'weight' => '400 gram',
                'brass_price' => 2300,
                'silver_price' => 3900,
                'finish' => '100% Handcrafted Brass / Silver-Plated',
            ],

            /*
            |--------------------------------------------------------------------------
            | FLOWER VASE
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Flower Vase',
                'subcategory' => 'Flower Vase',
                'name' => 'Flower Vase',
                'code' => 'FC-001',
                'dimensions' => 'H 5.8" x L 6.4" x W 2"',
                'weight' => '450 gram',
                'brass_price' => 2700,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Flower Vase',
                'subcategory' => 'Hammered Flower Vase',
                'name' => 'Hammered Flower Vase',
                'code' => 'FVH-001',
                'dimensions' => 'H 8" x L 4" x W 4"',
                'weight' => '900 gram',
                'brass_price' => 5500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Flower Vase',
                'subcategory' => 'Rose Bowl',
                'name' => 'Rose Bowl',
                'code' => 'RB-001',
                'dimensions' => 'T 7.35" x H 5.75"',
                'weight' => '1195 gram',
                'brass_price' => 4900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | DESSERT CUPS
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Dessert Cups',
                'subcategory' => 'Dessert Cup',
                'name' => 'Dessert Cup',
                'code' => 'DC-001',
                'dimensions' => 'H 2.5" x TD 3.5"',
                'weight' => '175 gram',
                'brass_price' => 5500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Dessert Cups',
                'subcategory' => 'Banana Split',
                'name' => 'Banana Split',
                'code' => 'ICS-001',
                'dimensions' => 'L 8.5" x W 3.5" x H 1.25"',
                'weight' => '390 gram',
                'brass_price' => 2900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Dessert Cups',
                'subcategory' => 'Single Scoop Ice Cream Cup',
                'name' => 'Ice Cream Cup (Single Scoop)',
                'code' => 'ICS-001',
                'dimensions' => 'H 2.75" x D 3.75"',
                'weight' => '230 gram',
                'brass_price' => 2500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | SERVING TRAYS
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Serving Trays',
                'subcategory' => 'Serving Tray',
                'name' => 'Serving Tray',
                'code' => 'STL-001',
                'dimensions' => 'L 16.25" x W 12.25" x L 19.4"',
                'weight' => '1730 grams',
                'brass_price' => 9900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Serving Trays',
                'subcategory' => 'Square Serving Tray',
                'name' => 'Square Serving Tray',
                'code' => 'SST-001',
                'dimensions' => 'L 10.5" x W 10.5" x H 0.6"',
                'weight' => '590 grams',
                'brass_price' => 3400,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Serving Trays',
                'subcategory' => 'Serving Tray',
                'name' => 'Serving Tray',
                'code' => 'ST-003',
                'dimensions' => 'L 10.75" x W 6.35" x H 1.5"/0.8"',
                'weight' => '540 grams',
                'brass_price' => 2400,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | NUT DISH
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Reindeer Nut Bowl',
                'name' => 'Reindeer Nut Bowl',
                'code' => 'ND-008',
                'dimensions' => 'D 5" x BD 2.6" x L 8"',
                'weight' => '400 gram',
                'brass_price' => 2900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Trivet',
                'name' => 'Trivet',
                'code' => 'ND-004',
                'dimensions' => 'L 5" x W 4.8" x H 1.25"',
                'weight' => '210 gram',
                'brass_price' => 1900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Swan Bowl',
                'name' => 'Swan Bowl',
                'code' => 'ND-005',
                'dimensions' => 'L 4" x W 4" x H 3.8"',
                'weight' => '210 gram',
                'brass_price' => 1700,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Nut Dish',
                'name' => 'Nut Dish',
                'code' => 'ND-002',
                'dimensions' => 'OD 5" x ID 4" x H 0.6"',
                'weight' => '170 gram',
                'brass_price' => 1100,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Leaf Platter',
                'name' => 'Leaf Platter',
                'code' => 'WC-007',
                'dimensions' => 'L 7.6" x W 5.75" x H 0.65"',
                'weight' => '250 gram',
                'brass_price' => 2900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Nut Dish',
                'name' => 'Nut Dish',
                'code' => 'ND-003',
                'dimensions' => 'OD 5" x ID 4" x H 0.6"',
                'weight' => '180 gram',
                'brass_price' => 1300,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Nut Dish',
                'name' => 'Nut Dish',
                'code' => 'ND-001',
                'dimensions' => 'D 4" x L 5.6" x H 1.25"',
                'weight' => '145 gram',
                'brass_price' => 1100,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Nut Dish',
                'subcategory' => 'Nut Dish',
                'name' => 'Nut Dish',
                'code' => 'WC-006',
                'dimensions' => 'L 3.8" x H 1"',
                'weight' => '110 gram',
                'brass_price' => 1200,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | TEA SET
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Tea Set',
                'subcategory' => 'Brass Tea Set',
                'name' => 'Tea Set',
                'code' => 'TS-001',
                'dimensions' => 'L 7.2" x H 6.25"',
                'weight' => '730 grams',
                'brass_price' => 3900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            /*
            |--------------------------------------------------------------------------
            | MISC ARTICLES
            |--------------------------------------------------------------------------
            */

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Snack Server',
                'name' => 'Snack Server',
                'code' => 'SS-001',
                'dimensions' => 'L 7.15" x W 5.75" x H 5.5"',
                'weight' => '1180 grams',
                'brass_price' => 3900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Chafing Dish',
                'name' => 'Chafing Dish',
                'code' => 'CD-001',
                'dimensions' => 'L 14.3" x H 15.5"',
                'weight' => '5300 grams',
                'brass_price' => 45000,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Toaster',
                'name' => 'Toaster',
                'code' => 'TR-001',
                'dimensions' => 'L 5" x W 2.75" x H 3"',
                'weight' => '300 grams',
                'brass_price' => 2500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Pooja Lamp',
                'name' => 'Pooja Lamp',
                'code' => 'PL-001',
                'dimensions' => 'TW 3.6" x H 8"',
                'weight' => '320 grams',
                'brass_price' => 1900,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Soup Bowl',
                'name' => 'Soup Bowl',
                'code' => 'SBB-001',
                'dimensions' => 'H 2" x TDOS 4.4" x H 0.6"',
                'weight' => '470 grams',
                'brass_price' => 3500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],

            [
                'category' => 'Misc Articles',
                'subcategory' => 'Tissue Paper Holder',
                'name' => 'Tissue Paper Holder',
                'code' => 'TPH-001',
                'dimensions' => 'H 1.25" x L 9.25" x W 6"',
                'weight' => '740 grams',
                'brass_price' => 4500,
                'silver_price' => null,
                'finish' => '100% Handcrafted Brass',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Get Product Table Columns
        |--------------------------------------------------------------------------
        |
        | Isse agar Product table me kuch optional columns nahi hain,
        | to seeder unnecessary SQL error nahi dega.
        |
        */

        $productColumns = Schema::getColumnListing('products');

        /*
        |--------------------------------------------------------------------------
        | Insert Products
        |--------------------------------------------------------------------------
        */

        foreach ($products as $item) {

            $category = Category::where(
                'slug',
                Str::slug($item['category'])
            )->first();

            if (!$category) {
                $this->command->warn(
                    "Category not found: {$item['category']}"
                );

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Find Subcategory
            |--------------------------------------------------------------------------
            */

            $subcategory = Subcategory::where(
                'category_id',
                $category->id
            )
                ->where(
                    'name',
                    $item['subcategory']
                )
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Unique SKU
            |--------------------------------------------------------------------------
            |
            | Catalogue me duplicate codes bhi hain:
            |
            | WC-001
            | ICS-001
            |
            | Isliye hash add kar rahe hain.
            |
            */

            $hash = strtoupper(
                substr(
                    md5(
                        $item['category'] .
                        $item['name'] .
                        $item['code']
                    ),
                    0,
                    6
                )
            );

            $baseSku =
                'FBD-' .
                strtoupper($item['code']) .
                '-' .
                $hash;

            /*
            |--------------------------------------------------------------------------
            | Unique Slug
            |--------------------------------------------------------------------------
            */

            $slug = Str::slug(
                $item['name'] .
                '-' .
                $item['code'] .
                '-' .
                strtolower($hash)
            );

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $description =
                $item['name'] .
                ' from Finesse By Design. ' .
                'Premium handcrafted metal giftware. ' .
                'Catalogue Code: ' . $item['code'] . '. ' .
                'Dimensions: ' . $item['dimensions'] . '. ' .
                'Weight: ' . $item['weight'] . '. ' .
                'Finish: ' . $item['finish'] . '.';

            /*
            |--------------------------------------------------------------------------
            | Product Data
            |--------------------------------------------------------------------------
            */

            $productData = [

                'category_id' => $category->id,

                'subcategory_id' => $subcategory?->id,

                'name' => $item['name'],

                'slug' => $slug,

                'sku' => $baseSku,

                /*
                 * Main product price = Brass price
                 */
                'price' => $item['brass_price'],

                'sale_price' => null,

                /*
                 * Default Stock
                 */
                'stock' => 25,

                'stock_quantity' => 25,

                'quantity' => 25,

                /*
                 * Product information
                 */
                'material' => 'Brass',

                'dimensions' => $item['dimensions'],

                // products.weight is numeric in DB, so save grams as a number only.
                'weight' => $this->parseWeight($item['weight']),

                'finish' => $item['finish'],

                'product_code' => $item['code'],

                'code' => $item['code'],

                /*
                 * Description
                 */
                'short_description' =>
                    'Premium handcrafted ' .
                    $item['name'] .
                    ' by Finesse By Design.',

                'description' => $description,

                /*
                 * Status
                 */
                'is_active' => true,

                'is_featured' => false,

                'status' => 'active',

                /*
                 * SEO
                 */
                'meta_title' =>
                    $item['name'] .
                    ' ' .
                    $item['code'] .
                    ' | Finesse By Design',

                'meta_description' =>
                    'Shop ' .
                    $item['name'] .
                    ' (' .
                    $item['code'] .
                    ') handcrafted by Finesse By Design.',
            ];

            /*
            |--------------------------------------------------------------------------
            | Remove fields which do not exist in products table
            |--------------------------------------------------------------------------
            */

            $productData = array_filter(
                $productData,
                fn ($value, $key) =>
                    in_array($key, $productColumns),
                ARRAY_FILTER_USE_BOTH
            );

            /*
            |--------------------------------------------------------------------------
            | Find Existing Product
            |--------------------------------------------------------------------------
            */

            $product = null;

            if (in_array('sku', $productColumns)) {

                $product = Product::where(
                    'sku',
                    $baseSku
                )->first();

            } elseif (in_array('slug', $productColumns)) {

                $product = Product::where(
                    'slug',
                    $slug
                )->first();
            }

            /*
            |--------------------------------------------------------------------------
            | Create Product
            |--------------------------------------------------------------------------
            */

            if (!$product) {
                $product = new Product();
            }

            /*
             * forceFill is used because we don't know
             * every Product::$fillable property.
             */
            $product->forceFill($productData);

            $product->save();

            /*
            |--------------------------------------------------------------------------
            | Brass Variant
            |--------------------------------------------------------------------------
            */

            ProductVariant::updateOrCreate(
                [
                    'sku' => $baseSku . '-BRASS',
                ],
                [
                    'product_id' => $product->id,

                    'size' => null,

                    'color' => 'Brass',

                    'color_hex' => '#B08D57',

                    'attributes' => [
                        'catalogue_code' => $item['code'],
                        'material' => '100% Handcrafted Brass',
                        'dimensions' => $item['dimensions'],
                        'weight' => $item['weight'],
                        'finish' => '100% Handcrafted Brass',
                    ],

                    'price' => $item['brass_price'],

                    'sale_price' => null,

                    'stock' => 25,

                    'image' => null,

                    'is_active' => true,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Silver Plated Variant
            |--------------------------------------------------------------------------
            */

            if (!empty($item['silver_price'])) {

                ProductVariant::updateOrCreate(
                    [
                        'sku' => $baseSku . '-SILVER',
                    ],
                    [
                        'product_id' => $product->id,

                        'size' => null,

                        'color' => 'Silver Plated',

                        'color_hex' => '#C0C0C0',

                        'attributes' => [
                            'catalogue_code' => $item['code'],
                            'material' => 'Silver Plated',
                            'dimensions' => $item['dimensions'],
                            'weight' => $item['weight'],
                            'finish' => 'Silver-Plated',
                        ],

                        'price' => $item['silver_price'],

                        'sale_price' => null,

                        'stock' => 15,

                        'image' => null,

                        'is_active' => true,
                    ]
                );
            }

            $this->command->info(
                "Product seeded: {$item['name']} ({$item['code']})"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Finished
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Finesse By Design products seeded successfully.'
        );
    }

    /**
     * Convert catalogue weight text to numeric grams for products.weight.
     *
     * Examples:
     *  "1110 grams" => 1110
     *  "690 gram"   => 690
     *  "40-45 gram" => 43
     */
    private function parseWeight(?string $weight): ?int
    {
        if (!$weight) {
            return null;
        }

        $weight = trim($weight);

        // Handle ranges such as "40-45 gram" by storing the rounded average.
        if (preg_match('/(\d+(?:\.\d+)?)\s*-\s*(\d+(?:\.\d+)?)/', $weight, $matches)) {
            $min = (float) $matches[1];
            $max = (float) $matches[2];

            return (int) round(($min + $max) / 2);
        }

        // Handle normal values such as "1110 grams".
        if (preg_match('/(\d+(?:\.\d+)?)/', $weight, $matches)) {
            return (int) round((float) $matches[1]);
        }

        return null;
    }

}
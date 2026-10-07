<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        Admin::updateOrCreate(
            ['email' => 'admin@finessebydesign.com'],
            [
                'name'       => 'Finesse By Design',
                'password'   => Hash::make('Admin@12345'),
                'role'       => 'super_admin',
                'is_active'  => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Categories & Subcategories
        |--------------------------------------------------------------------------
        */

        $categories = [

            /*
            |--------------------------------------------------------------------------
            | Bar Range
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Bar Range',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Wine Cooler',
                    'Ice Bucket',
                    'Wine Bottle Holder',
                    'Beer Mug',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Cutlery
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Cutlery',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'All Purpose Spoon',
                    'All Purpose Fork',
                    'Spoon & Fork Set',
                    'Handcrafted Brass Cutlery',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Server
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Server',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Cake Server',
                    'Serving Spoon',
                    'Serving Ladle',
                    'Cheese Server',
                    'Decorative Server',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Gift Basket
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Gift Basket',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Fruit Basket',
                    'Hammered Fruit Basket',
                    'Brass Basket',
                    'Silver Plated Basket',
                    'Decorative Basket',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Flower Vase
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Flower Vase',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Flower Vase',
                    'Hammered Flower Vase',
                    'Rose Bowl',
                    'Decorative Vase',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Dessert Cups
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Dessert Cups',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Dessert Cup',
                    'Banana Split',
                    'Ice Cream Cup',
                    'Single Scoop Ice Cream Cup',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Serving Trays
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Serving Trays',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Serving Tray',
                    'Square Serving Tray',
                    'Decorative Serving Tray',
                    'Brass Serving Tray',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Nut Dish
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Nut Dish',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Reindeer Nut Bowl',
                    'Trivet',
                    'Swan Bowl',
                    'Nut Dish',
                    'Leaf Platter',
                    'Decorative Nut Bowl',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Tea Set
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Tea Set',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Brass Tea Set',
                    'Silver Plated Tea Set',
                    'Traditional Tea Set',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Misc Articles
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Misc Articles',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Snack Server',
                    'Chafing Dish',
                    'Toaster',
                    'Pooja Lamp',
                    'Soup Bowl',
                    'Tissue Paper Holder',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {

            $subcategories = $categoryData['subcategories'] ?? [];

            unset($categoryData['subcategories']);

            $slug = Str::slug($categoryData['name']);

            $category = Category::updateOrCreate(
                [
                    'slug' => $slug
                ],
                [
                    'name'        => $categoryData['name'],
                    'slug'        => $slug,
                    'icon'        => $categoryData['icon'],
                    'is_featured' => $categoryData['is_featured'],
                    'is_active'   => true,
                ]
            );

            foreach ($subcategories as $subcategoryName) {

                /*
                 * Category ID ko slug me include kiya hai,
                 * taki same naam alag categories me ho to conflict na ho.
                 */
                $subcategorySlug = Str::slug(
                    $category->slug . '-' . $subcategoryName
                );

                Subcategory::updateOrCreate(
                    [
                        'slug' => $subcategorySlug
                    ],
                    [
                        'category_id' => $category->id,
                        'name'        => $subcategoryName,
                        'slug'        => $subcategorySlug,
                        'is_active'   => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Website Settings
        |--------------------------------------------------------------------------
        */

        $settings = [

            [
                'key' => 'site_name',
                'value' => 'Finesse By Design',
                'group' => 'general',
            ],

            [
                'key' => 'site_tagline',
                'value' => 'Premium Handcrafted Brass & Silver Plated Giftware',
                'group' => 'general',
            ],

            [
                'key' => 'site_email',
                'value' => 'admin@finessebydesign.com',
                'group' => 'general',
            ],

            [
                'key' => 'site_phone',
                'value' => '+91 82182 07223',
                'group' => 'general',
            ],

            [
                'key' => 'currency_symbol',
                'value' => '₹',
                'group' => 'general',
            ],

            [
                'key' => 'currency_code',
                'value' => 'INR',
                'group' => 'general',
            ],

            [
                'key' => 'free_shipping_threshold',
                'value' => '5000',
                'group' => 'general',
            ],

            [
                'key' => 'shipping_charge',
                'value' => '250',
                'group' => 'general',
            ],

            [
                'key' => 'meta_title',
                'value' => 'Finesse By Design | Premium Handcrafted Brass & Silver Plated Giftware',
                'group' => 'seo',
            ],

            [
                'key' => 'meta_description',
                'value' =>
                    'Shop premium handcrafted brass and silver plated tableware, bar accessories, home decor, wedding gifts and utensils from Finesse By Design.',
                'group' => 'seo',
            ],

            [
                'key' => 'footer_about',
                'value' =>
                    'Finesse By Design offers premium handcrafted brass and silver plated giftware, tableware, bar accessories, home decor, wedding gifts and utensils.',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {

            Setting::updateOrCreate(
                [
                    'key' => $setting['key']
                ],
                $setting
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Console Output
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            'Seeded: Admin, Finesse By Design Categories, Subcategories and Settings'
        );

        $this->command->info(
            'Admin Login: admin@finessebydesign.com / Admin@12345'
        );
    }
}
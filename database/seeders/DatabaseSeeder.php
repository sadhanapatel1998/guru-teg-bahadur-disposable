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
            ['email' => 'admin@gtb.com'],
            [
                'name'       => 'Guru Teg Bahadur Disposable',
                'password'   => Hash::make(''),
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
    | Kitchen & Houseware
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Kitchen & Houseware',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Kitchen Essentials',
                    'Food Storage Containers',
                    'Kitchen Accessories',
                    'Household Essentials',
                    'Disposable Kitchen Products',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Kitchen Paper & Rolls
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Kitchen Paper & Rolls',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Kitchen Tissue Rolls',
                    'Kitchen Paper Towels',
                    'Baking Paper',
                    'Butter Paper',
                    'Cling Film',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Tissue & Napkins
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Tissue & Napkins',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Facial Tissues',
                    'Table Napkins',
                    'Paper Napkins',
                    'Toilet Tissue',
                    'Wet Wipes',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Disposable Cups & Bowls
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Disposable Cups & Bowls',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Paper Cups',
                    'Plastic Cups',
                    'Ripple Cups',
                    'Disposable Bowls',
                    'Soup Bowls',
                    'Ice Cream Cups',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Disposable Plates & Spoons
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Disposable Plates & Spoons',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Paper Plates',
                    'Areca Leaf Plates',
                    'Plastic Plates',
                    'Compartment Plates',
                    'Disposable Spoons',
                    'Disposable Forks',
                    'Disposable Knives',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Kitchen Cleaning Products
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Kitchen Cleaning Products',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Dishwashing Products',
                    'Scrubbers',
                    'Scouring Pads',
                    'Cleaning Brushes',
                    'Garbage Bags',
                    'Kitchen Cleaning Accessories',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Aluminium Foil Rolls
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Aluminium Foil Rolls',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Aluminium Foil',
                    'Heavy Duty Aluminium Foil',
                    'Food Wrapping Foil',
                    'Aluminium Foil Rolls',
                    'Foil Containers',
                ],
            ],

            /*
    |--------------------------------------------------------------------------
    | Catering & Party Supplies
    |--------------------------------------------------------------------------
    */
            [
                'name' => 'Catering & Party Supplies',
                'icon' => '',
                'is_featured' => true,
                'subcategories' => [
                    'Disposable Catering Products',
                    'Party Plates',
                    'Party Cups',
                    'Food Containers',
                    'Serving Accessories',
                    'Party Decoration Supplies',
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
                'value' => 'Guru Teg Bahadur Disposable',
                'group' => 'general',
            ],

            [
                'key' => 'site_tagline',
                'value' => 'Quality Disposable Products for Every Occasion',
                'group' => 'general',
            ],

            [
                'key' => 'site_email',
                'value' => 'info@guruteghbahadursdisposable.com',
                'group' => 'general',
            ],

            [
                'key' => 'site_phone',
                'value' => '+91 98765 43210',
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
                'value' => '2000',
                'group' => 'general',
            ],

            [
                'key' => 'shipping_charge',
                'value' => '100',
                'group' => 'general',
            ],

            [
                'key' => 'meta_title',
                'value' => 'Guru Teg Bahadur Disposable | Disposable Products & Kitchen Essentials',
                'group' => 'seo',
            ],

            [
                'key' => 'meta_description',
                'value' =>
                'Shop quality disposable cups, plates, bowls, spoons, tissues, kitchen paper, aluminium foil, cleaning products, catering and party supplies from Guru Teg Bahadur Disposable.',
                'group' => 'seo',
            ],

            [
                'key' => 'footer_about',
                'value' =>
                'Guru Teg Bahadur Disposable offers a wide range of quality disposable products, kitchen essentials, tissues, paper products, aluminium foil, cleaning supplies, catering products and party supplies for homes, businesses and events.',
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
            'Seeded: Admin, Guru Teg Bahadur Disposable Categories and Settings'
        );
    }
}

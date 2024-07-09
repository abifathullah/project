<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Utilities\Enums\Products\ProductWearType;
use App\Utilities\Enums\ProductType;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            ProductType::TOOL => [
                [
                    'name' => 'Diagonal cutting plier',
                    'price' => 69.80,
                    'description' => 'Diagonal cutting pliers are used for cutting wire. They cut wire by indenting and wedging a cable apart (as opposed to shearing like scissors).',
                ],
                [
                    'name' => 'Linesman plier',
                    'price' => 110.00,
                    'description' => 'Linesman pliers are commonly used to cut, strip, and bend wire.',
                ],
                [
                    'name' => 'Long nose plier',
                    'price' => 56.65,
                    'description' => 'Long Nose pliers are both cutting and holding pliers used by artisans, jewelry designers, electricians, network engineers and other tradesmen to bend, re-position and cut wire.',
                ],
            ],

            ProductType::TRANSPORTATION => [
                [
                    'name' => 'Dump Truck',
                    'price' => 303800.00,
                    'description' => 'Open-topped truck having a body that can be tilted to discharge its contents, as sand or gravel, through an open tailgate.',
                ],
                [
                    'name' => 'Excavator',
                    'price' => 220000.00,
                    'description' => 'Excavators are heavy construction equipment consisting of a boom, arm, bucket, and cab on a rotating superstructure atop an undercarriage with tracks or wheels.',
                ],
                [
                    'name' => 'Forklift',
                    'price' => 59800.00,
                    'description' => 'A forklift (also called industrial truck, lift truck, jitney, hi-lo, fork truck, fork hoist, and forklift truck) is a powered industrial truck used to lift and move materials over short distances.',
                ],
            ],

            ProductType::WEAR => [
                [
                    'name' => ProductWearType::SAFETY_GLASSES,
                    'price' => 47.50,
                    'description' => 'Safety glasses can prevent foreign objects or debris from damaging your vision.',
                ],
                [
                    'name' => ProductWearType::SAFETY_HELMET,
                    'price' => 35.00,
                    'description' => 'Safety helmets are an essential piece of personal protective equipment (PPE) that is designed to protect the wearer from head injuries caused by falling objects, impact with stationary objects, or electrical hazards.',
                ],
                [
                    'name' => ProductWearType::SAFETY_SHOES,
                    'price' => 235.00,
                    'description' => 'Safety shoes are personal protective equipment (PPE) for foot protection at workplaces.',
                ],
                [
                    'name' => ProductWearType::SAFETY_VEST,
                    'price' => 18.99,
                    'description' => 'Safety vests is to help alert people that another human is present in their field of vision.',
                ],
            ],
        ];

        foreach ($options as $optionKey => $optionVal) {
            $productCategory = ProductCategory::firstOrCreate([
                'name' => $optionKey,
            ]);

            foreach ($optionVal as $optionItemKey => $optionItemVal) {
                Product::firstOrCreate([
                    'name' => $optionItemVal['name'],
                    'product_category_id' => $productCategory->id,
                ], [
                    'price' => $optionItemVal['price'],
                    'description' => $optionItemVal['description'],
                ]);
            }
        }
    }
}

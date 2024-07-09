<?php

namespace App\Console\Commands\Temporary;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Utilities\Enums\ProductType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @deprecated One-time use
 */
class AddExtraProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-extra-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add extra product for backend page pagination limit query.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            // Product: Tool
            $productCategory = ProductCategory::where('name', ProductType::TOOL)->first();

            if ($productCategory) {
                Product::firstOrCreate([
                    'name' => 'Combination wrench set',
                    'product_category_id' => $productCategory->id,
                    'price' => 200.00,
                    'description' => 'Basic hand tool.',
                ]);
            }

            // Product: Transportation
            $productCategory = ProductCategory::where('name', ProductType::TRANSPORTATION)->first();

            if ($productCategory) {
                Product::firstOrCreate([
                    'name' => 'Tractor',
                    'product_category_id' => $productCategory->id,
                    'price' => 29800.00,
                    'description' => 'A tractor is an engineering vehicle specifically designed to deliver a high tractive effort at slow speeds, for the purposes of hauling a trailer or machinery such as that used in agriculture, mining or construction.',
                ]);
            }

            // Product: Transportation
            $productCategory = ProductCategory::where('name', ProductType::WEAR)->first();

            if ($productCategory) {
                Product::firstOrCreate([
                    'name' => 'Safety vest',
                    'product_category_id' => $productCategory->id,
                    'price' => 18.99,
                    'description' => 'Safety vests is to help alert people that another human is present in their field of vision.',
                ]);
            }

            $this->info('Additional product successfully added.');

        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }

        DB::commit();

        return 0;
    }
}

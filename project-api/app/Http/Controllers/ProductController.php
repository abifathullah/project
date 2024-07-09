<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use SoftDeletes;

    /**
     * Validation rules.
     *
     * @return array<string>
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        $rules = [
            'productName' => 'nullable|string|max:255',
            'categoryName' => 'nullable|string|max:255',
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric|min:0',
        ];

        $validatedData = $request->validate($rules);

        if (isset($validatedData['minPrice']) && isset($validatedData['maxPrice']) && $validatedData['minPrice'] > $validatedData['maxPrice']) {
            return response()->json(['error' => 'Max Price cannot be lower than Min Price'], 422);
        }

        $query = Product::with('category');

        if (isset($validatedData['productName'])) {
            $query->where('name', 'like', '%' . $validatedData['productName'] . '%');
        }

        if (isset($validatedData['categoryName'])) {
            $query->whereHas('category', function ($q) use ($validatedData) {
                $q->where('name', $validatedData['categoryName']);
            });
        }

        if (isset($validatedData['minPrice'])) {
            $query->where('price', '>=', $validatedData['minPrice']);
        }

        if (isset($validatedData['maxPrice'])) {
            $query->where('price', '<=', $validatedData['maxPrice']);
        }

        $filteredProducts = $query->get();

        return response()->json([
            'message' => 'Filtered products retrieved successfully',
            'data' => $filteredProducts,
        ], 200);
    }
}

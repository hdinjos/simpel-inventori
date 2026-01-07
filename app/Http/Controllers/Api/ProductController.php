<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\Product\StoreProductRequest;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('productCategory', 'unit', 'stock')->get();

        return $this->success($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $lastProduct = Product::orderBy('code', 'desc')->first();
        if (!$lastProduct) {
            $firstCode = $this->incrementCode('PRD-00000000');
            $dataReq = array_merge($validated, ["code" => $firstCode]);
            $product = Product::create($dataReq);
            ProductStock::create([
                'product_id' => $product->id,
                'quantity' => 0
            ]);

            $product->load(['productCategory', 'unit', 'stock']);

            return  $this->success($product);
        }
        $lastCode = $lastProduct->code;
        $nextCode =  $this->incrementCode($lastCode);
        $dataReq = array_merge($validated, ["code" => $nextCode]);
        $product = Product::create($dataReq);
        ProductStock::create([
            'product_id' => $product->id,
            'quantity' => 0
        ]);

        $product->load(['productCategory', 'unit', 'stock']);
        return  $this->success($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    protected function incrementCode(string $lastCode, string $prefix = 'PRD', int $pad = 8): string
    {
        // Ambil angka di belakang
        $number = (int) str_replace($prefix . '-', '', $lastCode);

        // Increment
        $nextNumber = $number + 1;

        // Gabungkan kembali
        return $prefix . '-' . str_pad($nextNumber, $pad, '0', STR_PAD_LEFT);
    }
}

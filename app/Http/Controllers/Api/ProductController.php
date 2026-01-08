<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Support\Facades\DB;


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
        $product =  DB::transaction(function () use ($validated) {
            $lastProduct = Product::orderBy('code', 'desc')
                ->lockForUpdate()
                ->first();
            $lastCode = $lastProduct?->code ?? 'PRD-00000000';
            $nextCode = $this->incrementCode($lastCode);

            $dataReq = array_merge($validated, ['code' => $nextCode]);
            $product = Product::create($dataReq);

            $product->stock()->create(['quantity' => 0]);
            return $product;
        });
        $product->load(['productCategory', 'unit', 'stock']);
        return  $this->created($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $product->load(['productCategory', 'unit', 'stock']);
        return $this->success($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($id);
        $product->update($validated);

        $product->load(['productCategory', 'unit', 'stock']);

        return $this->successUpdated($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->successDeleted();
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

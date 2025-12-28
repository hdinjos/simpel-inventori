<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Traits\ApiResponse;
use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;

class ProductCategoryController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::get();
        return $this->success($productCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $validated = $request->validated();
        $productCategories = ProductCategory::create($validated);

        return $this->created($productCategories);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productCategories = ProductCategory::findOrFail($id);
        return $this->success($productCategories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductCategoryRequest $request, string $id)
    {

        $validated = $request->validated();
        $productCategories = ProductCategory::findOrFail($id);
        $productCategories->update($validated);

        return $this->successUpdated($productCategories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productCategories = ProductCategory::findOrFail($id);
        $productCategories->delete();

        return $this->successDeleted();

    }
}

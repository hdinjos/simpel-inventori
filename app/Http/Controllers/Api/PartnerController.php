<?php

namespace App\Http\Controllers\Api;

use App\Models\Partner;
use Illuminate\Http\Request;



use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;

class PartnerController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::with('partnerType:id,name')->get();
        return $this->success($partners);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRequest $request)
    {
        $validated = $request->validated();

        $partners = Partner::create($validated);
        return $this->created($partners);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partner = Partner::with('partnerType:id,name')->findOrFail($id);
        return $this->success($partner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, string $id)
    {
        $validated = $request->validated();
        $partner = Partner::findOrFail($id);

        $partner->update($validated);
        return $this->successUpdated($partner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        return $this->successDeleted();
    }
}

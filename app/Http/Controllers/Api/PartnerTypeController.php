<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerType;
use App\Traits\ApiResponse;
use App\Http\Requests\PartnerType\StorePartnerTypeRequest;
use App\Http\Requests\PartnerType\UpdatePartnerTypeRequest;


class PartnerTypeController extends Controller
{
    use ApiResponse;
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerTypes = PartnerType::get();
        return $this->success($partnerTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerTypeRequest $request)
    {
        $validated = $request->validated();

        $partnerTypes = PartnerType::create($validated);
        return $this->created($partnerTypes);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $partnerType = PartnerType::findOrFail($id);
        return $this->success($partnerType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerTypeRequest $request, string $id)
    {
        $validated = $request->validated();
        $partnerType = PartnerType::findOrFail($id);

        $partnerType->update($validated);
        return $this->successUpdated($partnerType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partnerType = PartnerType::findOrFail($id);
        $partnerType->delete();
        return $this->successDeleted();
    }
}

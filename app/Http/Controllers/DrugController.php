<?php

namespace App\Http\Controllers;

use App\Http\Filters\DrugsFilter;
use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use App\Http\Resources\DrugResource;
use App\Http\Resources\DrugCollection;

use App\Http\Requests\BulkStoreDrugRequest;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new DrugsFilter();
        $filterItems = $filter->transform($request);
        $includePurchaseHistories = $request->query('include');

        $drugs = Drug::where($filterItems);

        if ($includePurchaseHistories) {
            $drugs->with('purchaseHistories');
        }

        $drugs = $drugs->paginate();

        return new DrugCollection($drugs->appends(request()->query()));
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDrugRequest $request)
    {
        return new DrugResource(Drug::create($request->all()));
    }

    public function bulkStore(BulkStoreDrugRequest $request)
    {
        $drugs = Drug::createMany($request->all());
        return DrugResource::collection($drugs);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Drug $drug)
    {
        $includePurchaseHistories = request()->query('include');

        if ($includePurchaseHistories) {
            $drug = new DrugResource($drug->loadMissing('purchaseHistories'));
        }

        return new DrugResource($drug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDrugRequest $request, Drug $drug)
    {
        $drug->update($request->all());
        return new DrugResource($drug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();
        return response()->json(null, 204);
    }
}

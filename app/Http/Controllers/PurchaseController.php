<?php


namespace App\Http\Controllers;

use App\Http\Filters\PurchasesFilter;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Http\Resources\PurchaseCollection;

use App\Models\Drug;
use App\Http\Requests\BulkStorePurchaseRequest;
use Illuminate\Support\Arr;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PurchasesFilter();
        $filterItems = $filter->transform($request);
        
        $purchases = Purchase::where($filterItems);

        $purchases = $purchases->paginate();
    
        return new PurchaseCollection($purchases->appends(request()->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $purchase = Purchase::create($request->all());
        $drug = $purchase->drug;
        $newQuantity = $drug->QUANTITY - $purchase->QUANTITY_PURCHASED;
        $drug->update(['QUANTITY' => max(0, $newQuantity)]);
    
        return new PurchaseResource($purchase);
       // return new PurchaseResource(Purchase::create($request->all()));
    }

    public function bulkStore(BulkStorePurchaseRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr) {
            // Postavi TOTAL_BILL na null ako nije eksplicitno naveden u JSON-u
            $arr['TOTAL_BILL'] = $arr['TOTAL_BILL'] ?? null;
    
            // Ako TOTAL_BILL nije eksplicitno naveden, izračunaj ga na osnovu QUANTITY_PURCHASED i SELLING_PRICE
            if ($arr['TOTAL_BILL'] === null) {
                $drug = Drug::find($arr['DRUG_ID']);
                $arr['TOTAL_BILL'] = $drug->SELLING_PRICE * $arr['QUANTITY_PURCHASED'];
            }
    
            return Arr::only($arr, ['CUSTOMER_ID', 'DRUG_ID', 'QUANTITY_PURCHASED', 'PURCHASE_DATE', 'TOTAL_BILL']);
        });
    
        Purchase::insert($bulk->toArray());
    
        return response()->json(['message' => 'Bulk insert successful'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
    
        return new PurchaseResource($purchase);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $originalQuantityPurchased = $purchase->QUANTITY_PURCHASED;

     
        $purchase->update($request->all());
    
   
        if ($request->has('IS_REFUNDED') && $request->input('IS_REFUNDED') === true || $request->input('IS_REFUNDED') == 1) {
       
            $drug = $purchase->drug;
            $newQuantity = $drug->QUANTITY + $originalQuantityPurchased;
            $drug->update(['QUANTITY' => $newQuantity]);
        }
    
        return new PurchaseResource($purchase);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return response()->json(null, 204);
    }
}

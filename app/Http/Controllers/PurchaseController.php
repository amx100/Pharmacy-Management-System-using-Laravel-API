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
        $arr = $request->all();
        $drug = Drug::find($arr['DRUG_ID']);
        if ($drug && $drug->EXPIRATION_DATE < now()) {
            return response()->json(['message' => 'Izvinjavamo se, ali lek je istekao.', 'data' => $arr], 400);
        }

        $availableQuantity = $drug ? $drug->QUANTITY : 0;
        $requestedQuantity = $arr['QUANTITY_PURCHASED'];
        if ($requestedQuantity > $availableQuantity) {
            return response()->json(['message' => 'Nema dovoljno lekova na stanju.'], 400);
        }
        
        $arr['TOTAL_BILL'] = $arr['TOTAL_BILL'] ?? null;
        $purchase = Purchase::create($arr);

        $newQuantity = $drug->QUANTITY - $arr['QUANTITY_PURCHASED'];
        $drug->update(['QUANTITY' => max(0, $newQuantity)]);

        return new PurchaseResource($purchase);
    }

    public function bulkStore(BulkStorePurchaseRequest $request)
    {
        $bulk = $this->checkDrugsAvailability($request->all());
        $errorDrugs = collect($bulk)->where('error', '!=', null)->all();

        if (!empty($errorDrugs)) {
            return response()->json(['message' => 'Neki lekovi nisu dostupni.', 'error_drugs' => $errorDrugs], 400);
        }

        $bulk = collect($bulk)->reject(function ($arr) {
            return isset($arr['error']);
        })->toArray();

        $formattedBulk = collect($bulk)->map(function ($arr) {
            $arr['TOTAL_BILL'] = $arr['TOTAL_BILL'] ?? $this->calculateTotalBill($arr['DRUG_ID'], $arr['QUANTITY_PURCHASED']);
            return Arr::only($arr, ['CUSTOMER_ID', 'DRUG_ID', 'PURCHASE_DATE', 'QUANTITY_PURCHASED', 'TOTAL_BILL']);
        });

        // Napravite kupovine za preostale lekove
        Purchase::insert($formattedBulk->toArray());

        return response()->json(['message' => 'Bulk insert successful'], 201);
    }

    private function checkDrugsAvailability(array $bulk): array
    {
        return collect($bulk)->map(function ($arr) {
            $drug = Drug::find($arr['DRUG_ID']);
            if ($drug && $drug->EXPIRATION_DATE < now()) {
                return [
                    'CUSTOMER_ID' => $arr['CUSTOMER_ID'],
                    'DRUG_ID' => $arr['DRUG_ID'],
                    'error' => 'Izvinjavamo se, ali lek je istekao.',
                ];
            }

            $availableQuantity = $drug ? $drug->QUANTITY : 0;
            $requestedQuantity = $arr['QUANTITY_PURCHASED'];
            if ($requestedQuantity > $availableQuantity) {
                return [
                    'CUSTOMER_ID' => $arr['CUSTOMER_ID'],
                    'DRUG_ID' => $arr['DRUG_ID'],
                    'error' => 'Nema dovoljno lekova na stanju.',
                ];
            }

            $arr['TOTAL_BILL'] = $arr['TOTAL_BILL'] ?? null;

            return $arr;
        })->toArray();
    }
    
    private function calculateTotalBill($drugId, $quantity)
    {
        $drug = Drug::find($drugId);
        return $drug ? $drug->SELLING_PRICE * $quantity : null;
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

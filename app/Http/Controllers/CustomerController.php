<?php

namespace App\Http\Controllers;

use App\Http\Filters\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use Illuminate\Support\Arr;

use App\Http\Requests\BulkStoreCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request);
        
        $customers = Customer::where($filterItems)->paginate();
        
        return new CustomerCollection($customers->appends(request()->query()));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    public function bulkStore(BulkStoreCustomerRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr) {
            return Arr::only($arr, ['FIRST_NAME', 'LAST_NAME', 'DOB']);
        });

        Customer::insert($bulk->toArray());

        return response()->json(['message' => 'Bulk insert successful'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Request $request)
    {
        $includeDrugs = $request->query('includeDrugs');

        if ($includeDrugs) {
            $customer->load('drugs');
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        $includeDrugs = $request->query('includeDrugs');

        if ($includeDrugs) {
            $customer->load('drugs');
        }

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}

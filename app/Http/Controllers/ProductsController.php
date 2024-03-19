<?php

namespace App\Http\Controllers;

use App\Models\Product;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            // $perPage = $request->input('per_page', 10);
            $perPage = 10;

            $fields = [
                'supplier_id',
                'product_name',
                'quantity',
            ];

            $query = Product::with('supplier')->select($fields)->latest('id');


            $products = $query->paginate($perPage);

            // return response()->json([
            //     'success' => true,
            //     'error' => 'An error occurred.',
            //     'message' => 'Data Rectrive Successfully',
            //     'products' =>  $products,
            // ], 200);

            // dd($products);
            return view('welcome', compact('products'));
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $products = Product::create($validatedData);

            DB::commit();

            return redirect()->route('products.index');
        } catch (\Exception $e) {
            // Handle exceptions, rollback the transaction, and return an error response
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating ItemInfo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
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
}

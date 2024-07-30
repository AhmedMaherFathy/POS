<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Models\Product;
use Modules\Product\Transformers\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponse;

    public function index()
    {
        $products = Product::latest()->paginatedCollection();

        // return response()->json(['data'=> ProductResource::collection($products),
        //                         'message'=> translate_success_message('product', 'created'),
        //                         'status'=> Response::HTTP_OK]);

        return $this->paginatedResponse($products ,ProductResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        if ($request->hasFile('image')) {
            $product->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return response()->json(['data'=> null , 'message'=> 'Product created successfully', 'status'=> Response::HTTP_CREATED]);
    }
    
    public function update(ProductRequest $request , $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        if ($request->hasFile('image')) {
            $product->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return response()->json(['data'=> null , 'message'=> 'Product created successfully', 'status'=> Response::HTTP_CREATED]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if($product)
            return $this->successResponse(ProductResource::make($product));
        else
            return $this->successResponse(message:translate_success_message('product','not_found'));
        // return response()->json(['data'=> $product , 'message'=> 'Product Founded successfully', 'status'=> Response::HTTP_FOUND]);
    }

    // public function update(Request $request, $id): RedirectResponse
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json(['data'=> null , 'message'=> 'Product deleted successfully', 'status'=> Response::HTTP_OK]);
    }
}

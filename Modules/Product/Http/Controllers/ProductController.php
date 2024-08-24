<?php

namespace Modules\Product\Http\Controllers;

use Cloudinary\Cloudinary;
use App\Traits\HttpResponse;
use Illuminate\Http\Response;
use Modules\Product\Models\Product;
use App\Http\Controllers\Controller;
use Modules\Product\Http\Requests\ProductRequest;
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

        return $this->paginatedResponse($products ,ProductResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        if ($request->hasFile('image')) {
            $product->attachMedia($request->validated('image'));
        }

        return response()->json(['data'=> null , 'message'=> translate_success_message('product', 'created'), 'status'=> Response::HTTP_CREATED]);
    }
    
    public function update(ProductRequest $request , $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        // info($request->validated('image'); die;
        if ($request->hasFile('image')) {
            $product->updateMedia($request->validated('image'));
        }

        return response()->json(['data'=> null , 'message'=> translate_success_message('product', 'updated'), 'status'=> Response::HTTP_CREATED]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if($product)
            return $this->successResponse(ProductResource::make($product),message:translate_success_message('product','fetched'));
        else
            return $this->successResponse(message:translate_success_message('product','not_found'));
        // return response()->json(['data'=> $product , 'message'=> 'Product Founded successfully', 'status'=> Response::HTTP_FOUND]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->detachMedia();
        $product->delete();

        return $this->successResponse(message:translate_success_message('product','deleted'));
    }
}

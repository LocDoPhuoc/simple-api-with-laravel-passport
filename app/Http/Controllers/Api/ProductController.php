<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $product = Product::all();

        return $this->sendResponse($product, 'Products retrieved successfully.');
    }

    public function store(Request $request) {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors(), 400);
        }

        $product = Product::create($input);

        return $this->sendResponse($product, 'Product created successfully.');
    }

    public function show($id) {
//        try {
//            $product = Product::findOrFail($id);
//            return $this->sendResponse($product, 'Product retrieved successfully');
//        }
//        catch (ModelNotFoundException $exception) {
//            return $this->sendError('Product not found.');
//        }

        $product = Product::find($id);

        if(is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($product, 'Product retrieved successfully');
    }

    public function update(Request $request, Product $product) {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors(), 400);
        }

        $product->name = $input['name'];
        $product->detail = $input['name'];
        $product->save();

        return $this->sendResponse($product, 'Product updated successfully.');
    }

    public function destroy(Product $product) {
        $product->delete();

        return $this->sendResponse($product->toArray(), 'Product deleted successfully.');
    }

}

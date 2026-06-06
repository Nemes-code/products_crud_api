<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation;


class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }



public function show($id)
{
 return Product::findOrFail($id);
}

public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);

    } catch (\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create product',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function update(Request $request, $id)
{
    try  {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ]);

    $product->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Product updated successfuly',
        'data' => $product
    ]);



}catch (ValidationException $e) {
    return response()->json([
        'message' => false,
        'message' => 'Validation failed',
        'errors' => $e->errors()
    ], 422);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Failed to update product',
        'error' => $e->getMessage()
    ], 500);
}
}

public function destroy($id)
{
 try  {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        
    }

    $product->delete($id);

    return response()->json([
        'success' => true,
        'message' => 'Product updated successfuly',
        
    ]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Failed to delete product',
        'error' => $e->getMessage()
    ], 500);
}
}

}
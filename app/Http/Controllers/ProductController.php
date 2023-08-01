<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Store a new product in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|max:191',
            'qty' => 'required|max:191',
        ]);

        // Create a new Product instance and set its properties from the request data
        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->qty = $request->input('qty');

        // Save the product in the database
        $product->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Product Added Successfully'], 200);
    }

    // Retrieve all products from the database
    public function index()
    {
        $products = Product::all();
        if ($products->count() > 0) {
            return response()->json(['products' => $products], 200);
        } else {
            // Return a JSON response indicating that no product was availabe
            return response()->json(['message' => 'No Product Available..'], 404);
        }
    }

    // Retrieve a specific product by its ID
    public function show($id)
    {
        // Find the product by its ID in the database
        $product = Product::find($id);
        if ($product) {
            return response()->json(['products' => $product], 200);
        } else {
            // Return a JSON response indicating that no product was found with the given ID
            return response()->json(['message' => 'No Product Found.'], 404);
        }
    }

    // Update an existing product in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|max:191',
            'description' => 'required|max:191',
            'price' => 'required|max:191',
            'qty' => 'required|max:191',
        ]);

        // Find the product by its ID in the database
        $product = Product::find($id);
        if ($product) {
            // Update the product properties from the request data
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->qty = $request->input('qty');

            // Save the updated product in the database
            $product->update();

            // Return a JSON response indicating success
            return response()->json(['message' => 'Product Updated Successfully'], 200);
        } else {
            // Return a JSON response indicating that no product was found with the given ID
            return response()->json(['message' => 'No Product Found.'], 404);
        }
    }

    // Delete a product from the database
    public function destroy($id)
    {
        // Find the product by its ID in the database
        $product = Product::find($id);
        if ($product) {
            // Delete the product from the database
            $product->delete();

            // Return a JSON response indicating success
            return response()->json(['message' => 'Product Deleted Successfully'], 200);
        } else {
            // Return a JSON response indicating that no product was found with the given ID
            return response()->json(['message' => 'No Product Found.'], 404);
        }
    }
}

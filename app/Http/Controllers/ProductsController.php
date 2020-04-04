<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    public function create(CreateProductRequest $request)
    {
        try {
            $product = new Product;
            $product->brand = $request->brand;
            $product->name = $request->name;
            $product->description = $request->description;
            if ($request->hasFile('image')) {
                // *** USE FOR UPDATE FUNCTIONALITY ***
                // if (auth()->user()->profile_image) {
                //     // Delete User's Current Image
                //     Storage::delete('/public/images/' . auth()->user()->profile_image);
                // }
                // $request->profile_image->storeAs("images", $filename, "public");
                // auth()->user()->update(["profile_image" => $filename]);
                // return redirect()->back()->with('message', 'Image Uploaded');
                // $image = $request->image;

                // Extract original file name
                $file_name = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
                // Create new formatted file name with unix timestamp
                $file_name_unique = $file_name . "-" . time() . "." . $request->file('image')->getClientOriginalExtension();
                $path = $request->file('image')->storeAs("product_images", $file_name_unique, "public");
                if (!$path) {
                    return response()->json(array('status' => 'error', 'message' => 'failed to upload image'));
                }
                $product->image = $file_name_unique;
            }

            $product->save();

            if (!$product) {
                throw new \Exception("Create Product Error");
            }
            return response()->json(
                $product,
                200
            );
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}

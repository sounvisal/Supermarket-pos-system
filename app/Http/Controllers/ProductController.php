<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\products;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function showproduct()
    {
        $data['pro'] = DB::table('products')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        return view('master.product', $data);
    }
    function addproduct(request $r){
        // Validate the request
        $r->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        $imageName = 'default.jpg';
        if ($r->hasFile('image')) {
            $image = $r->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
        }

        $data = array(
            'product_name' => $r->product_name,
            'price' => $r->price,
            'qty' => $r->qty,
            'category' => $r->category,
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 1,
            'image' => $imageName
        );

        try {
            $result = Products::create($data);
            return redirect('/master/product')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            // If there's an error, delete the uploaded image
            if ($imageName !== 'default.jpg') {
                $imagePath = public_path('images/products/' . $imageName);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            return redirect('/master/addproduct')->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }
    function editproduct($id){
        $data['result'] = Products::where('id',$id)->first();
        return view('master.editproduct', $data);
    }
    function updateproduct(request $r){
        $data = array(
            'product_name' => $r->product_name,
            'price' => $r->price,
            'qty' => $r->qty,
            'category'=>$r->category,
            'updated_at'=>now(),
        );
        $result = Products::where('id',$r->id)->update($data);
        if($result){
            return redirect('/master/product')->with('success', 'Product updated successfully');
        }else{
            return redirect('/master/product/update')->with('error', 'Failed to update product');
        }

    }
    function deleteproduct($id){
        $result = Products::where('id',$id)->update(['status'=>0]);
        if($result){
            return redirect('/master/product')->with('success', 'Product deleted successfully');
        }else{
            return redirect('/master/product')->with('error', 'Failed to delete product');
        }
    }
    function restock($id){
        $data['result'] = Products::where('id',$id)->first();
        return view('master.restock', $data);
    }
    function restockproduct(request $r){
        // Get the current product
        $product = Products::where('id', $r->id)->first();
        
        // Add the new quantity to the existing quantity
        $data = array(
            'qty' => $product->qty + $r->qty,
            'updated_at' => now(),
        );
        
        $result = Products::where('id', $r->id)->update($data);
        
        if($result){
            return redirect('/master/product')->with('success', 'Product restocked successfully');
        }else{
            return redirect('/master/product/restock')->with('error', 'Failed to restock product');
        }
    }
    function searchproduct(request $r){
        $data['pro'] = DB::table('products')
            ->where('status', 1)
            ->where(function($query) use ($r) {
                $query->where('product_name', 'like', '%' . $r->search . '%')
                      ->orWhere('category', 'like', '%' . $r->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->appends(['search' => $r->search]); 
        return view('master.product', $data);
    }
}

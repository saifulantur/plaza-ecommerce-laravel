<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Image;

class ProductController extends Controller
{
    function addProductview(){
        $product_data =  Product::paginate(5);//For pagination
        $trashed_data = Product::onlyTrashed()->get(); //get soft deleted data
        $categories = Category::all();
        return view('product/view',compact('product_data', 'trashed_data', 'categories'));
    }

    function restoreProducts($product_id){
        Product::onlyTrashed()->find($product_id)->restore();
        return back()->with('updateStatus','Product Restored Successfully');
    }

    function permanentDeleteProducts($product_id){

        //First delete previus photo
        if(Product::onlyTrashed()->find($product_id)->productImage != 'defaultproductimage.jpg'){
            $delete_this_file = Product::onlyTrashed()->find($product_id)->productImage;
            unlink(base_path('public/uploads/product_photos/'.$delete_this_file));//delete image from storage
        }
        Product::onlyTrashed()->find($product_id)->forceDelete();
        return back();
    }

    function addProductInsert(Request $request){

        $request->validate([
            'productName' => 'required',
            'categoryId' => 'required',
            'productDescription' => 'required',
            'productPrice' => 'required|numeric',
            'productQuantity' => 'required|numeric',
            'alertQuantity' => 'required|numeric',

        ]);
        $last_inserted_id = Product::insertGetId([
            'productName' => $request->productName,
            'categoryId' => $request->categoryId,
            'productDescription' => $request->productDescription,
            'productPrice' => $request->productPrice,
            'productQuantity' => $request->productQuantity,
            'alertQuantity' => $request->alertQuantity,
        ]);
        
        // echo $last_inserted_id;
        if($request->hasFile('productImage')){
            
            $photo_to_upload = $request->productImage;
            $fileName = $last_inserted_id. "." .$photo_to_upload->getClientOriginalExtension();
            // base_path('uploads/product_photos/'.$fileName);
            // print_r($photo_to_upload->getClientOriginalExtension());
            Image::make($photo_to_upload)->resize(300, 200)->save(base_path('public/uploads/product_photos/'.$fileName), 100);
            Product::findOrFail($last_inserted_id)->update([
                'productImage' => $fileName,
            ]);
        }

        return back()->with('status','Product Insert Successfully');
    }

    function deleteProduct($product_id){
        Product::find($product_id)->delete(); //soft delete
        return back()->with('deleteStatus','Product Deleted Successfully');
    }

    function editProduct($product_id){

        $single_product_info = Product::findOrFail($product_id);
        return view('product/edit', compact('single_product_info'));//redirect to edit page
    }

    function editProductInsert(Request $request){

        //productId->get From edit.blade.php page
        if($request->hasFile('productImage')){

            if (Product::find($request->productId)->productImage == 'defaultproductimage.jpg') {

                //upload new image if this is not default photo
                $photo_to_upload = $request->productImage;
                $fileName = $request->productId. "." .$photo_to_upload->getClientOriginalExtension();
                Image::make($photo_to_upload)->resize(300, 200)->save(base_path('public/uploads/product_photos/'.$fileName), 100);
                Product::findOrFail($request->productId)->update([
                    'productImage' => $fileName,
                ]);//end of uploading photo

            }else{
                //First delete previus photo
                $delete_this_file = Product::find($request->productId)->productImage;
                unlink(base_path('public/uploads/product_photos/'.$delete_this_file));//delete image from storage

                //then upload new image
                $photo_to_upload = $request->productImage;
                $fileName = $request->productId. "." .$photo_to_upload->getClientOriginalExtension();
                Image::make($photo_to_upload)->resize(300, 200)->save(base_path('public/uploads/product_photos/'.$fileName), 100);
                Product::findOrFail($request->productId)->update([
                    'productImage' => $fileName,
                ]);//end of uploading photo

            }//end of else or delete image from storage
        }//end of updating image logic
        
        Product::findOrFail($request->productId)->update([
            'productName' => $request->productName,
            'productDescription' => $request->productDescription,
            'productPrice' => $request->productPrice,
            'productQuantity' => $request->productQuantity,
            'alertQuantity' => $request->alertQuantity,
        ]);
        return back()->with('updateStatus','Product Updated Successfully');
    }
}
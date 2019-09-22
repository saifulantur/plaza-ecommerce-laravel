<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;


class FrontendController extends Controller
{
    function index(){
        $product_table_data = Product::all();
        return view('welcome', compact('product_table_data'));
    }

    function contact(){
        return view('contact');
    }

    function productDetails($product_id){
        $single_product_details = Product::findOrFail($product_id);
        // echo Product::findOrFail($product_id)->relationToCategory->categoryName;
        // echo $single_product_details->categoryId;
        $related_products = Product::where('id', '!=' , $product_id)->where('categoryId', $single_product_details->categoryId)->get(); 
        // // echo $related_products;
        return view('frontend/productDetails', compact('single_product_details','related_products'));
    }

    function categoryWiseProduct($category_id){

       $products =  Product::where('categoryId', '=', $category_id)->get();
       $categoryName = Category::where('id', $category_id)->get();

        return view('frontend/categoryWiseProduct', compact('products', 'categoryName'));
    }
}
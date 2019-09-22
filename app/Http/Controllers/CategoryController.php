<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    function addCategoryView(){
    	$category_data = Category::all();
    	return view('category/view', compact('category_data'));
    }

    function addCategoryInsert(Request $request){

    	$request->validate([

    		'categoryName' => 'required|unique:categories,categoryName',
    	]);

    	if(isset($request->menuStatus)){

            Category::insert([
                'categoryName' => $request->categoryName,
                'menuStatus' => true,
                'created_at' => Carbon::now(),
            ]);

        }
        else{

            Category::insert([
                'categoryName' => $request->categoryName,
                'menuStatus' => false,
                'created_at' => Carbon::now(),
            ]);
        }

    	

    	return back()->with('success_status','Category Inserted Successfully');
    }
}

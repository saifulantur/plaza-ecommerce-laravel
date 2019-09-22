<?php



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/add/product/view','ProductController@addProductview');
Route::post('/add/product/insert','ProductController@addProductInsert');

Route::get('/delete/product/{product_id}','ProductController@deleteProduct');

Route::get('/edit/product/{product_id}','ProductController@editProduct');
Route::post('/edit/product/insert','ProductController@editProductInsert');

Route::get('/restore/products/{product_id}','ProductController@restoreProducts'); //restore soft delete data
Route::get('/parmanent/delete/products/{product_id}','ProductController@permanentDeleteProducts');

//category route

Route::get('/add/category/view','CategoryController@addCategoryView');
Route::post('/add/category/insert','CategoryController@addCategoryInsert');


//Frontend Routes

Route::get('contact', 'FrontendController@contact');
Route::get('/', 'FrontendController@index');
Route::get('/product/details/{product_id}', 'FrontendController@productDetails');

Route::get('category/wise/product/{category_id}', 'FrontendController@categoryWiseProduct');
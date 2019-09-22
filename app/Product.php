<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['productName','productDescription','productPrice','productQuantity','alertQuantity', 'productImage'];
    protected $dates = ['deleted_at'];

    function relationToCategory(){
    	return $this->hasOne('App\Category', 'id', 'categoryId');
    }
}
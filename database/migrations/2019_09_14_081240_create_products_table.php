<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('productName');
            $table->unsignedBigInteger('categoryId');
            $table->longText('productDescription');
            $table->integer('productPrice');
            $table->integer('productQuantity');
            $table->integer('alertQuantity');
            $table->string('productImage')->default('defaultproductimage.jpg');
            
            $table->timestamps();
            $table->softDeletes();

            //foreignkey
             $table->foreign('categoryId')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
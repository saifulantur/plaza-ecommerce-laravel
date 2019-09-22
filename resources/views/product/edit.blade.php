@extends('layouts/app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url ('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url ('/add/product/view')}}">Product List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$single_product_info->productName}}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">
                    Edit Product Data
                    <!-- {{$single_product_info}} -->
                </div>
                <div class="card-body">
                    <form action="{{ url('edit/product/insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if (session('updateStatus'))
                        <div class="alert alert-success">
                            {{session('updateStatus') }}
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="hidden" name="productId" value="{{$single_product_info->id}}">
                            <input type="text" name="productName" value="{{$single_product_info->productName}}"
                            class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Product Description</label>
                            <textarea class="form-control" name="productDescription" id="exampleFormControlTextarea1"
                            rows="3">{{$single_product_info->productDescription}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Price</label>
                            <input type="text" class="form-control" name="productPrice"
                            value="{{$single_product_info->productPrice}}" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter Product Price">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Quantity</label>
                            <input type="text" class="form-control" name="productQuantity"
                            value="{{$single_product_info->productQuantity}}" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter Product Quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alert Quantity</label>
                            <input type="text" class="form-control" name="alertQuantity"
                            value="{{$single_product_info->alertQuantity}}" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter ALert Quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Image</label>
                            <input type="file" class="form-control" name="productImage" id="exampleInputEmail1">
                        </div>
                        <div>
                            <img width="150" src="{{ asset('uploads/product_photos') }}/{{ $single_product_info->productImage }}" alt="Not Found">
                        </div>
                        
                        <button type="submit" class="btn btn-warning mt-2">Edit Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
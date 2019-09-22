@extends('layouts/app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Products Data
                </div>
                <div class="card-body">
                    @if (session('deleteStatus'))
                    <div class="alert alert-danger">
                        {{session('deleteStatus') }}
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">SL No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Alert Quantity</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product_data as $product)
                            <tr>
                                <th scope="row">{{$loop->index + 1}}</th>
                                <td>{{$product->productName}}</td>
                                <!-- <td>{{App\Category::find($product->categoryId)->categoryName}}</td> -->
                                <td>{{ $product->relationToCategory->categoryName }}</td>
                                <td>{{str_limit($product->productDescription, 20)}}</td>
                                <td>{{$product->productPrice}}</td>
                                <td>{{$product->productQuantity}}</td>
                                <td>{{$product->alertQuantity}}</td>
                                <td>
                                    <img src="{{ asset('uploads/product_photos') }}/{{ $product->productImage }}"
                                    alt="Not Found" width="50">
                                </td>
                                <td><a class="btn btn-sm btn-warning mb-1"
                                href="{{ url('edit/product') }}/{{$product->id}}">Edit</a><br>
                                <a class="btn btn-sm btn-danger"
                                href="{{ url('delete/product') }}/{{$product->id}}">Delete</a></td>
                                <!-- <td></td> -->
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7"> No data available </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $product_data->links()}}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Add Product Data
                </div>
                <div class="card-body">
                    <form action="{{ url('add/product/insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{session('status') }}
                        </div>
                        @endif
                        @if($errors->all())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" name="productName" value="{{ old('productName') }}" class="form-control"
                            id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                            <label >Category Name</label>
                            <select class="form-control" name="categoryId">
                                <option> ---Select One ---</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Product Description</label>
                            <textarea class="form-control" name="productDescription" id="exampleFormControlTextarea1"
                            rows="3">{{ old('productDescription') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Price</label>
                            <input type="text" class="form-control" name="productPrice"
                            value="{{ old('productPrice') }}" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter Product Price">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Quantity</label>
                            <input type="text" class="form-control" name="productQuantity"
                            value="{{ old('productQuantity') }}" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter Product Quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alert Quantity</label>
                            <input type="text" class="form-control" name="alertQuantity"
                            value="{{ old('alertQuantity') }}" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter ALert Quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="file" class="form-control" name="productImage" id="exampleInputEmail1">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg bg-danger text-white">
                    Deleted Products Data
                </div>
                <div class="card-body">
                    @if (session('updateStatus'))
                    <div class="alert alert-success">
                        {{session('updateStatus') }}
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">SL No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Alert Quantity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trashed_data as $trashed_data)
                            <tr>
                                <th scope="row">{{$loop->index + 1}}</th>
                                <td>{{$trashed_data->productName}}</td>
                                <td>{{str_limit($trashed_data->productDescription, 20)}}</td>
                                <td>{{$trashed_data->productPrice}}</td>
                                <td>{{$trashed_data->productQuantity}}</td>
                                <td>{{$trashed_data->alertQuantity}}</td>
                                <td>
                                    <a href="{{url('restore/products/')}}/{{ $trashed_data->id }}"
                                    class="btn btn-success btn-sm">Restore</a>
                                    <a href="{{url('parmanent/delete/products/')}}/{{ $trashed_data->id }}"
                                    class="btn btn-danger btn-sm mt-1">Permanent Delete</a>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7"> No data available </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
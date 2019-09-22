@extends('layouts/app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg bg-primary text-white">
                    Category Data
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
                                <th scope="col">Category Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Menu Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category_data as $category)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{ $category->categoryName }}</td>
                                <td>
                                    {{ $category->created_at->format('d-M-Y h:i:s A') }}
                                    <br>
                                    {{ $category->created_at->diffForHumans() }}
                                </td>
                                <td>{{ ($category->menuStatus == 1)? "Yes":"NO" }}</td>
                                <td></td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="4"> No data available </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg bg-primary text-white">
                    Add Category Data
                </div>
                <div class="card-body">
                    <form action="{{ url('add/category/insert') }}" method="post">
                        @csrf
                        @if (session('success_status'))
                        <div class="alert alert-success">
                            {{session('success_status') }}
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
                            <label for="categoryName ">Category Name</label>
                            <input type="text" name="categoryName" value="{{ old('productName') }}" class="form-control"
                            id="categoryName" aria-describedby="emailHelp" placeholder="Enter Category Name">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="menuStatus" value="1" id="menuStatus"><label for="menuStatus">Use as menu</label>
                        </div>
                        <button type="submit" class="btn btn-success">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
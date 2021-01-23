@extends('layouts.master')

@section('title')
    Drug Market | New Product
@endsection

@section('add')
    active    
@endsection

@section('product')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          New Product
          <small>Add</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-success">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- /.box-header -->
            
            {{-- Image Preview --}}
            <img src="{{asset('images/default_vector_product.jpg')}}" class="d-block w-25 mx-auto mt-2 mb-3" alt="Product Image" id="preview_image">
            
            <div class="text-center mx-auto mb-3">
                <button type="button" class="font-weight-bold btn btn-primary mx-2" id="upload_image">Upload</button>
                <button type="button" class="font-weight-bold btn btn-danger mx-2" id="delete_image">Delete</button>
            </div>

            <!-- form start -->
            <form role="form" action="{{route('product.create')}}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- image Input --}}
                <input type="file" id="image" name='new_image' class="d-none">
            
                <div class="box-body">
                    <div class="row m-0">
                        {{-- Product Name --}}
                        <div class="form-group col-lg-6">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The Product Name" value="{{old('name')}}">
                        </div>

                        {{-- Description --}}
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea rows='5' class="form-control" id="description" name="description">{{old('description')}}</textarea>
                        </div>
                        
                        {{-- Price --}}
                        <div class="form-group col-lg-6">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                </div>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter The Price" value="{{old('price')}}">
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div class="form-group col-lg-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter The Quantity" value="{{old('quantity')}}">
                        </div>

                        {{-- Product Category --}}
                        <div class="form-group col-lg-6">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-success font-weight-bold mx-2">Submit</button>
                    <a href="{{route('dashboard')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

    <script>
        $('#upload_image').click(function () {
            $("#image").click();
        })

        $("#image").on('change',function () {
            var validImageTypes = ["image/gif","image/jpeg", "image/png"];
            if (this.files && this.files[0] && $.inArray(this.files[0]['type'],validImageTypes) > 0 ) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                $('#preview_image').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(this.files[0]); // convert to base64 string
            }
        })

        $("#delete_image").on('click',function () {
            $('#preview_image').attr('src',"{{asset('images/default_vector_product.jpg')}}");
            $("#image").val("");
        });
    </script>

@endsection

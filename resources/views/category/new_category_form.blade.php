@extends('layouts.master')

@section('title')
    Drug Market | New Category
@endsection

@section('add')
    active    
@endsection

@section('category')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          New Category
          <small>Add</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-dark">
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
            
            <!-- form start -->
            <form role="form" action="{{route('category.create')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row m-0">
                        {{-- Category Name --}}
                        <div class="form-group col-lg-6">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter The Category Name" value="{{old('category_name')}}">
                        </div>

                        {{-- Description --}}
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea rows='5' class="form-control" id="description" name="description" value="">{{old('description')}}</textarea>
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

@endsection

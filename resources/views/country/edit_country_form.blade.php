@extends('layouts.master')

@section('title')
    Drug Market | Edit Country    
@endsection

@section('view')
    active    
@endsection

@section('view-country')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Country
          <small>Edit</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
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
            <form role="form" action="{{route('country.edit.save')}}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- id  --}}
                <input type="hidden" name='id' value="{{old('id',$country->id)}}">
                
                <div class="box-body">
                    <div class="row m-0">

                        {{-- Country Name --}}
                        <div class="form-group col-lg-6">
                            <label for="name">Country Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The Country Name" value="{{old('name',$country->name)}}">
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-success font-weight-bold mx-2">Submit</button>
                    <a href="{{route('countries.view')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

@endsection

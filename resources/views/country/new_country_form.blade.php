@extends('layouts.master')

@section('title')
    Drug Market | New Country
@endsection

@section('add')
    active    
@endsection

@section('country')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          New Country
          <small>Add</small>
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
            <form role="form" action="{{route('country.create')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row m-0">
                        {{-- Country Name --}}
                        <div class="form-group col-lg-6">
                            <label for="country_name">Country Name</label>
                            <input type="text" class="form-control" id="country_name" name="name" placeholder="Enter The Country Name" value="{{old('country_name')}}">
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

@extends('layouts.master')

@section('title')
    Drug Market | New State
@endsection

@section('add')
    active    
@endsection

@section('state')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          New State
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
        <form role="form" action="{{route('state.create')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row m-0">

                        {{-- State Name --}}
                        <div class="form-group col-lg-6">
                            <label for="name">State Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The State Name" value="{{old('name')}}">
                        </div>

                        {{-- State's City --}}
                        <div class="form-group col-lg-6">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control">
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
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

@endsection

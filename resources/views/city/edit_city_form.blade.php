@extends('layouts.master')

@section('title')
    Drug Market | Edit City    
@endsection

@section('view')
    active    
@endsection

@section('view-city')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            City
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
            <form role="form" action="{{route('city.edit.save')}}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- id  --}}
                <input type="hidden" name='id' value="{{old('id',$city->id)}}">
                
                <div class="box-body">
                    <div class="row m-0">

                        {{-- City Name --}}
                        <div class="form-group col-lg-6">
                            <label for="name">City Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The City Name" value="{{old('name',$city->name)}}">
                        </div>

                        {{-- City's Country --}}
                        <div class="form-group col-lg-6">
                            <label for="country">Country</label>
                            <select name="country" id="country" class="form-control">
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" @if ($country->id == $city->country->id)
                                        selected
                                    @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-success font-weight-bold mx-2">Submit</button>
                    <a href="{{route('cities.view')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

@endsection

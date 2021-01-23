@extends('layouts.master')

@section('title')
    Drug Market | Edit States    
@endsection

@section('view')
    active    
@endsection

@section('view-state')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            States
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
            <form role="form" action="{{route('state.edit.save')}}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- id  --}}
                <input type="hidden" name='id' value="{{old('id',$state->id)}}">
                
                <div class="box-body">
                    <div class="row m-0">

                        {{-- State Name --}}
                        <div class="form-group col-lg-6">
                            <label for="name">State Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The State Name" value="{{old('name',$state->name)}}">
                        </div>

                        {{-- State's City --}}
                        <div class="form-group col-lg-6">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control">
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}" @if ($city->id == $state->city->id)
                                        selected
                                    @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-success font-weight-bold mx-2">Submit</button>
                    <a href="{{route('states.view')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

@endsection

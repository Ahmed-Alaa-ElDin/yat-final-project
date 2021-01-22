@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          User
          <small>Add New</small>
        </h1>
      </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/user/form" method="POST">
                @csrf
                <div class="box-body">
                    <div class="row m-0">
                        
                        {{-- First Name --}}
                        <div class="form-group col-lg-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name">
                        </div>

                        {{-- Last Name --}}
                        <div class="form-group col-lg-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your First Name">
                        </div>
                        
                        {{-- Passward --}}
                        <div class="form-group col-lg-6">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" id="Password" placeholder="Enter Password">
                        </div>

                        {{-- Email --}}
                        <div class="form-group col-lg-6">
                            <label for="email">Email address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" placeholder="Enter Your Email">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone-alt"></i></span>
                                <input type="text" class="form-control" id="phone" placeholder="Enter Your Phone">
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="form-group col-lg-6 row">
                            <label class="col-lg-12">Gender</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" name="gender" id="male" checked="checked">
                                    </span>
                                    <label class="form-control text-center" for="male">Male</label>
                                </div>
                            </div>
                            <div class="offset-4 col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="radio" name="gender" id="female">
                                    </span>
                                    <label class="form-control text-center" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Image --}}
                        <div class="form-group col-lg-6">
                            <label for="image">Image</label>
                            <input type="file" id="image">
                            <p class="help-block">Kindly Select Your Image</p>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>
@endsection
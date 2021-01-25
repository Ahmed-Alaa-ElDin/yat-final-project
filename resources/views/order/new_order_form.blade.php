@extends('layouts.master')

@section('title')
    Drug Market | New Order
@endsection

@section('add')
    active    
@endsection

@section('order')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            New Order
            <small>Add</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
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
        <form role="form" action="{{route('address.create')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row m-0">

                        {{-- User --}}
                        <div class="form-group col-lg-4">
                            <label for="user">User Name</label>
                            <select name="user" id="user" class="form-control">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Address --}}
                        <div class="form-group col-lg-8">
                            <label for="address">Address</label>
                            <select name="address" id="address" class="form-control" disabled="disabled">
                                <option value="">Select Address</option>
                                <option value="0">New Address</option>
                            </select>
                        </div>

                        {{-- Country --}}
                        <div class="form-group col-lg-4 d-none">
                            <label for="country">Country</label>
                            <select name="country" id="country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="form-group col-lg-4 d-none">
                            <label for="city">City</label>
                            <select name="city" id="city" class="form-control">
                                <option value="">Select City</option>
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="form-group col-lg-4 d-none">
                            <label for="state">State</label>
                            <select name="state" id="state" class="form-control">
                                <option value="">Select State</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="box-footer col-lg-12 text-center">
                    <button type="submit" class="btn btn-success font-weight-bold mx-2 d-none" id="submitAddress">Use Address & Go To Product</button>
                    <a href="{{route('dashboard')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
    <script>
        
        // get user addresses
        $('#user').on('change', function () {
            $('#submitAddress').addClass('d-none');
            if ($(this).val() != '') {
                $("#address").prop("disabled", false);
                $.ajax({
                    url: '{{route("address.get")}}',
                    method: 'GET',
                    data: {
                        '_token' : '{{csrf_token()}}',
                        'user_id' : $(this).val()
                    },
                    success: function (res) {
                        $("#address").empty().append(`
                                                    <option value="">Select Address</option>
                                                    <option value="0">New Address</option>`
                                                    );
                        $('#country, #city, #state').val("").parent().addClass('d-none');
                        $.each(res.addresses, function (index,value) {
                            $("#address").append(`<option value='${index}'>${value}</option>`);
                        });
                    }
                });
            } else {
                $("#address").prop("disabled", true).val("");
                $('#country, #city, #state').val("").parent().addClass('d-none');
            }
        })

        // check if you need to add a new address
        $("#address").on('change', function () {
            if ($(this).val() == '0') {
                $('#country').parent().removeClass('d-none');
                $('#submitAddress').addClass('d-none');
            } else if ($(this).val() > '0') {
                $('#country, #city, #state').val("").parent().addClass('d-none');
                $('#submitAddress').text('Use Address & Go To Product').removeClass('d-none');
            } else {
                $('#submitAddress').addClass('d-none');
                $('#country, #city, #state').val("").parent().addClass('d-none');
            }
        })

        // get cities of selected country
        $('#country').on('change', function () {
            $('#state').parent().addClass('d-none');
            $('#city,#state').empty();
            $('#city').append(`<option value="">Select City</option>`);
            $('#state').append(`<option value="">Select State</option>`);
            if ($(this).val() != '') {
                $.ajax({
                    url: '{{route("city.get")}}',
                    method: 'GET',
                    data: {
                        '_token' : '{{csrf_token()}}',
                        'country_id' : $(this).val()
                    },
                    success: function (res) {
                        $('#city').parent().removeClass('d-none');
                        $.each(res.cities, function (index,value) {
                            $("#city").append(`<option value='${value.id}'>${value.name}</option>`);
                        });
                    }
                });
            } else {
                $('#city,#state').parent().addClass('d-none');
            }
        })

        // get states of selected city
        $('#city').on('change', function () {
            $('#state').empty();
            $('#state').append(`<option value="">Select State</option>`);
            if ($(this).val() != '') {
                $.ajax({
                    url: '{{route("state.get")}}',
                    method: 'GET',
                    data: {
                        '_token' : '{{csrf_token()}}',
                        'city_id' : $(this).val()
                    },
                    success: function (res) {
                        $('#state').parent().removeClass('d-none');
                        $.each(res.states, function (index,value) {
                            $("#state").append(`<option value='${value.id}'>${value.name}</option>`);
                        });
                    }
                });
            } else {
                $('#state').parent().addClass('d-none');
            }
        })

        $('#state').on('change', function () {
            if ($(this).val() != "") {
                $('#submitAddress').text('Add Address & Go To Product').removeClass('d-none');
            } else {
                $('#submitAddress').addClass('d-none');
            }
        })
    </script>
@endsection

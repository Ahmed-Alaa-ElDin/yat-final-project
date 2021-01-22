@extends('layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Profile
          <small>Modify</small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="box box-primary">
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
            <img src="{{$user->profile_photo_url}}" class="d-block w-25 mx-auto mt-2 mb-3" alt="Profile Image" id="preview_image">
            <div class="text-center mx-auto mb-3">
                <form id="upload_image_form">
                    @csrf
                    <input type="submit" name="submit" id="submit_photo" class="d-none">
                    <input type="file" id="image" name='new_image' class="d-none">
                </form>
                <button type="button" class="font-weight-bold btn btn-primary mx-2" id="upload_image">Upload</button>
                <button type="button" class="font-weight-bold btn btn-danger mx-2" id="delete_image">Delete</button>
            </div>
            <!-- form start -->
            <form role="form" action="{{route('profile.update')}}" method="POST">
                @method('PATCH')
                @csrf

                <div class="box-body">
                    <div class="row m-0">
                        {{-- First Name --}}
                        <div class="form-group col-lg-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name" value="{{old('first_name',$user->first_name)}}">
                        </div>

                        {{-- Last Name --}}
                        <div class="form-group col-lg-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name" value="{{old('last_name',$user->last_name)}}">
                        </div>
                        
                        {{-- Email --}}
                        <div class="form-group col-lg-6">
                            <label for="email">Email address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" value="{{old('email',$user->email)}}">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone" value="{{old('phone',$user->phone)}}">
                            </div>
                        </div>

                        {{-- Old Passward --}}
                        <div class="form-group col-lg-4">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter Password" autocomplete="off"> 
                        </div>
                        {{-- New Passward --}}
                        <div class="form-group col-lg-4">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter New Password"> 
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Repeat Your New Password"> 
                        </div>

                        {{-- Gender --}}
                        <div class="form-group col-lg-6 row">
                            <label class="col-lg-12">Gender</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="gender" id="male" value="1" @if (old('gender',$user->gender) == '1')checked="checked"@endif>
                                        </div>
                                    </div>
                                    <label class="form-control text-center" for="male">Male</label>
                                </div>
                            </div>
                            <div class=" col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="gender" id="female" value="2" @if (old('gender',$user->gender) == '2')checked="checked"@endif>
                                        </div>
                                    </div>
                                    <label class="form-control text-center" for="female">Female</label>
                                </div>
                            </div>
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
    <script>
        $('#upload_image').click(function () {
            $("#image").click();
        })
        $("#image").on('change',function () {
            $("#submit_photo").click();
        })

        $("#upload_image_form").on('submit',function (e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: '{{route("profile.photo.upload")}}' ,
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cach: false,
                processData: false,
                success: function (res) {
                    if (res.success) {
                        $('#preview_image').attr('src',('images/' + res.image));
                    } 
                }
            })
        });

        $("#delete_image").on('click',function () {
            $.ajax({
                method: "DELETE",
                url: '{{route("profile.photo.delete")}}' ,
                data: {'_token':'{{csrf_token()}}','id': '{{Auth::user()->id}}'},
                dataType: 'JSON',
                success: function (res) {
                    if (res.success) {
                        $('#preview_image').attr('src',('images/default_vector.jpg'));
                    }
                }
            })
        });
    </script>
@endsection
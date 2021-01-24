@extends('layouts.master')

@section('title')
    Drug Market | Edit User    
@endsection

@section('view')
    active    
@endsection

@section('view-user')
    active
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          User
          <small>Edit</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
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
            <img src="{{asset($user->profile_photo_url) }}" class="d-block w-25 mx-auto mt-2 mb-3" alt="Profile Image" id="preview_image">
            
            <div class="text-center mx-auto mb-3">
                <button type="button" class="font-weight-bold btn btn-primary mx-2" id="upload_image">Upload</button>
                <button type="button" class="font-weight-bold btn btn-danger mx-2" id="delete_image">Delete</button>
            </div>

            <!-- form start -->
            <form role="form" action="{{route('user.edit')}}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- id  --}}
                <input type="hidden" name='id' value="{{old('id',$user->id)}}">
                
                {{-- image Input --}}
                <input type="file" id="image" name='new_image' class="d-none" value="{{old('new_image',$user->profile_photo_url)}}">
                
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
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" value="{{old('email',$user->email)}}" autocomplete="new-mail">
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

                        {{-- User Role --}}
                        <div class="form-group col-lg-6">
                            <label for="role">User Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1">User</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>

                        {{-- Gender --}}
                        <div class="form-group col-lg-6 row">
                            <label class="col-lg-12">Gender</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="gender" id="male" value="1" @if (old('gender',$user->gender) != '2')checked="checked"@endif>
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
                    <a href="{{route('users.view')}}" class="btn btn-danger font-weight-bold mx-2">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->

    <script>
        // trigger browsing files
        $('#upload_image').click(function () {
            $("#image").click();
        })

        // after upload event
        $("#image").on('change',function () {
            var validImageTypes = ["image/gif","image/jpeg", "image/png"];
            if (this.files && this.files[0] && $.inArray(this.files[0]['type'],validImageTypes) > 0 ) {
                console.log(this.files && this.files[0]);
                var reader = new FileReader();
                
                reader.onload = function(e) {
                $('#preview_image').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(this.files[0]); // convert to base64 string
            } else {
                $('#preview_image').attr('src', '{{asset('images/default_vector.jpg')}}');
                $("#image").val("");
            }
        })

        $("#delete_image").on('click',function () {
            $("#image").val("");
            $.ajax({
                method: "PATCH",
                url: '{{route("user.photo.delete")}}' ,
                data: {'_token':'{{csrf_token()}}','id': '{{$user->id}}'},
                dataType: 'JSON',
                success: function (res) {
                    if (res.success) {
                        $('#preview_image').attr('src','{{asset('images/default_vector.jpg')}}');
                    }
                }
            })
        });
    </script>

@endsection

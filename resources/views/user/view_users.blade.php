@extends('layouts.master')

@section('title')
    Drug Market | View Users    
@endsection

@section('view')
    active    
@endsection

@section('view-user')
    active
@endsection

@section('content')
    {{-- incomming Messages --}}
    @if (session('message'))
        <div class="alert text-center font-weight-bold
            @if (session('message_type') == "good")
                alert-success 
            @else
                alert-danger
            @endif
            alert-dismissible fade show" role="alert">
                {{session('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
    @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          All Users
          <small>View & Modify</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <table id="users_datatable" class="table text-center table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="bg-warning">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Visits Number</th>
                    <th>Role</th>
                    <th>More</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($users as $user)

                    <tr>
                        <td class="align-middle">{{$user->first_name . " " . $user->last_name}}</td>
                        <td class="align-middle">{{$user->email}}</td>
                        <td class="align-middle">{{$user->phone}}</td>
                        <td class="align-middle">{{$user->visit_number}}</td>
                        <td class="align-middle">
                            @if ($user->group_id == '1')
                            User
                            @elseif ($user->group_id == '2')
                            Admin
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-info font-weight-bold userDetailsButton" data-id="{{$user->id}}" data-toggle="modal" data-target="#detailsModal">Details</button>
                            <a class="btn btn-primary font-weight-bold" href="{{route('user.edit', $user->id)}}" data-id="{{$user->id}}">Edit</a>
                            <button type="button" class="btn btn-danger font-weight-bold deleteButton" data-id="{{$user->id}}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <!-- /.content -->

    {{-- Details Modal --}}
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="detailsModalLabel">User Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <img src="images/default_vector.jpg" class="d-block w-25 mx-auto mt-2 mb-3" alt="Profile Image" id="profile_image">
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <tr>
                        <th class="bg-warning">First Name</th>
                        <td><span id="new_first_name" class='old_data'> </span></td>
                    
                        <th class="bg-warning">Last Name</th>
                        <td><span id="new_last_name" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Email</th>
                        <td><span id="new_email" class='old_data'> </span> <small id="verified" class="text-danger old_data font-weight-bold"></small></td>
                    
                        <th class="bg-warning">Phone</th>
                        <td><span id="new_phone" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Gender</th>
                        <td><span id="new_gender" class='old_data'> </span></td>
                    
                        <th class="bg-warning">Credit</th>
                        <td><span id="new_credit" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Number of Visits</th>
                        <td><span id="new_visit_number" class='old_data'> </span></td>
                    
                        <th class="bg-warning">Last Visit</th>
                        <td><span id="new_last_visit" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Created</th>
                        <td><span id="new_created" class='old_data'> </span></td>
                    
                        <th class="bg-warning">Last Update</th>
                        <td><span id="new_updated" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Role</th>
                        <td><span id="new_role" class='old_data'> </span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger m-auto" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    {{-- Confirm Delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="deleteModalLabel">Confirm Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br>
                <h5 class="text-center">Are You Sure You Want To Delete This User ??</h5>
                <br>
            </div>
            <div class="modal-footer">
                <form action="{{route('user.delete')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="confirmID">
                    <button type="submit" class="btn btn-success font-weight-bold px-4 py-1 m-auto" id="confirmDeleteButton">Yes</button>
                </form>
                <button type="button" class="btn btn-danger font-weight-bold px-4 py-1 m-auto" id="confirmDismiss" data-dismiss="modal">No</button>
            </div>
            </div>
        </div>
    </div>
    

    <script>
        // Activate DataTable
        $('#users_datatable').DataTable();

        // get user data
        $('.userDetailsButton').on('click',function () {
            $('.old_data').text('');
            $.ajax({
                url: `{{route('user.view')}}` + `?id=${$(this).data('id')}`,
                method: 'GET',
                data: {'_token': '{{csrf_token()}}'},
                success: function (res) {
                    var visitStamp = new Date (res.user.last_visit);
                    var createdStamp = new Date (res.user.created_at);
                    var updatedStamp = new Date (res.user.updated_at);
                    var visited = `${visitStamp.getFullYear()}-${visitStamp.getMonth()+1}-${visitStamp.getDate()}` 
                    var created = `${createdStamp.getFullYear()}-${createdStamp.getMonth()+1}-${createdStamp.getDate()}` 
                    var updated = `${updatedStamp.getFullYear()}-${updatedStamp.getMonth()+1}-${updatedStamp.getDate()}` 

                    $('#profile_image').attr('src',res.user.profile_photo_url)
                    $('#new_first_name').text(res.user.first_name);
                    $('#new_last_name').text(res.user.last_name);
                    $('#new_email').text(res.user.email);
                    if (res.user.email_verified_at == null) {
                        $('#verified').text("(Not verified)");
                    }
                    $('#new_phone').text(res.user.phone);
                    $('#new_gender').text(res.user.gender);
                    $('#new_credit').text(res.user.credit + ' EGP');
                    $('#new_visit_number').text(res.user.visit_number);
                    $('#new_last_visit').text(visited);
                    $('#new_created').text(created);
                    $('#new_updated').text(updated);
                    if (res.user.group_id == "1") {
                        $('#new_role').text("User");
                    } else if (res.user.group_id == "2") {
                        $('#new_role').text("Admin");
                    }
                },
            })
        })

        // get deletion user id
        $('.deleteButton').click(function () {
            $('#confirmID').val($(this).data('id'));     
        })

    </script>

@endsection

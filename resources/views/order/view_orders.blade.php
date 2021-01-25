@extends('layouts.master')

@section('title')
    Drug Market | View Orders    
@endsection

@section('view')
    active    
@endsection

@section('view-order')
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
          All Orders
          <small>View & Modify</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <table id="orders_datatable" class="table text-center table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="bg-info">
                    <th class="align-middle">User</th>
                    <th class="align-middle">Phone</th>
                    <th class="align-middle">Credit</th>
                    <th class="align-middle">Total</th>
                    <th class="align-middle">Status</th>
                    <th class="align-middle">More</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($orders as $order)

                    <tr>
                        <td class="align-middle">{{$order->user->first_name . " " . $order->user->last_name}}</td>
                        <td class="align-middle">{{$order->user->phone}}</td>
                        <td class="align-middle">{{$order->user->credit}} EGP</td>
                        <td class="align-middle">{{$order->total_price}} EGP</td>
                        <td class="align-middle">
                            @if ($order->status == '1')
                                <span class="text-success">Submmited</span>
                            @elseif ($order->status == '0')
                                <span class="text-danger">Canceled</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-info font-weight-bold orderDetailsButton" data-id="{{$order->id}}" data-toggle="modal" data-target="#detailsModal">Details</button>
                            <button type="button" class="btn btn-danger font-weight-bold deleteButton" data-id="{{$order->id}}" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
              <h5 class="modal-title font-weight-bold" id="detailsModalLabel">Order Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mb-3">User Information</h4>
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <tr>
                        <th class="bg-warning">First Name</th>
                        <td><span id="new_first_name" class='old_data'> </span></td>
                    
                        <th class="bg-warning">Last Name</th>
                        <td><span id="new_last_name" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-warning">Email</th>
                        <td><span id="new_email" class='old_data'> </span></td>
                    
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
                        <th class="bg-warning">Address</th>
                        <td colspan="3"><span id="new_address" class='old_data'> </span></td>
                    </tr>

                </table>

                <hr>

                <h4 class="text-center my-3">Order Information</h4>
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <tr>
                        <th class="bg-info">Total Items</th>
                        <td><span id="new_total_items" class='old_data'> </span></td>
                    
                        <th class="bg-info">Total Price</th>
                        <td><span id="new_total_price" class='old_data'> </span></td>
                    </tr>

                    <tr>
                        <th class="bg-info">Created at</th>
                        <td><span id="new_created" class='old_data'> </span></td>
                    
                        <th class="bg-info">Last Update</th>
                        <td><span id="new_updated" class='old_data'> </span></td>
                    </tr>

                </table>

                <hr>
                
                <h4 class="text-center my-3">Items Information</h4>
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th class="bg-success">Product</th>                       
                            <th class="bg-success">Unit Price</th>
                            <th class="bg-success">Quantity</th>
                            <th class="bg-success">Total Price</th>
                        </tr>
                    </thead>
                    <tbody id="items_detailes">
                        <tr>
                            <td><span id="new_product" class='old_data'> </span></td>
                            <td><span id="new_unit_price" class='old_data'> </span></td>
                            <td><span id="new_quantity" class='old_data'> </span></td>
                            <td><span id="new_total_price" class='old_data'> </span></td>
                        </tr>
                    </tbody>
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
                <h5 class="modal-title font-weight-bold" id="deleteModalLabel">Confirm Delete Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br>
                <h5 class="text-center">Are You Sure You Want To Delete This Order ??</h5>
                <br>
            </div>
            <div class="modal-footer">
                <form action="{{route('order.view.delete')}}" class="w-100" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="order_id" id="confirmID">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success font-weight-bold px-4 py-1 my-auto mx-2" id="confirmDeleteButton">Yes</button>
                        <button type="button" class="btn btn-danger font-weight-bold px-4 py-1 my-auto mx-2" id="confirmDismiss" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    

    <script>
        // Activate DataTable
        $('#orders_datatable').DataTable();

        // get order data
        $('.orderDetailsButton').on('click',function () {
            $('.old_data').text('');
            $('#items_detailes').empty();
            
            $.ajax({
                url: `{{route('order.view')}}` + `?id=${$(this).data('id')}`,
                method: 'GET',
                data: {'_token': '{{csrf_token()}}'},
                success: function (res) {
                    var createdStamp = new Date (res.order.created_at);
                    var updatedStamp = new Date (res.order.updated_at);

                    var created = `${createdStamp.getFullYear()}-${createdStamp.getMonth()+1}-${createdStamp.getDate()}` 
                    var updated = `${updatedStamp.getFullYear()}-${updatedStamp.getMonth()+1}-${updatedStamp.getDate()}` 
                    
                    // User Info
                    $('#new_first_name').text(res.order.user.first_name);
                    $('#new_last_name').text(res.order.user.last_name);
                    $('#new_email').text(res.order.user.email);
                    $('#new_phone').text(res.order.user.phone);
                    $('#new_gender').text(res.order.user.gender == "1"? 'Male' : 'Female');
                    $('#new_credit').text(res.order.user.credit + ' EGP');
                    $('#new_address').text(res.address.state.name + ' - ' + res.address.city.name + ' - ' + res.address.country.name);
               
                    // Order Info
                    $('#new_total_items').text((res.order.items).length);
                    $('#new_total_price').text(res.order.total_price + ' EGP');
                    $('#new_created').text(created);
                    $('#new_updated').text(updated);
                    
                    // Items Info
                    console.log(res.items);
                    $.each(res.items, function (index,value) {
                        $('#items_detailes').append(`
                        <tr>
                            <td>${value.product}</td>
                            <td>${value.unit_price} EGP</td>
                            <td>${value.quantity}</td>
                            <td>${value.total_price} EGP</td>
                        </tr>
                        `);
                    })
                },
            })
        })

        // get deletion order id
        $('.deleteButton').click(function () {
            $('#confirmID').val($(this).data('id'));     
        })

    </script>

@endsection

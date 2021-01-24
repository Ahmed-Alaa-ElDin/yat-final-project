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
            New Order
            <small>Add</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-info p-4">

            <div class="text-center m-3">
                <button type="button" class="btn btn-success font-weight-bold mx-2" id="checkout" disabled>Save order</button>
                <a class="btn btn-danger font-weight-bold mx-2" href="{{route('dashboard')}}" id="cancelOrder">Cancel order</a>
            </div>

            <div class="text-center my-4 row">
                <div class="offset-lg-3 col-lg-2">
                    <label for="totalItems" class="font-weight-bold">No. of Items</label>
                    <div class="form-control" id="totalItems">0</div>
                </div>
                <div class="offset-lg-2 col-lg-2">
                    <label for="totalOrderPrice" class="font-weight-bold">Total order Price</label>
                    <div class="form-control"><span id="totalOrderPrice">0</span> EGP</div>
                </div>
            </div>

            <form action="" method="post">
                <table id="products_datatable" class="table text-center table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr class="bg-info text-white">
                            <th class="align-middle">Name</th>
                            <th class="align-middle">Unit Price</th>
                            <th class="align-middle">Quantity</th>
                            <th class="align-middle">Total Price</th>
                            <th class="align-middle">Category</th>
                            <th class="align-middle">More</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($products as $product)

                            <tr>
                                <td class="align-middle">{{$product->name}} span</td>
                                <td class="align-middle"><span class="unitPrice">{{$product->price}}</span> EGP</td>
                                <td class="align-middle"><input type="number" name="quantity" class="quantity text-center" value="0" min="0" max="{{$product->quantity}}" @if($product->quantity == '0') disabled @endif></td>
                                <td class="align-middle"><span class="totalPrice">0</span> EGP</td>
                                <td class="align-middle">{{$product->category->name}}</td>
                                <td>
                                    <button type="button" class="btn btn-info font-weight-bold productDetailsButton my-2" data-id="{{$product->id}}" data-toggle="modal" data-target="#detailsModal">Details</button>
                                    <button type="button" class="btn btn-success font-weight-bold addButton my-2" data-id="{{$product->id}}" disabled>Add TO Order</button>
                                    <button type="button" class="btn btn-danger font-weight-bold deleteButton my-2 d-none">Remove From Order</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </section>
    <!-- /.content -->

    {{-- Details Modal --}}
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="detailsModalLabel">Product Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <img src="{{asset('images/default_vector_product.jpg')}}" class="d-block w-25 mx-auto mt-2 mb-3" alt="Product Image" id="product_image">
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <tr>
                        <th class="bg-info">Name</th>
                        <td><span id="new_name" class='old_data'> </span></td>

                        <th class="bg-info">Category</th>
                        <td><span id="new_category" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-info">Description</th>
                        <td colspan="3"><span id="new_description" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-info">Price</th>
                        <td><span id="new_price" class='old_data'> </span></td>
                    </tr>

                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger m-auto" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>


    <script>

        // check items no not 0
        var checkout = function () {
            let checkItems = parseInt($("#totalItems").text());
            if (checkItems > 0) {
                $('#checkout').prop('disabled',false);
            } else {
                $('#checkout').prop('disabled',true);
            }
        }

        // Activate DataTable
        $('#products_datatable').DataTable();

        // get product data
        $('.productDetailsButton').on('click',function () {
            $('.old_data').text('');
            $.ajax({
                url: `{{route('product.view')}}` + `?id=${$(this).data('id')}`,
                method: 'GET',
                data: {'_token': '{{csrf_token()}}'},
                success: function (res) {
                    var createdStamp = new Date (res.product.created_at);
                    var updatedStamp = new Date (res.product.updated_at);
                    var created = `${createdStamp.getFullYear()}-${createdStamp.getMonth()+1}-${createdStamp.getDate()}` 
                    var updated = `${updatedStamp.getFullYear()}-${updatedStamp.getMonth()+1}-${updatedStamp.getDate()}` 

                    $('#product_image').attr('src',res.product.photo_url)
                    $('#new_name').text(res.product.name);
                    $('#new_category').text(res.product.category.name);
                    $('#new_description').text(res.product.description);
                    $('#new_price').text(res.product.price + ' EGP');
                },
            })
        })

        $('.quantity').on('change', function () {
            $(this).parents('tr').find('.totalPrice').text(`${$(this).parents('tr').find('.unitPrice').text()*$(this).val()}`)
            if ($(this).val() != '0') {
                $(this).parents('tr').find('.addButton').prop('disabled', false);
            } else {
                $(this).parents('tr').find('.addButton').prop('disabled', true);
            }
        })

        $('.addButton').on('click', function () {
            let productID =  $(this).data('id');
            let quantity =  $(this).parents('tr').find('.quantity');
            let unitPrice = $(this).parents('tr').find('.unitPrice');
            let totalPrice = $(this).parents('tr').find('.totalPrice');
            let submitButton = $(this);
            quantity.prop('disabled',true);
            $(this).addClass('d-none').siblings('.deleteButton').removeClass('d-none');
            $.ajax({
                url: '{{route("item.create")}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'product_id' : productID,
                    'order_id' : {{$order_id}},
                    'price' : parseInt(unitPrice.text()),
                    'quantity' : quantity.val(),
                    'total' : parseInt(totalPrice.text())
                },
                success: function (res) {
                    submitButton.siblings('.deleteButton').attr('data-id',res.item_id);
                    $('#totalItems').text(parseInt($('#totalItems').text()) + 1);
                    $('#totalOrderPrice').text(parseInt($('#totalOrderPrice').text()) + parseInt(totalPrice.text()));
                    checkout()
                }
            })
        })

        $('.deleteButton').on('click', function () {
            let itemID =  $(this).attr('data-id');
            let totalPrice = $(this).parents('tr').find('.totalPrice');
            let quantity =  $(this).parents('tr').find('.quantity');
            quantity.prop('disabled',false);
            $(this).addClass('d-none').siblings('.addButton').removeClass('d-none');
            $.ajax({
                url: '{{route("item.delete")}}',
                method: 'DELETE',
                data: {
                    '_token': '{{csrf_token()}}',
                    'item_id' : itemID,
                },
                success: function (res) {
                    $('#totalItems').text(parseInt($('#totalItems').text()) - 1);
                    $('#totalOrderPrice').text(parseInt($('#totalOrderPrice').text()) - parseInt(totalPrice.text()));
                    checkout()
                }
            })
        })

        $('#checkout').on('click', function () {
            $.ajax({
                url: '{{route("order.save")}}',
                method: 'PATCH',
                data: {
                    '_token': '{{csrf_token()}}',
                    'order_id' : {{$order_id}},
                    'total' : parseInt($('#totalOrderPrice').text())
                },
                success: function (res) {
                    window.location.replace("{{route('dashboard')}}");
                }
            })
        })

        $('#cancelOrder').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route("order.delete")}}',
                method: 'DELETE',
                data: {
                    '_token': '{{csrf_token()}}',
                    'order_id' : {{$order_id}},
                },
                success: function (res) {
                    window.location.replace("{{route('dashboard')}}");
                }
            })
        })

    </script>

@endsection

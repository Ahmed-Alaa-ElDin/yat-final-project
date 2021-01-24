@extends('layouts.master')

@section('title')
    Drug Market | View Products    
@endsection

@section('view')
    active    
@endsection

@section('view-product')
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
          All Products
          <small>View & Modify</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <table id="products_datatable" class="table text-center table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="bg-success text-white">
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Price</th>
                    <th class="align-middle">Quantity</th>
                    <th class="align-middle">Category</th>
                    <th class="align-middle">More</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($products as $product)

                    <tr>
                        <td class="align-middle">{{$product->name}}</td>
                        <td class="align-middle">{{$product->price}} EGP</td>
                        <td class="align-middle">{{$product->quantity}}</td>
                        <td class="align-middle">{{$product->category->name}}</td>
                        <td>
                            <button type="button" class="btn btn-info font-weight-bold productDetailsButton" data-id="{{$product->id}}" data-toggle="modal" data-target="#detailsModal">Details</button>
                            <a class="btn btn-primary font-weight-bold" href="{{route('product.edit', $product->id)}}">Edit</a>
                            <button type="button" class="btn btn-danger font-weight-bold deleteButton" data-id="{{$product->id}}" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
              <h5 class="modal-title font-weight-bold" id="detailsModalLabel">Product Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <img src="{{asset('images/default_vector_product.jpg')}}" class="d-block w-25 mx-auto mt-2 mb-3" alt="Product Image" id="product_image">
                <table style="width:100%" class="table text-center table-striped table-bordered" >
                    <tr>
                        <th class="bg-success">Name</th>
                        <td><span id="new_name" class='old_data'> </span></td>

                        <th class="bg-success">Category</th>
                        <td><span id="new_category" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-success">Description</th>
                        <td colspan="3"><span id="new_description" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-success">Price</th>
                        <td><span id="new_price" class='old_data'> </span></td>
                    
                        <th class="bg-success">Quantity</th>
                        <td><span id="new_quantity" class='old_data'> </span></td>
                    </tr>
                    <tr>
                        <th class="bg-success">Created</th>
                        <td><span id="new_created" class='old_data'> </span></td>
                    
                        <th class="bg-success">Last Update</th>
                        <td><span id="new_updated" class='old_data'> </span></td>
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
                    <h5 class="modal-title font-weight-bold" id="deleteModalLabel">Confirm Delete Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <br>
                    <h5 class="text-center">Are You Sure You Want To Delete This Product ??</h5>
                    <br>
                </div>
                <div class="modal-footer">
                    <form action="{{route('product.delete')}}" class="w-100" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="confirmID">
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
                    $('#new_quantity').text(res.product.quantity);
                    $('#new_created').text(created);
                    $('#new_updated').text(updated);
                },
            })
        })

        // get deletion user id
        $('.deleteButton').click(function () {
            $('#confirmID').val($(this).data('id'));     
        })

    </script>

@endsection

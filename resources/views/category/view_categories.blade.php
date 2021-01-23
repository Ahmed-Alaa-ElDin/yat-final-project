@extends('layouts.master')

@section('title')
    Drug Market | View Categories    
@endsection

@section('view')
    active    
@endsection

@section('view-category')
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
          All Categories
          <small>View & Modify</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <table id="categories_datatable" class="table text-center table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="bg-dark text-white">
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Description</th>
                    <th class="align-middle">Products Count</th>
                    <th class="align-middle">Created</th>
                    <th class="align-middle">Last Update</th>
                    <th class="align-middle">More</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($categories as $category)

                    <tr>
                        <td class="align-middle font-weight-bold">{{$category->name}}</td>
                        <td class="align-middle">{{$category->description}}</td>
                        <td class="align-middle">{{count($category->products)}}</td>
                        <td class="align-middle">{{$category->created_at}}</td>
                        <td class="align-middle">{{$category->updated_at}}</td>
                        <td>
                            <a class="btn btn-primary font-weight-bold" href="{{route('category.edit', $category->id)}}">Edit</a>
                            <button type="button" class="btn btn-danger font-weight-bold my-2 deleteButton" data-id="{{$category->id}}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <!-- /.content -->

    {{-- Confirm Delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="deleteModalLabel">Confirm Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br>
                <h5 class="text-center">Are You Sure You Want To Delete This Category ??</h5>
                <br>
            </div>
            <div class="modal-footer">
                <form action="{{route('category.delete')}}" class="w-100" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="confirmID">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success d-inline font-weight-bold px-4 py-1 my-auto mx-2" id="confirmDeleteButton">Yes</button>
                        <button type="button" class="btn btn-danger d-inline font-weight-bold px-4 py-1 my-auto mx-2" id="confirmDismiss" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    

    <script>
        // Activate DataTable
        $('#categories_datatable').DataTable();

        // get deletion user id
        $('.deleteButton').click(function () {
            $('#confirmID').val($(this).data('id'));     
        })

    </script>

@endsection

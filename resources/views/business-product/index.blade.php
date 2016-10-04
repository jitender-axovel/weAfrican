@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">

    <div class="container">
   
        <h5>Product Details</h5>
         @include('notification')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <p class="text-right"><a href="{{url('business-product/create')}}"><button type="button" class="btn btn-info">Add Product</button></a></p>
        @if($products->count()) 
        @foreach($products as $product)
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->price}}</td>
                    <td><img src="{{asset(config('image.product_image_url').'thumbnails/small/'.$product->image)}}"/></td>
                    <td><a href="{{url('business-product/'.$product->id.'/edit')}}"><button type="button" class="btn btn-default"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
Edit</button></a>
                   <!--  <a href="{{url('business-product/'.$product->id)}}"><button type="button" class="btn btn-default">Delete</button></a> -->
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
        @else
        <p>No products found</p>
        @endif
    </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
        function deleteProduct(id, title, event,form)
        {   

            event.preventDefault();
            swal({
                title: "Are you sure?",
                text: "You want to delete "+title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel pls!",
                closeOnConfirm: false,
                closeOnCancel: false,
                allowEscapeKey: false,
            },
            function(isConfirm){
                if(isConfirm) {
                    $.ajax({
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        type: 'DELETE',
                        success: function(data) {
                            data = JSON.parse(data);
                            if(data['status']) {
                                swal({
                                    title: data['message'],
                                    text: "Press ok to continue",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Ok",
                                    closeOnConfirm: false,
                                    allowEscapeKey: false,
                                },
                                function(isConfirm){
                                    if(isConfirm) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                swal("Error", data['message'], "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", title+"'s record will not be deleted.", "error");
                }
            });
        }
    </script>
@endsection
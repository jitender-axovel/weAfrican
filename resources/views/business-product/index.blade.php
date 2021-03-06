@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row register-business">
    <h5 class="text-left">Product Details</h5>
    <hr>
    <p class="text-left">You can add multiple products.</p> 
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
    <div class="panel panel-default ">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price(in Rs)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($products->count()) 
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->title}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                        @if(count($product->business_product_images)>0)
                            @foreach($product->business_product_images as $product_image)
                                @if($product_image->featured_image==1)
                                    <img src="{{asset(config('image.product_image_url').'thumbnails/small/'.$product_image->image)}}" class="event_img" />
                                @endif
                            @endforeach
                        @else
                            No image uploaded yet
                        @endif
                        </td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <a href="{{url('business-product/'.$product->id)}}"><button type="button" class="btn btn-success" title="Edit Product"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <a href="{{url('business-product/'.$product->id.'/edit')}}"><button type="button" class="btn btn-default" title="Edit Product"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <form action="{{url('business-product/'.$product->id)}}" method="POST" onsubmit="deleteProduct('{{$product->id}}', '{{$product->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger" title="Delete Product"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    <tr>
                @endforeach

            @else
                <tr>
                    <td>No products found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
     {{ $products->links()}}
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
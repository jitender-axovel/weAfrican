@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="main-container row">

    <div class="container subscription-plans">
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
    <div class="panel panel-default">
        <div class="panel-heading"> Purchased Subscription Plans</div>
        @if($plans->count()) 
        <table class="table">
            <thead>
                <tr>
                    <th>Subscription Plan Name</th>
                    <th>Coverage</th>
                    <th>keywords Limit</th>
                    <th>Price</th>
                    <th>Start Date</th>
                    <th>Expired Date</th>
                </tr>
            </thead>

            <tbody>
             @foreach($plans as $plan)
                <tr>
                    <td>{{$plan->title}}</td>
                    <td>{{$plan->coverage}}</td>
                    <td>{{$plan->keywords_limit}}</td>
                    <td>{{$plan->price}}</td>
                    <td>{{$plan->subscription_date}}</td>
                    <td>{{$plan->expired_date}}</td>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @else
        <table>No products found</table>
        @endif
    </div>
    </div>
    </div>
    <style>
    .container.subscription-plans {
  padding: 70px;
}
    </style>
@endsection
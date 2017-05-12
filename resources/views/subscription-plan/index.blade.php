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
            <table class="table">
                <thead>
                    <tr>
                        <th>Subscription Plan Name</th>
                        <th>Coverage</th>
                        <th>keywords Limit</th>
                        <th>Price</th>
                        <th>Purchased Date</th>
                        <th>Expired Date</th>
                    </tr>
                </thead>
                <tbody>
                @if($plans->count()) 
                    @foreach($plans as $plan)
                        <tr>
                            <td>{{$plan->title}}</td>
                            <td>{{$plan->coverage}}</td>
                            <td>@if($plan->keywords_limit){{ $plan->keywords_limit}} @else NA @endif</td>
                            <td>{{$plan->price}}</td>
                            <td>{{date('d M,Y', strtotime($plan->subscription_date))}}</td>
                            <td>{{date('d M,Y', strtotime($plan->subscription_date .'+'. $plan->validity_period.'days')) }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No subscription plan Purchased</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
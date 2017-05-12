@extends('layouts.app')
@section('content')
    <div class="main-container row">
        <div class="col-md-8 col-md-offset-2">
        	<h1 class="text-bold">Oops!</h1>
        	<h3>looks like you are on a wrong page.</h3>
        	<a href="{{ url('/') }}" class="btn btn-danger btn-lg"><i class="fa fa-home"></i>&nbsp;Go to HomePage</a>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>My Account</h5>
	<hr>
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
	@include('includes.side-menu')
    <div class="col-md-9">
        <h5>Transaction History</h5>
        <div class="panel panel-default table_set">
            <div class="all_content">
            <table class="table" id="tranaction_history">
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    $(document).ready( function () {
        $('#tranaction_history').DataTable();
        $('#business_list').DataTable();
        $('#event_list').DataTable();
    } );
</script>
@endsection
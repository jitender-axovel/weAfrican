@if(Auth::check())
@if(!isset($flag))
<div class="top-business-menu">
	<ul class="nav nav-pills">
	  <li role="presentation" class="active"><a href="{{ url('register-business/'.Auth::id()) }}">Business Profile</a></li>
	  <li role="presentation"><a href="{{ url('business-product') }}">Business Product</a></li>
	  <li role="presentation"><a href="{{ url('business-event') }}">Business Event</a></li>
	  <li role="presentation"><a href="{{ url('subscription-plans') }}">Subscription Plans</a></li>
	  <li role="presentation" class="dropdown">
	    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
	      Dropdown <span class="caret"></span>
	    </a>
	    <ul class="dropdown-menu">
	      <li role="presentation" class="active"><a href="#">Home</a></li>
		  <li role="presentation"><a href="#">Profile</a></li>
		  <li role="presentation"><a href="#">Messages</a></li>
	    </ul>
	  </li>
	</ul>
</div>
@endif
@endif
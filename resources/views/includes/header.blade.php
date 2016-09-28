<header>
	<div class="col-md-10 col-md-offset-1">
		<div class="col-md-2 col-sm-2 col-xs-12 logo">
			<a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}"></a>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-12">			
			<nav class="navbar">
				<div class="container-fluid">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					  </button>					  
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
					  <ul class="nav navbar-nav navbar-right">
						<li class="active"><a href="{{url('/')}}">Home</a></li>	
						<li><a href="{{url('cms/about-us')}}">About</a></li>
						<!-- <li> <a href="{{url('cms/privacy-policy')}}">Privacy Policy</a> </li> -->
						@if(!Auth::check())
							<li>
								<a href="{{ url('register') }}">Register</a>
							</li>
							<li>
								<a href="{{ url('login') }}">Login</a>
							</li>
						@else
							<li>
								<a href="{{ url('register-business/create') }}">Register Business</a>
							</li>
							<li>
								<a href="{{ url('register-business/'.Auth::id()) }}"> Business Profile</a>
							</li>
							<li>
								<a href="{{ url('logout') }}">Logout</a>
							</li>
						@endif
						<li><a href="#" class="download-link">download</a></li>
					  </ul>				  
					</div>
				</div>
			</nav>
		</div>
	</div>
</header>  
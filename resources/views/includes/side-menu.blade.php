@if(Auth::check())
    @if(!isset($flag))
    	<div class="col-md-3 my-account-sidebar">
		    <nav>
			    <ul class="nav">
				    <li><a class="{{ Request::path() == 'my-account' ? 'active' : '' }}"  href="{{ url('my-account') }}">MyAccount</a></li>
					<li><a href="#">Banners</a>
						<ul class="nav" id="submenu1" role="menu" aria-labelledby="btn-1">
							<li><a class="{{ Request::path() == 'business-banner' ? 'active' : '' }}" href="{{ url('business-banner') }}">Business Banners</a></li>
							<li><a class="{{ Request::path() == 'sponsor-banner' ? 'active' : '' }}" href="{{ url('sponsor-banner') }}">Sponsor Banners</a></li>
							<li><a class="{{ Request::path() == 'event-banner' ? 'active' : '' }}" href="{{ url('event-banner') }}">Event Banners</a></li>
						</ul>
					</li>
					<li><a href="{{ url('subscription-plans') }}">Subscription History</a></li>
				</ul>
			</nav>
		</div>
	@endif
@endif
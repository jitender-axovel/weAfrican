@if(Auth::check())
    @if(!isset($flag))
    <div class="top-business-menu">
        <ul class="nav nav-pills">
            <li role="presentation"><a href="{{ url('register-business/'.Auth::id()) }}">Business Profile</a></li>
            @if(isset($category_check) and ($category_check==1 or $category_check==2))
                <li role="presentation"><a href="{{ url('portfolio') }}">Portfolio</a></li>
            @else
                <li role="presentation"><a href="{{ url('business-product') }}">Product</a></li>
            @endif
            <li role="presentation"><a href="{{ url('business-service') }}">Service</a></li>
            <li role="presentation"><a href="{{ url('business-event') }}">Event</a></li>
            <li role="presentation"><a href="{{ url('business-follower') }}">Followers</a></li>
            <li role="presentation"><a href="{{ url('banners') }}">Banners</a></li>
            <li role="presentation"><a href="{{ url('subscription-plans') }}">Subscription History</a></li>
            <!-- <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation" class="active"><a href="#">Home</a></li>
                    <li role="presentation"><a href="#">Profile</a></li>
                    <li role="presentation"><a href="#">Messages</a></li>
                </ul>
            </li> -->
        </ul>
    </div>
    @endif
@endif
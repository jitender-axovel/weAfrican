<div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-expanded="true">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>                     
                    </div>
<div id="sidebar-wrapper">

    <ul class="sidebar-nav">
        <li>
            <a href="{{url('admin/dashboard')}}" class="{{ Request::path() == 'admin/dashboard' ? 'active' : '' }}">Dashboard</a>
        </li>   
        <li>
            <a href="{{url('admin/users')}}" class="{{ Request::path() == 'admin/users' ? 'active' : '' }}">User Management</a>
        </li>  
        <li>
             @if(Request::segment(2).'/'.Request::segment(3)=='bussiness/category')
                <a href="javascript:;" data-toggle="collapse" data-target="#category" class="" aria-expanded="true">Category Management<i class="fa fa-fw fa-caret-down"></i></a>
                   <ul id="category" class="collapse in" aria-expanded="true">
             @else
                <a href="javascript:;" data-toggle="collapse" data-target="#category" class="collapsed" aria-expanded="false">Category Management<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="category" class="collapse" aria-expanded="false">
             @endif
            
                <li>
                    <a href="{{url('admin/bussiness/category/create')}}" class="{{ Request::path() == 'admin/bussiness/category/create' ? 'active' : '' }}">Create New Category</a>
                </li>
                <li>
                    <a href="{{url('admin/bussiness/category')}}" class="{{ Request::path() == 'admin/bussiness/category' ? 'active' : '' }}">List Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/business')}}" class="{{ Request::path() == 'admin/business' ? 'active' : '' }}">User Business Management</a>
        </li>   
        <li>
            @if(Request::segment(2).'/'.Request::segment(3)=='category/event')
                <a href="javascript:;" data-toggle="collapse" data-target="#event-category-management" class="collapsed" aria-expanded="false">Event Category Management<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="event-category-management" class="collapse in" aria-expanded="true">
            @else
                <a href="javascript:;" data-toggle="collapse" data-target="#event-category-management" class="collapsed" aria-expanded="false">Event Category Management<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="event-category-management" class="collapse" aria-expanded="false">
            @endif
                <li>
                    <a href="{{url('admin/category/event/create')}}" class="{{ Request::path() == 'admin/category/event/create' ? 'active' : '' }}">Create New Event Category</a>
                </li>
                <li>
                    <a href="{{url('admin/category/event')}}" class="{{ Request::path() == 'admin/category/event' ? 'active' : '' }}">List Event Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/event')}}" class="{{ Request::path() == 'admin/event' ? 'active' : '' }}">Event Mangement</a>
        </li>
        <li>
            <a href="{{url('admin/subscription/plan')}}" class="{{ Request::path() == 'admin/subscription/plan' ? 'active' : '' }}">Subscription Plans</a>
        </li>
        <li>
            <a href="{{url('admin/banner')}}" class="{{ Request::path() == 'admin/banner' ? 'active' : '' }}">Banner Management</a>
        </li>
        <li>
            <a href="{{url('admin/product')}}" class="{{ Request::path() == 'admin/product' ? 'active' : '' }}">Product Management</a>
        </li>
        <li>
            <a href="{{url('admin/service')}}" class="{{ Request::path() == 'admin/service' ? 'active' : '' }}">Service Management</a>
        </li>
        <li>
            <a href="{{url('admin/reviews')}}" class="{{ Request::path() == 'admin/reviews' ? 'active' : '' }}">Business Reviews</a>
        </li>
        <li>
            @if(Request::segment(2)=='seating-plan')
                <a href="javascript:;" data-toggle="collapse" data-target="#seating-plan" class="collapsed" aria-expanded="false">Seating Plan<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="seating-plan" class="collapse in" aria-expanded="true">
            @else
                <a href="javascript:;" data-toggle="collapse" data-target="#seating-plan" class="collapsed" aria-expanded="false">Seating Plan<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="seating-plan" class="collapse" aria-expanded="false">
            @endif
                <li>
                    <a href="{{url('admin/seating-plan/create')}}" class="{{ Request::path() == 'admin/seating-plan/create' ? 'active' : '' }}">Create Seating Plan</a>
                </li>
                <li>
                    <a href="{{url('admin/seating-plan')}}" class="{{ Request::path() == 'admin/seating-plan' ? 'active' : '' }}">List Seating Plan</a>
                </li>
            </ul>
        </li>
        <li>
            @if(Request::segment(2)=='security-question')
                <a href="javascript:;" data-toggle="collapse" data-target="#securityquestion" class="collapsed" aria-expanded="false">Security Question<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="securityquestion" class="collapse in" aria-expanded="true">
            @else
                <a href="javascript:;" data-toggle="collapse" data-target="#securityquestion" class="collapsed" aria-expanded="false">Security Question<i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="securityquestion" class="collapse" aria-expanded="false">
            @endif
                <li>
                    <a href="{{url('admin/security-question/create')}}" class="{{ Request::path() == 'admin/security-question/create' ? 'active' : '' }}">Create Security Question</a>
                </li>
                <li>
                    <a href="{{url('admin/security-question')}}" class="{{ Request::path() == 'admin/security-question' ? 'active' : '' }}">List Security Question</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/conversation')}}" class="{{ Request::path() == 'admin/conversation' ? 'active' : '' }}">Users Conversation
            </a>
        </li>
        <li>
            <a href="{{url('admin/app-feedback')}}" class="{{ Request::path() == 'admin/app-feedback' ? 'active' : '' }}">App feedbacks</a>
        </li>
        <li>
            <a href="{{url('admin/fcm-notification')}}" class="{{ Request::path() == 'admin/fcm-notification' ? 'active' : '' }}">Fcm Notification</a>
        </li>
        <li>
            <a href="{{ url('admin/cms') }}" class="{{ Request::path() == 'admin/cms' ? 'active' : '' }}">Manage CMS Pages</a>
        </li>
    </ul>
</div>
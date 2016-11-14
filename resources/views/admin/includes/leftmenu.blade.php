<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li>
            <a href="{{url('admin/dashboard')}}">Dashboard</a>
        </li>   
        <li>
            <a href="{{url('admin/users')}}">User Management</a>
        </li>  
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#category" class="collapsed" aria-expanded="false">Category Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="category" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/bussiness/category/create')}}">Create New Category</a>
                </li>
                <li>
                    <a href="{{url('admin/bussiness/category')}}">List Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/business')}}">User Business Management</a>
        </li>   
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#eventCategory" class="collapsed" aria-expanded="false">Event Category Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="eventCategory" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/category/event/create')}}">Create New Event Category</a>
                </li>
                <li>
                    <a href="{{url('admin/category/event')}}">List Event Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/event')}}">Event Mangement</a>
        </li>
        <li>
            <a href="{{url('admin/subscription/plan')}}">Subscription Plans</a>
        </li>
        <li>
            <a href="{{url('admin/banner')}}">Banner Management</a>
        </li>
        <li>
            <a href="{{url('admin/product')}}">Product Management</a>
        </li>
        <li>
            <a href="{{url('admin/service')}}">Service Management</a>
        </li>
        <li>
            <a href="{{url('admin/reviews')}}">Business Reviews</a>
        </li>
         <li>
            <a href="{{url('admin/conversation')}}">Users Conversation
            </a>
        </li>
        <li>
            <a href="{{url('admin/app-feedback')}}">App feedbacks</a>
        </li>
       <!--  <li>
            <a href="{{url('admin/fcm-notification')}}">Fcm Notification</a>
        </li> -->
        <li>
            <a href="{{ url('admin/cms') }}">Manage CMS Pages</a>
        </li>
    </ul>
</div>
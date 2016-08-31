<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li>
            <a href="{{url('admin/dashboard')}}">Dashboard</a>
        </li>   
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#users" class="collapsed" aria-expanded="false">User Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="users" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/users/create')}}">Create New User</a>
                </li>
                <li>
                    <a href="{{url('admin/users')}}">List Users</a>
                </li>
            </ul>
        </li>     
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#category" class="collapsed" aria-expanded="false">Category Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="category" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/category/create')}}">Create New Category</a>
                </li>
                <li>
                    <a href="{{url('admin/category')}}">List Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#subscription" class="collapsed" aria-expanded="false">Subscription Plans<i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="subscription" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/subscription/plan/create')}}">Create New Subscription</a>
                </li>
                <li>
                    <a href="{{url('admin/subscription/plan')}}">List Subscription Plans</a>
                </li>
            </ul>
        </li>
        <li>
            <a href=""> Advertisement Plans</a>
        </li>
    </ul>
</div>
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
            <a href="{{url('admin/subscription/plan')}}">Subscription Plans</a>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#advertisement" class="collapsed" aria-expanded="false">Advertisement Plans<i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="advertisement" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/advertisement/plan/create')}}">Create New Advertisment</a>
                </li>
                <li>
                    <a href="{{url('admin/advertisement/plan')}}">List Advertisement Plans</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#banner" class="collapsed" aria-expanded="false">Banner<i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="banner" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/banner/create')}}">Create New Banner</a>
                </li>
                <li>
                    <a href="{{url('admin/banner')}}">List Banners</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
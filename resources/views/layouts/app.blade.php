<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    <div class="top-container container-fluid">
		@include('includes.header')

    	<div class="main-content">
    		@yield('content')
    	</div>

	    @include('includes.footer')
    </div>
</body>
</html>
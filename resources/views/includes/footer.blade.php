<footer>
	<div class="row">
		<div class="container">
			<div class="col-md-6 text-left col-sm-6 col-xs-12">
				<ul class="footer-linkss list-inline">
					<li> <a href="{{url('/')}}">home</a> </li>
					<li> <a href="{{url('cms/about-us')}}">about</a> </li>
					<li> <a href="{{url('cms/cookie-policy')}}">Cookie Policy</a> </li>
					<li> <a href="{{url('cms/privacy-policy')}}">Privacy Policy</a> </li>
					<li> <a href="{{url('cms/terms-of-use')}}">Terms of Use</a> </li>
			 	</ul>
			</div>
			<div class="col-md-6 text-right col-sm-6 col-xs-12">
				<p>2015 - 2016 © Copyright your company</p>
				<p>All Rights Reserved</p>
				<div class="available">
					<p>available on</p>
					<ul class="list-inline">
						<li> <a href="#"><img src="{{asset('images/apple-store.png')}}"></a> </li>
					    <li> <a href="#"><img src="{{asset('images/play-store.png')}}"></a> </li>
					</ul>
				</div>
			</div>
		</div>
	</div>	
</footer>
@yield('scripts')
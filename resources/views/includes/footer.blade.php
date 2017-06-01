<footer>
	<div class="row">
		<div class="container">
			<div class="col-md-6 text-left col-sm-6 col-xs-12">
				<ul class="footer-linkss list-inline">
					@foreach($cmsPages as $cms)
					<li> <a href="{{url('cms/'.$cms->slug)}}">{{$cms->title}}</a> </li>
					@endforeach
			 	</ul>
			</div>
			<div class="col-md-6 text-right col-sm-6 col-xs-12">
				<p>2016 - {{ date('Y')}} © Copyright your company</p>
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
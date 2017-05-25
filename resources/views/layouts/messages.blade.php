@if(Session::has('success_msg'))
	<div class="alert alert-success fade in">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{!! Session::get('success_msg') !!}
	</div>
@endif

@if(Session::has('error_msg'))
	<div class="alert alert-danger">
		<ul>
			<li>{!! Session::get('error_msg') !!}</li>
		</ul>
	</div>
@endif

@if(count($errors) > 0)
	<div class="alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
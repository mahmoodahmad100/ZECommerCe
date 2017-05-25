@extends('layouts.master')

@section('title','Product')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" />
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
@endsection

@section('content')

<div class="container" id="product-item">
	<div class="row">

    	<div class="col-md-12">
    		<h2>{{$product->name}}</h2>
            <?php $u = "images/users/$product->user_id/products/$product->id/"; ?>
            @foreach(glob($u."*f-img.*") as $featured_img)
              <img class="img-responsive" src="{{URL::to($featured_img)}}" alt="loading..." />
            @endforeach
    	</div>

    	<!--<div class="col-md-10 col-md-offset-1">
			<div class="product-images">			
			    <img class="img-responsive" src="#" alt="loading..." />								
			    <img class="img-responsive" src="https://laracasts.com/images/series/squares/the-php-practitioner.jpg" alt="loading..." />								
			    <img class="img-responsive" src="http://cdn.timtrott.co.uk/2013/10/php_logo-650x300.jpg" alt="loading..." />								
			    <img class="img-responsive" src="https://microlancer.lancerassets.com/v2/services/bf/b91660435811e6b000d3a63c2bcf64/large__original_php2.jpg" alt="loading..." />								
			</div>    		
    	</div>-->
		
		<div class="col-md-2">
			<h2>The Author</h2>
			<a href="{{route('publicProfile',$product->user_id)}}"><h3>{{$product->user->name}}</h3></a>
            <?php $u = "images/users/$product->user_id/"; ?>
            @foreach(glob($u."*avatar.*") as $avatar)
              <a href="{{route('publicProfile',$product->user_id)}}"><img class="img-responsive img-circle" src="{{URL::to($avatar)}}" alt="loading..." /></a>
            @endforeach
		</div>	

		<div class="col-md-2">
			<h2>The Price</h2>
			<h3>{{$product->price}}$</h3>
		</div>			

		<div class="col-md-8">
			<h2>About The Product</h2>
			<p>{{$product->description}}</p>
		</div>

		<div class="col-md-12">
	      @if(Auth::user())
	        @if($product->user_id == Auth::user()->id)
	        	<a href="{{route('editProductSingle',$product->id)}}" class="btn btn-success">Edit</a>
            @elseif($product->purchases->where('user_id',Auth::user()->id)->first())
              	<a href="{{route('purchasedItem',$product->id)}}" class="btn btn-success">view this item</a><br>
	        @else
	        	<a href="{{ route('buyProduct',$product->id) }}" class="btn btn-success">Buy</a>
	        @endif
	      @else
	      	<a href="{{ route('Login-Register') }}" class="btn btn-success">log in/up</a>
	      @endif
		</div>

	</div>
</div>

@endsection
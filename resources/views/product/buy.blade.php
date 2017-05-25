@extends('layouts.master')

@section('title',"Buy $product->name")


@section('content')

<div class="container" id="buy-product">
	<div class="row">

    	<div class="col-md-4">
            <?php $u = "images/users/$product->user_id/products/$product->id/"; ?>
            @foreach(glob($u."*f-img.*") as $featured_img)
              <img class="pull-left img-responsive" src="{{URL::to($featured_img)}}" alt="loading..." />
            @endforeach
    		
		</div>

		<div class="col-md-6 col-md-offset-1">
            @include('layouts.messages')
    		<h2>{{$product->name}}</h2>
    		<h4>The Price: {{$product->price}}$</h4>
            <form action="{{route('PayProduct',$product->id)}}" method="post">
                <input class="form-control" name="coupon" placeholder="Coupon Code (leave it empty if you don't have Coupon Code)">
                <button type="submit" class="btn btn-default">Confirm And Buy</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>    		
    	</div>

	</div>
</div>

@endsection
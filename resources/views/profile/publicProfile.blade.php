@extends('layouts.master')

@section('title',"$user->name")


@section('content')

<div class="container" id="profile-public">
	<div class="row">
    	<div class="col-md-4">
    		<h3>{{$user->name}}</h3>
            <?php $u = "images/users/$user->id/"; ?>
            @foreach(glob($u."*avatar.*") as $avatar)
              <img class="img-responsive img-circle" src="{{URL::to($avatar)}}" alt="loading..." />
            @endforeach
    	</div>
    	<div class="col-md-8">
    		<h2>About Me</h2>
    		<p>{{$user->description}}</p>
            
    		<h2>products ({{$user->products->count()}}) :</h2>
            @foreach($user->products as $product)
            	<a href="{{route('product',$product->id)}}">{{$product->name}}</a><br>
            @endforeach
    	</div>
	</div>
</div>

@endsection
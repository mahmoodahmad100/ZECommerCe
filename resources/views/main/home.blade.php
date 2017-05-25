@extends('layouts.master')

@section('title','Home')


@section('content')

<div class="container" id="product">
	<div class="row">

      @if($products->count()<1)
        <div class="alert alert-danger"><b>No products yet! {{Auth::user() ? 'Be' : 'sign in/up and be'}} the first one to add new product</b></div>        
      @endif

      @include('layouts.messages')
      @foreach($products as $product)
        <div class="col-md-4">
          <div class="element">
            <?php $u = "images/users/$product->user_id/products/$product->id/"; ?>
            @foreach(glob($u."*f-img.*") as $image)
              <a href="#"><img src="{{URL::to($image)}}" alt="loading..." /></a>
            @endforeach
          </div>
          <div class="overlay">
            <a class="view" href="{{route('product',$product->id)}}">view</a>
            <div class="product-details text-center">
              @if(Auth::user())
                @if($product->user_id == Auth::user()->id)
                  <a href="{{route('editProductSingle',$product->id)}}" class="btn btn-success">Edit</a><br>
                @elseif($product->purchases->where('user_id',Auth::user()->id)->first())
                  <a href="{{route('purchasedItem',$product->id)}}" class="btn btn-success">view this item</a><br>
                @else
                 <a href="{{ route('buyProduct',$product->id) }}" class="btn btn-success">Buy</a><br>
                @endif
              @else
                <a href="{{ route('Login-Register') }}" class="btn btn-success">log in/up</a><br>
              @endif
              <span><b>{{$product->name}} | {{$product->price}}$</b></span>
            </div>          
          </div>
        </div>
      @endforeach
	</div>
</div>
@endsection
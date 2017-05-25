@extends('layouts.master')

@section('title','My products')


@section('content')

<div class="container" id="edit-product">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
    		<h2>products ({{$products->count()}}) :</h2>
    		<ul>
	            @foreach($products as $product)
	            	<li><a href="{{route('editProductSingle',$product->id)}}">{{$product->name}}</a></li>
	            @endforeach 	
            </ul>		
		</div>   
	</div>
</div>

@endsection
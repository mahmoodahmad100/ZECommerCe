@extends('layouts.master')

@section('title','Confirm Buying')


@section('content')

<div class="container" id="after-buying">
	<div class="row">
    	<div class="col-md-12">
    		<h2>You bought this product successfully you can download the file from here : 
            <?php $u = "images/users/$product->user_id/products/$product->id/"; ?>
            @foreach(glob($u."*p-file.*") as $file)
              <a href="{{URL::to($file)}}" target="_blank">{{$product->name}}</a>
            @endforeach    		
    		</h2>
    		<form action="{{route('approve',[Auth::user()->id,$product->id])}}" method="post">
	    		<button type="submit" class="btn btn-default approve"><i class="fa fa-check-circle"></i> Release the {{$product->price}}$ for {{$product->user->name}}</button>
	    		<input type="hidden" name="_token" value="{{ Session::token() }}">
    		</form>
    		<h5>* note that : the money will be released automaticly if you don't release it before 5 days from now unless you submit us a message excplaining why you are not releasing the money</h5>
    	</div>
	</div>
</div>

@endsection
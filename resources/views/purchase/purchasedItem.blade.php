@extends('layouts.master')

@section('title','purchased Item')


@section('content')

<div class="container" id="purchased-item">
	<div class="row">
    	<div class="col-md-12">
    		<h2>You can see the original post from here : <a href="{{route('product',$purchasedItem->product->id)}}">{{$purchasedItem->product->name}}</a></h2>
    		<h2>You can download the file from here : 
            <?php 
            $p = $purchasedItem->product;
            $u = "images/users/$p->user_id/products/$p->id/"; 
            ?>
            @foreach(glob($u."*p-file.*") as $file)
              <a href="{{URL::to($file)}}" target="_blank">{{$purchasedItem->product->name}}</a>
            @endforeach   
    		</h2>

    		@if($purchasedItem->money_approved == 0)
	    		<form action="{{route('approve',[Auth::user()->id,$purchasedItem->product->id])}}" method="post">
		    		<button type="submit" class="btn btn-default approve"><i class="fa fa-check-circle"></i> Release the {{$purchasedItem->product->price}}$ for {{$purchasedItem->product->user->name}}</button>
		    		<input type="hidden" name="_token" value="{{ Session::token() }}">
	    		</form>
	    		<h5>* note that : the money will be released automaticly if you don't release it before 5 days from now unless you submit us a message excplaining why you are not releasing the money</h5>
			@endif
    	</div>
	</div>
</div>

@endsection
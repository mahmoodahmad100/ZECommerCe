@extends('layouts.master')

@section('title','purchases')


@section('content')

<div class="container" id="purchases">
	<div class="row">
    	<div class="col-md-10 col-md-offset-1">
			<div class="table-responsive">
			  <table class="table">
			    <thead class="text-center">
			    <th>product name</th>
			    <th>Approved Money ?</th>
			    </thead>
			    @foreach($purchases as $purchase)
			    	<tr>
					    <td><a href="{{route('purchasedItem',$purchase->product->id)}}">{{$purchase->product->name}}</a></td>
					    @if($purchase->money_approved == 1)
					    	<td><i class="fa fa-check-circle"></i></td>
					    @else
					    	<td>
					    		<form action="{{route('approve',[Auth::user()->id,$purchase->product->id])}}" method="post">
						    		<button type="submit" class="btn btn-default approve"><i class="fa fa-check-circle"></i> Approve the {{$purchase->product->price}}$ for {{$purchase->product->user->name}}</button>
						    		<input type="hidden" name="_token" value="{{ Session::token() }}">
					    		</form>
							</td>
					    @endif	
				    </tr>			
			    @endforeach
			  </table>
			</div>    		
    	</div>
	</div>
</div>

@endsection
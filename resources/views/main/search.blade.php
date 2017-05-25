@extends('layouts.master')

@section('title','Search')


@section('content')

<div class="container" id="search">
	<div class="row">
        <h2><b>you are searching for: <span><?php $result = $_GET['search'];  echo $result; ?></span></b></h2>

        @if($products->count() == 0)
            <h3>Not found</h3>
        @endif

        @foreach($products as $product)
            <p><a href="{{route('product',$product->id)}}">{{$product->name}}</a></p>
        @endforeach

	</div>
</div>

@endsection

@section('js')
    <script>
        var search_result = '{{$result}}';
        $("p a:contains("+search_result+")").html(function(_, html) {
           return html.split(search_result).join("<span>"+search_result+"</span>");
        });
    </script>
@endsection
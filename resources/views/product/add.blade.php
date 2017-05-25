@extends('layouts.master')

@section('title','add a product')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endsection

@section('content')

<div class="container" id="add-product">
	<div class="row">
        @include('layouts.messages')
    	<div class="col-md-8 col-md-offset-2">
            <form action="{{route('postProduct')}}" enctype="multipart/form-data" method="post">
                <input name="name" class="form-control" placeholder="Product Name" value="{{ Request::old('name') }}">
                <input name="price" class="form-control" placeholder="The Price(type only number)" value="{{ Request::old('price') }}">

                <!--<select class="form-control" name="category">
                    <option value="0">select category</option>
                	<option value="1">Bootstrap</option>
                	<option value="2">Laravel</option>
                	<option value="3">Ruby On Rails</option>
                </select>-->

                <label for="featured-img">Featured Image</label>
                <input name="featured-img" id="featured-img" class="form-control" type="file" value="{{ Request::old('featured-img') }}">

                <label for="product-file">Product File</label>
                <input name="product-file" id="product-file" class="form-control" type="file" value="{{ Request::old('product-file') }}">

                <!--<label for="product-images">Product Images</label>
                <input name='image[]' id="product-images" class="form-control" type="file">
                <button type="button" class="btn btn-info add-images">Add more images</button>-->

                <textarea name="description" class="form-control" placeholder="About The Product">{{ Request::old('description') }}</textarea>
                <h3>coupon (optional)<h3>
                <input name="coupon" class="form-control" placeholder="Coupon Code" value="{{ Request::old('coupon') }}">
                <input name="expiry" id="datepicker" class="form-control" placeholder="Expires At" value="{{ Request::old('expiry') }}">
                <input name="amount" class="form-control" placeholder="Reducing Amount (percentage like 30% ... type only the number)" value="{{ Request::old('amount') }}">
                <input name="how_many" class="form-control" placeholder="How Many Times Should Be Used" value="{{ Request::old('how_many') }}">
                <!--<h4>Total Cost: 50$</h4>-->
                <button type="submit" class="btn btn-default">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>    		
    	</div>
	</div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection
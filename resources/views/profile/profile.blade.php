@extends('layouts.master')

@section('title','profile')


@section('content')

<div class="container" id="profile">
	<div class="row">

        <div class="col-md-12 account-balance">
            <!--<h2>Your Account Balance is 100$ (add your payment card to receive the money)</h2>-->
            @include('layouts.messages')
        </div>

        <div class="col-md-8">
            <h2>General Information</h2>
            <form action="{{route('updateProfile')}}" enctype="multipart/form-data" method="post">
                <input class="form-control" placeholder="Name" name="name" value="{{$user->name}}">
                <input class="form-control" placeholder="Email" name="email" value="{{$user->email}}">

                <label for="profile-image">Profile Image</label>
                <input name="featured-img" id="profile-image" class="form-control" type="file">
                <?php $u = "images/users/$user->id/"; ?>
                @foreach(glob($u."*avatar.*") as $avatar)
                  <div><label>current image</label><img class="img-responsive img-circle" src="{{URL::to($avatar)}}" alt="loading..."></div>
                @endforeach

                <textarea class="form-control" placeholder="Description" name="description">{{$user->description}}</textarea>
                
                <h3>change your password (optional)</h3>
                <input name="old_password" type="password" class="form-control" placeholder="Your Password">
                <input name="password" type="password" class="form-control" placeholder="Your New Password">
                <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Your New Password">
                <button type="submit" class="btn btn-default">Save</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>  

        <div class="col-md-4">
            <h2>Payment Method</h2>
            @if($user->payment)
            <h3>you already added a payment card</h3>
            @else
            <form action="{{route('postPaymentCard')}}" method="post">
                <!--<input class="form-control" placeholder="Card Number">
                <input class="form-control" placeholder="MM/YY">
                <input class="form-control" placeholder="CVC">
                <input class="form-control" placeholder="Zip Code">
                <button type="submit" class="btn btn-default">Save</button>>-->
                <input type="hidden" name="_token" value="{{ Session::token() }}">
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_KEY') }}"
                    data-label="Add Payment Card"
                    data-image="{{ URL::to('images/ZECommerCe.png') }}"
                    data-name="new payment card"
                    data-description="purchase and receive money"
                    data-panel-label="Add"
                    data-email={{$user->email}}
                    data-allow-remember-me=false
                    >
                </script>
            </form>
            @endif
        </div>

        <!--<div class="col-md-4">
            <h2>Receiving method</h2>
            <form action="#">
                <input class="form-control" placeholder="Card Number">
                <input class="form-control" placeholder="MM/YY">
                <input class="form-control" placeholder="CVC">
                <input class="form-control" placeholder="Zip Code">
                <input type="checkbox"> I'd like to use my visa card as a payment method<br>  
                <button type="submit" class="btn btn-default">Save</button>
                <input type="hidden" name="_token" value="">
            </form>
        </div>

        <div class="col-md-8">
            <h2>Payment Settings</h2>
            <h3><u>buy using</u></h3>
            <form action="#">
                <input name="payment" type="radio"> Account Balance
                <input name="payment" type="radio"> Master Card <br>
                <button type="submit" class="btn btn-default">Save</button>
                <input type="hidden" name="_token" value="">
            </form>
        </div>-->
        

	</div>
</div>

@endsection
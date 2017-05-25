<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Storage;
use Hash;
use App\User;
use App\Payment;
use App\Product;
use App\Purchase;

class UserController extends Controller
{
	public function postLogin(Request $request)
	{
		$this->validate($request,[
				'email' => 'required|email',
				'password'=> 'required'
			]);

		if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']]))
			return redirect()->route('home');
		else{
			Session::flash('error_msg','the email or the password is wrong');	
			return redirect()->back();
		}
	}

	public function postRegister(Request $request)
	{
		$this->validate($request,[
				'name' => 'required|min:3|max:50',
				'email' => 'required|email|unique:users',
				'password'=> 'required|min:5|max:20'
			]);

		$user = new User();
		$user->name     = $request['name'];
		$user->email    = $request['email'];
		$user->password = bcrypt($request['password']);
		$user->description = "That's Me!";
		$user->has_social_account = 0;
		$user->save();
		Auth::login($user);

		$avatar = 'images/users/'.$user->id.'/avatar.png';
        Storage::copy('images/users/avatar.png',$avatar);

		Session::flash('success_msg','<strong>Well done!</strong> you registered successfully!');
		return redirect()->route('home');
	}

	public function getLogout()
	{
		Auth::logout();
		Session::flash('success_msg','We hope we can see you soon again!');
		return redirect()->route('home');
	}

	public function postUpdateProfile(Request $request)
	{
	  $user = User::where('id',Auth::user()->id)->first();

	  if($request['email'] == $user->email)
	  {
	    $this->validate($request,[
	      'name' => 'required|min:3|max:50',
	      'description'  => 'required',
	      'featured-img' => 'image'
	    ]);
	  }
	  else
	  {
	    $this->validate($request,[
	      'name' => 'required|min:3|max:50',
	      'email' => 'required|email|unique:users',
	      'description'  => 'required',
	      'featured-img' => 'image'
	    ]);
	  }
	  if($request['old_password'] != '' || $request['password'] != '' || $request['password_confirmation'] != '')
	  {
        $this->validate($request,[
            'old_password' => 'required|min:5|max:20',
            'password' => 'required|min:5|max:20|confirmed',
            'password_confirmation' => 'required'
        ]);
	      if(Hash::check($request['old_password'],$user->password)){
	        $user->password = bcrypt($request['password']);
	      }
	      else
	      {
			Session::flash('error_msg','the password is wrong');	
			return redirect()->back();	      	
	      }
	  }
	  $user->name = $request['name'];
	  $user->email = $request['email'];
	  $user->description = $request['description'];
	  $user->update();

	  if($request->hasFile('featured-img')){
		$u = "images/users/$user->id/";
		foreach(glob($u."*avatar.*") as $oldAvatar)
			Storage::delete($oldAvatar);

		$avatar = 'avatar.'.$request->file('featured-img')->getClientOriginalExtension();
		$request->file('featured-img')->move(public_path().'/images/users/'.$user->id.'/',$avatar);
	}
		Session::flash('success_msg','the profile updated successfully!');
		return redirect()->route('profile');
	}

	public function postPaymentCard()
	{
		# create new user with payment card in stripe
		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

		/*$recipient = \Stripe\Recipient::create(array(
			"name" => "Auth::user()->name",
			"type" => "individual",
			"card" => $_POST['stripeToken'],
			"email" => Auth::user()->email
		  ));*/

		$customer = \Stripe\Customer::create(array(
		  'email' => Auth::user()->email,
		  'source'  => $_POST['stripeToken']
		));

		# create new payment card for the user
		$payment = new Payment();
		$payment->user_id = Auth::user()->id;
		$payment->stripe_customer_id = $customer->id;
		#$payment->stripe_recipient_id = $recipient->id;
		$payment->save();

		Session::flash('success_msg','you added a new payment card successfully!');
		return redirect()->route('profile');
	}

	public function postPayProduct(Request $request,$id)
	{
		$payment  = Payment::where('user_id',Auth::user()->id)->first();
		$product  = Product::where('id',$id)->first();

		if(!$payment)
		{
			Session::flash('error_msg','Add Payment Card from your settings to be able to purchase that product');	
			return redirect()->back();				
		}

		$purchase = new Purchase();
		$price = $product->price * 100;
		if($request['coupon'] != "")
		{
			if($request['coupon'] == $product->coupon_code)
			{
				if($product->coupon_how_many_times != "")
				{
					if($product->coupon_how_many_used < $product->coupon_how_many_times)
					{
						$product->coupon_how_many_used += 1;
					}
					else
					{
						Session::flash('error_msg','this coupon is no longer available');	
						return redirect()->back();						
					}
				}

				if($product->coupon_expires_at != "")
				{
					$date = date("Y-m-d");
					if(strtotime($date) > strtotime($product->coupon_expires_at))
					{
						Session::flash('error_msg','this coupon has expired');	
						return redirect()->back();					
					}
				}
				$product->update();	
				$price = ($price * $product->coupon_amount)/100;		
			}
			else
			{
				Session::flash('error_msg','the coupon is wrong');	
				return redirect()->back();			
			}
		}

		\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
		$charge = \Stripe\Charge::create(array(
		  "amount" =>  $price,
		  "currency" => "usd",
		  "customer" => $payment->stripe_customer_id
		));	

		$purchase->user_id = Auth::user()->id;
		$purchase->product_id = $product->id;
		$purchase->save();

		return view("purchase.afterBuying",compact('product'));	
	}

	public function postApproveMoney($user_id,$product_id)
	{
		/*$recipient = Purchase::where('product_id',$product_id)->product->first();
		$payout = \Stripe\Payout::create(array(
		  "amount" => $recipient->price * 100,
		  "currency" => "usd",
		  "recipient" => $recipient->user->payment->stripe_recipient_id,
		  "statement_descriptor" => "money is approved"
		  ));*/

		$approve = Purchase::where(['user_id' => $user_id, 'product_id' => $product_id])->first();
		$approve->money_approved = 1;
		$approve->update();

		Session::flash('success_msg','you approved the money!');
		return redirect()->route('home');
	}

	public function postProduct(Request $request)
	{
		if($request['amount'] == '' && $request['how_many'] == '' && $request['expiry'] == '')
		{
			$this->validate($request,[
					'name'         => 'required|min:3|max:50',
					'price'        => 'required|numeric|max:50000',
				#	'category'     => 'required|numeric|min:1|max:3',
					'featured-img' => 'required|image',
					'product-file' => 'required|mimes:zip,rar',
					'description'  => 'required|min:10',
					'coupon'       => 'nullable|min:3|max:20',
					'amount'       => 'nullable|numeric|min:1|max:60',
					'how_many'     => 'nullable|numeric|min:1',
					'expiry'       => 'nullable|date'
				]);			
		}
		else
		{
			$this->validate($request,[
					'name'         => 'required|min:3|max:50',
					'price'        => 'required|numeric|max:50000',
				#	'category'     => 'required|numeric|min:1|max:3',
					'featured-img' => 'required|image',
					'product-file' => 'required|mimes:zip,rar',
					'description'  => 'required|min:10',
					'coupon'       => 'required|min:3|max:20',
					'amount'       => 'required|numeric|min:1|max:60',
					'how_many'     => 'nullable|numeric|min:1',
					'expiry'       => 'nullable|date'
				]);			
		}


		/*if($request['category'] == 0)
		{
			Session::flash('error_msg','please select category');
			return redirect()->back();
		}*/
		
		$product = new Product();
        $product->name = $request['name'];
        $product->price = $request['price'];
        $product->user_id = Auth::user()->id;
        #$product->category_id = $request['category'];
        $product->description = $request['description'];
        $product->coupon_code = $request['coupon'];
        $product->coupon_amount = $request['amount'];
        $product->coupon_how_many_times = $request['how_many'];
        $product->coupon_expires_at = $request['expiry'];		
        $product->save();

        $featured_img = 'f-img.'.$request->file('featured-img')->getClientOriginalExtension();
        $request->file('featured-img')->move(public_path().'/images/users/'.$product->user_id.'/products/'.$product->id.'/',$featured_img);

        $product_file = 'p-file.'.$request->file('product-file')->getClientOriginalExtension();
        $request->file('product-file')->move(public_path().'/images/users/'.$product->user_id.'/products/'.$product->id.'/',$product_file);

		Session::flash('success_msg','You added new product successfully');
		return redirect()->route('home');
	}

	public function postUpdateProduct(Request $request , $id)
	{
		if($request['amount'] == '' && $request['how_many'] == '' && $request['expiry'] == '')
		{
			$this->validate($request,[
					'name'         => 'required|min:3|max:50',
					'price'        => 'required|numeric|max:50000',
				#	'category'     => 'required|numeric|min:1|max:3',
				#	'featured-img' => 'required|image',
				#	'product-file' => 'required|mimes:zip,rar',
					'description'  => 'required|min:10',
					'coupon'       => 'nullable|min:3|max:20',
					'amount'       => 'nullable|numeric|min:1|max:60',
					'how_many'     => 'nullable|numeric|min:1',
					'expiry'       => 'nullable|date'
				]);			
		}
		else
		{
			$this->validate($request,[
					'name'         => 'required|min:3|max:50',
					'price'        => 'required|numeric|max:50000',
				#	'category'     => 'required|numeric|min:1|max:3',
				#	'featured-img' => 'required|image',
				#	'product-file' => 'required|mimes:zip,rar',
					'description'  => 'required|min:10',
					'coupon'       => 'required|min:3|max:20',
					'amount'       => 'required|numeric|min:1|max:60',
					'how_many'     => 'nullable|numeric|min:1',
					'expiry'       => 'nullable|date'
				]);			
		}


		/*if($request['category'] == 0)
		{
			Session::flash('error_msg','please select category');
			return redirect()->back();
		}*/
		
		$product = Product::where('id',$id)->first();
        $product->name = $request['name'];
        $product->price = $request['price'];
        #$product->category_id = $request['category'];
        $product->description = $request['description'];
        $product->coupon_code = $request['coupon'];
        $product->coupon_amount = $request['amount'];
        $product->coupon_how_many_times = $request['how_many'];
        $product->coupon_expires_at = $request['expiry'];		
        $product->update();

		# remove the old image and then move the new image #
		// removing code here //
        /*$featured_img = 'f-img.'.$request->file('featured-img')->getClientOriginalExtension();
        $request->file('featured-img')->move(public_path().'/images/users/'.$product->user_id.'/products/'.$product->id.'/',$featured_img);*/

		# remove the old file and then move the new file #
		// removing code here //
        /*$product_file = 'p-file.'.$request->file('product-file')->getClientOriginalExtension();
        $request->file('product-file')->move(public_path().'/images/users/'.$product->user_id.'/products/'.$product->id.'/',$product_file);*/

		Session::flash('success_msg','You updated the product successfully');
		return redirect()->back();
	}
}


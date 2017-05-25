<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Product;
use App\Payment;
use App\Purchase;

class PageController extends Controller
{
	#=============== Main Pages ===============#
    public function getHome()
    {
        $products = Product::orderBy('created_at','desc')->get();
    	return view("main.home",compact('products'));
    }  

    public function getLoginAndRegister()
    {
    	return view("main.login-register");
    } 

    public function getSearchResult(Request $request)
    {
        $this->validate($request,['search' => 'required']);
        $products = Product::where('name','like',"%".$request['search']."%")->get();      
    	return view("main.search",compact('products'));
    } 

    #=============== Product Pages ===============#
    public function getProduct($id)
    {   
        $product = Product::where('id',$id)->first();
    	return view("product.product",compact('product'));
    }

    public function getBuyProduct($id)
    {
        if(Auth::user())
        {
            $purchase = Purchase::where(['user_id' => Auth::user()->id, 'product_id' => $id])->first();
            if($purchase)
            {
                Session::flash('error_msg','you already purchased that product');   
                return redirect()->route('home');          
            }

            $product = Product::where('id',$id)->first();
            if($product->user_id == Auth::user()->id)
            {
                Session::flash('error_msg','you can not buy your own product');   
                return redirect()->route('home');            
            }
            
            return view("product.buy",compact('product'));
        }
        else
        {
            Session::flash('error_msg','please sign in or sign up to buy any product');   
            return redirect()->route('Login-Register');             
        }
    }

    public function getAddProduct()
    {
        $payment  = Payment::where('user_id',Auth::user()->id)->first();
        if(!$payment)
        {
            Session::flash('error_msg','Add Payment Card first to be able to add products and receive the payout'); 
            return redirect()->route('profile');                
        }

    	return view("product.add");
    }  

    public function getEditProducts()
    {
        $products = Product::where('user_id',Auth::user()->id)->get();
    	return view("product.edit",compact('products'));
    } 

    public function getEditProductSingle($id)
    {   
        $product = Product::where('id',$id)->first();
        if(Auth::user()->id != $product->user_id)
        {
            Session::flash('error_msg','you are not allowed to go to the previous page');   
            return redirect()->route('home');            
        }
        return view("product.edit-single",compact('product'));
    } 

    #=============== Profile Pages ===============#
    public function getProfile()
    {
        $user = User::where('id',Auth::user()->id)->first();
    	return view("profile.profile",compact('user'));
    }  

    public function getPublicProfile($id)
    {
        $user = User::where('id',$id)->first();
    	return view("profile.publicProfile",compact('user'));
    }

    #=============== Purchase Pages ===============#
    /*public function getAfterBuying()
    {
    	return view("purchase.afterBuying");
    }*/

    public function getPurchases()
    {
        $purchases = Purchase::where('user_id',Auth::user()->id)->get();
    	return view("purchase.purchases",compact('purchases'));
    }  

    public function getPurchasedItem($product_id)
    {
        $purchasedItem = Purchase::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->first();
        if(!$purchasedItem)
        {
            Session::flash('error_msg','you had not purchased that product');   
            return redirect()->route('home');
        }
    	return view("purchase.purchasedItem",compact('purchasedItem'));
    }

}

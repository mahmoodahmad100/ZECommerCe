<?php

#=============== PageController Routes ===============#

// Main Pages
Route::get('/',[
  'uses' => 'PageController@getHome',
  'as' => 'home'
]);

Route::get('LoginAndRegister',[
  'uses' => 'PageController@getLoginAndRegister',
  'as' => 'Login-Register',
]);

Route::get('search',[
  'uses' => 'PageController@getSearchResult',
  'as' => 'search'
]);

// Product Pages
Route::get('product={id}',[
  'uses' => 'PageController@getProduct',
  'as' => 'product'
]);

Route::get('buy_product={id}',[
  'uses' => 'PageController@getBuyProduct',
  'as' => 'buyProduct'
]);

Route::get('add_product',[
  'uses' => 'PageController@getAddProduct',
  'as' => 'addProduct',
  'middleware' => 'auth'
]);

Route::get('edit_products',[
  'uses' => 'PageController@getEditProducts',
  'as' => 'editProducts',
  'middleware' => 'auth'
]);

Route::get('edit_product_single_{id}',[
  'uses' => 'PageController@getEditProductSingle',
  'as' => 'editProductSingle',
  'middleware' => 'auth'
]);

// Profile Pages
Route::get('profile',[
  'uses' => 'PageController@getProfile',
  'as' => 'profile'
]);

Route::get('profile={id}',[
  'uses' => 'PageController@getPublicProfile',
  'as' => 'publicProfile'
]);

// Purchase Pages
/*Route::get('after_buying',[
  'uses' => 'PageController@getAfterBuying',
  'as' => 'afterBuying',
  'middleware' => 'auth'
]);*/

Route::get('purchases',[
  'uses' => 'PageController@getPurchases',
  'as' => 'purchases',
  'middleware' => 'auth'
]);

Route::get('purchased_item/{product_id}',[
  'uses' => 'PageController@getPurchasedItem',
  'as' => 'purchasedItem',
  'middleware' => 'auth'
]);

#=============== End PageController Routes ===============#

#=============== UserController Routes ===============#

Route::post('login',[
  'uses' => 'UserController@postLogin',
  'as' => 'login'
]);

Route::post('register',[
  'uses' => 'UserController@postRegister',
  'as' => 'register'
]);

Route::get('logout',[
  'uses' => 'UserController@getLogout',
  'as' => 'logout',
  'middleware' => 'auth'
]);

Route::post('update_profile',[
  'uses' => 'UserController@postUpdateProfile',
  'as' => 'updateProfile',
  'middleware' => 'auth'
]);

Route::post('postProduct',[
  'uses' => 'UserController@postProduct',
  'as' => 'postProduct',
  'middleware' => 'auth'
]);

Route::post('updateProduct/{id}',[
  'uses' => 'UserController@postUpdateProduct',
  'as' => 'updateProduct',
  'middleware' => 'auth'
]);

Route::post('postPaymentCard',[
  'uses' => 'UserController@postPaymentCard',
  'as' => 'postPaymentCard',
  'middleware' => 'auth'
]);

Route::post('postPayProduct/{id}',[
  'uses' => 'UserController@postPayProduct',
  'as' => 'PayProduct',
  'middleware' => 'auth'   
]);

Route::post('approveMoney/userId={user_id}_productId={product_id}',[
  'uses' => 'UserController@postApproveMoney',
  'as' => 'approve',
  'middleware' => 'auth'   
]);

#=============== End UserController Routes ===============#

#=============== ProviderController Routes ===============#

Route::get('login/{provider}',[
  'uses' => 'ProviderController@redirectToProvider',
  'as' => 'login-provider'
]);

Route::get('login/{provider}/callback',[
  'uses' => 'ProviderController@handleProviderCallback',
  'as' => 'login-provider-callback'
]);


#=============== End ProviderController Routes ===============#
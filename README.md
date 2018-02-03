# ZECommerCe (beta):
* Tiny E-Commerce website with multiple third party APIs (facebook - twitter - google - stripe)
* The aim of this website is to integrate third party APIs 
* This is the beta version ... a lot of features coming up soon

### Demo:  
* http://infinite-everglades-85816.herokuapp.com
* when adding new payment card you can go to [here](https://stripe.com/docs/testing#cards) and add random digits for MM/YY and CVC or use the following info:
* Card number:`4242 4242 4242 4242` MM/YY:`12/30` CVC:`5555`
### Heroku PaaS issues(storage issues):
* when you open the previous link you may see no image for each post ... if you see `No products yet! sign in/up and be the first one to add new product` then that's ok but if you see blank page move the mouse to the left under the navbar and you'll see the product
* you may see no product , profile , user and author image

### Getting started:
* In .env file update the database and the stripe configuration
* Go to config/services.php and update facebook , twitter and google configuration and change `your_URL` to your URL
* Open the terminal or command prompt and navigate to the project directory and run `composer install`
* Generate a key using `php artisan key:generate`
* Clear the config cache by running `php artisan config:cache`
* Finally run `php artisan migrate`

### Technologies:
* Laravel 
* jQuery 
* Bootstrap
* Sass

### Packages:
* [Stripe](https://github.com/stripe/stripe-php)
* [Socialite](https://github.com/laravel/socialite)

### Plugins & Third party resources:
* [Datepicker](http://api.jqueryui.com/datepicker)
* [Facebook](https://facebook.com) (to login)
* [Twitter](https://twitter.com) (to login)
* [Google](https://google.com) (to login)
* [Stripe](https://stripe.com) (payment gateway)



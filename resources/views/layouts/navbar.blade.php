<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">ZECommerCe</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
      </ul>
      <form action="{{route('search')}}" class="navbar-form navbar-right">
        <div class="form-group">
          <input type="text" name="search" class="form-control" placeholder="Search" required>
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::user())

        <!--<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell"></i></a>
          <div class="dropdown-menu"><h4>fjdsklfjlkasdf</h4></div>
        </li>-->

        <li class="{{ Request::is('purchases') ? 'active' : '' }}"><a href="{{ route('purchases') }}">Purchases ({{Auth::user()->purchases->count()}})</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="{{ Request::is('add_product') ? 'active' : '' }}"><a href="{{ route('addProduct') }}"><i class="fa fa-plus-circle"></i> Add Prouduct</a></li>
            <li class="{{ Request::is('edit_products') ? 'active' : '' }}"><a href="{{ route('editProducts') }}"><i class="fa fa-pencil-square"></i> Edit Prouduct ({{Auth::user()->products->count()}})</a></li>
            <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ route('profile') }}"><i class="fa fa-cog"></i> Settings</a></li>
            <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>        
        @else
        <li class="{{ Request::is('LoginAndRegister') ? 'active' : '' }}"><a href="{{ route('Login-Register') }}">Login / Register</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
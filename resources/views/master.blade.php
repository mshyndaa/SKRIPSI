<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin MCC</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap files (jQuery first, then Popper.js, then Bootstrap JS) -->

<link href = {{ asset("css/bootstrap.min.css") }} rel="stylesheet" />
     <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <link href = {{ asset("css/datatables.min.css") }} rel="stylesheet" />
    
     <link href = {{ asset("css/LTE/plugins/fontawesome-free/css/all.min.css") }} rel="stylesheet" />
     
</head>
<body>
    <div class="container">
        <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="main_nav">
    <div col="4">
<ul class="navbar-nav">
<li class="nav-item"> <a class="nav-link  active" id="admin" href="/admin"> Admin </a> </li>
<li class="nav-item"> <a class="nav-link" id="user" href="/user"> User</a></li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">  Mall  </a>
    <ul class="dropdown-menu">
	  <li><a class="dropdown-item" href="/ms_item/1"> Gandaria City</a></li>
	  <li><a class="dropdown-item" href="/ms_item/2"> Kota Kasablanka </a></li>
          <li><a class="dropdown-item" href="/ms_item/3"> Blok M </a></li>
         
    </ul>
</li>

</ul>
    </div>       
        <div col="6"><br style="line-height:15;" /></div>
        </div>
    <div col="2">
    <ul class="nav navbar-nav navbar-right" >
    <li class="nav-item" style="align-items: right">
                    <a class="nav-link" href="{{route('adminlogout')}}"><i class="fa fa-sign-out"></i> Logout</a>
                </li>
                
            </ul>
    </div>
</div> <!-- navbar-collapse.// -->
</nav>
          @yield('konten')
        </div>
        </div>        
    </div>
</body>
 
</html>

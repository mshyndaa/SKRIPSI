<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link href = {{ asset("css/bootstrap.min.css") }} rel="stylesheet" />
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <link href = {{ asset("css/datatables.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/plugins/fontawesome-free/css/all.min.css") }} rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600&display=swap" rel="stylesheet">
     
    <style>
        body {
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Set minimum height to 100% of viewport height */
            font-family: 'Poppins', sans-serif;
        }
        .header {
            font-weight: 600;
        }
        .regular {
            font-weight: 400;
        }
        .semi {
            font-weight: 200;
        }
        .light {
            font-weight: 100;
        }
        .navbar {
            background-color: #11142C;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-collapse {
            justify-content: flex-end;
        }
        .container {
            flex: 1; /* Grow container to fill remaining vertical space */
        }
        footer {
            color: white;
            background-color: #11142C;
            padding: 10px 0;
            text-align: center;
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="text header text-uppercase" style="color: white;margin-top:0.2rem">
                <H5 style="font-weight: bold;">Dashboard Center</h5>
            </div>
            <div class="collapse navbar-collapse justify-content-end" style="margin-right: 1rem" id="navbarNav">
                    <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link  active" id="admin" href="/admin"> Admin </a> </li>
                    <li class="nav-item"> 
                        <a class="nav-link" id="user" href="/user"> User</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mall
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/ms_item/1">Gandaria City</a>
                                <a class="dropdown-item" href="/ms_item/2">Kota Kasablanka</a>
                                <a class="dropdown-item" href="/ms_item/3">Blok M</a>
                            </div>
                        </li>
                        <li class="nav-item" style="margin-left: 2rem">
                            <a class="nav-link" href="{{ route('adminlogout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul> 
                </div>
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div>  
        <footer>
            <p>&copy; Mall Dashboard 2024 | Bedria Mashyanda Maail - 2440027303</p>
        </footer>
</body>
</html>



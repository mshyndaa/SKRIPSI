<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mall Dashboard - Login</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600&display=swap" rel="stylesheet">
    <link href = {{ asset("css/LTE/plugins/fontawesome-free/css/all.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/dist/css/adminlte.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/plugins/toastr/toastr.min.css") }} rel="stylesheet" />  

    <style>
        body {
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

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container-fluid {
            padding: 0%;
        }
        .login-image {
            background-image: url('{{ asset('asset/bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .btn{
            background-color :#11142C;
            color: #ffffff;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

    </style>

</head>
<body>
    <div class="container-fluid login-container">
        <div class="row w-100">
            <div class="col-md-6 login-image d-none d-md-block"></div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="w-75">
                    <h2 class="header"><b>WELCOME ON BOARD !</b></h2>
                    <h5 class="light">Sign in to get all access.</h5>

                    @if(session('message'))
                    <div class="alert alert-danger regular">
                        {{session('message')}}
                    </div>
                    @endif

                    <form action="{{ route('verifyLoginStaff') }}" method="post">
                        @csrf
                        <div class="form" style="margin-top:2rem;">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <span class="fas fa-user"></span>
                              </div>
                            </div>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                          </div>

                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                              </div>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                          </div>
                        </div>

                        <button type="submit" class="btn btn-block regular" style="margin-top:2rem">Log In</button>

                        @if ($errors->has('email'))
                        <span>
                            <strong style="color:red;">{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                        <p class="text-center light" style="margin-top: 1rem;">Don't have an account ? <a href="/register" class="regular">Register</a> now!</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mall Dashboard - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-eZYScPneDUbOeJz5dDgJ7+0w+uWLUFVECt+LfrE/W1JOny5QjFWJ7Pau0xG7lsPb" crossorigin="anonymous">
    <link href = {{ asset("css/LTE/plugins/fontawesome-free/css/all.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/dist/css/adminlte.min.css") }} rel="stylesheet" />
    <link href = {{ asset("css/LTE/plugins/toastr/toastr.min.css") }} rel="stylesheet" />  

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
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
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container-fluid {
            padding: 0%;
        }
        .register-image {
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
    </style>

</head>
<body>
    <div class="container-fluid register-container">
        <div class="row w-100">
            <div class="col-md-6 register-image d-none d-md-block"></div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="w-75">
                    <h2 class="header"><b>GLAD YOU'RE HERE!</b></h2>
                    <h5 class="light">Please sign up to access the system.</h5>

                    @if(session('message'))
                    <div class="alert alert-success regular">
                        {{session('message')}}
                    </div>
                    @endif

                    <form action="{{ route('ActionRegister') }}" method="post">
                        @csrf
                        <div class="input-group mb-3 mt-3">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                              </div>
                            </div>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                          </div>
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
                            <input type="text" name="password" id="password" class="form-control" placeholder="password">
                          </div>
                          
                        <div class="form-group" style="display:none">
                            <label class="regular"><i class="fas fa-address-book"></i> Role</label>
                            <input type="text" name="role" class="form-control regular" value="Guest" readonly>
                        </div>
                        <button type="submit" class="btn btn-block semi">Register</button>

                        <p class="text-center light" style="margin-top: 1rem;">Already have an account ? <a href="/" class="regular">Login here</a> !</p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

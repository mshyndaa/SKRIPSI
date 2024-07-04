<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - Login</title>
    <link href = {{ asset("css/bootstrap.css") }} rel="stylesheet" />
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
          background-image: url('{{ asset('asset/bgadmin.png') }}');
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
  <div class="container-fluid login-container">
    <div class="row w-100">
      <div class="col-md-6 login-image d-none d-md-block"></div>
      <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="w-75">
          <h2 class="header"><b>WELCOME ON BOARD !</b></h2>
          <h5 class="light">Sign in to get all access.</h5>

          @if(session('message'))
          <div class="alert alert-danger">
              {{session('message')}}
          </div>
          @endif

       <form action="{{ route('verifyLogin') }}" method="post">
            @csrf
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
        <div class="row">
          <div class="col-8">
            <label>
              <input type="checkbox" id="remember" name="remember"  checked="checked"> Remember Me
            </label>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-sm btn-block" id="btnLogin">Sign In</button>
          </div>
            @if ($errors->has('email'))
          <span>
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
          <!-- /.col -->
        </div>
        </form>
            
    </div>
   
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
 <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- Bootstrap 4 -->

<script type="text/javascript">
  $(function() {
   
  });
 </script> 


</body>
</body>
</html>
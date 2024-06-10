@include('login.template')
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }} </div>
@endif
@if(session('error'))
<div class="alert alert-danger"> {{ session('error') }} </div>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Peduli | Log in </title>
  <link rel="icon" href="{{ asset('adminlte/logo/page.png')}}" type="image/png">


</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
              <a href="">
                  <img src="{{ asset('adminlte/logo/landing.png')}}" alt="Logo Peduli Lingkungan" class="h1" style="width: 300px; height: 100px;">
                  
              </a>
              
          </div>
          <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
      
            <form action="{{url('proses_login')}}" method="post">
              @csrf
      
              <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control" placeholder="Username">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-user"></span> <!-- Menggunakan ikon user -->
                      </div>
                  </div>
              </div>
              <div class="input-group mb-3">
                  <input type="password"  name="password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-8">
                      <div class="icheck-primary">
                          <input type="checkbox" id="remember">
                          <label for="remember">
                              Remember Me
                          </label>
                      </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                  </div>
                  <!-- /.col -->
              </div>
          </form>
          
      
            
            <!-- /.social-auth-links -->
      
            
            <p class="mb-4">
              <a href="{{ route('register') }}" class="text-center">
                  <i class="fas fa-user-plus"></i> Register
              </a>
          </p>
         
            <p class="mb-0">
              <a href="{{ url('/') }}">
                  <i class="fas fa-arrow-left"></i> Back
              </a>
          </p>
         
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      
<!-- /.login-box -->


</body>
</html>

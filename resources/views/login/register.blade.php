@include('login.template')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Peduli | Registration </title>
  <link rel="icon" href="{{ asset('adminlte/logo/page.png')}}" type="image/png">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">

        <img src="{{ asset('adminlte/logo/landing.png')}}" alt="Logo Peduli Lingkungan" class="h1" style="width: 200px; height: auto;">
        
  
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="{{route('proses_register')}}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username') }}" placeholder="Username" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-plus"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="Nama" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="ktp" class="form-control @error('ktp') is-invalid @enderror"
            value="{{ old('ktp') }}" placeholder="KTP" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
            value="{{ old('alamat') }}" placeholder="Alamat" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marker-alt"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
            value="{{ old('telepon') }}" placeholder="Telepon" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

      <a href="{{url('login')}}" class="text-center">Sudah mempunyai akun</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->


</body>
</html>

<head>
  <link rel="stylesheet" href="{{asset('temp/assets/css/main.css')}}" />
</head>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a h class="navbar-brand">
      <img src="{{ asset('adminlte/logo/page.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Peduli Lingkungan</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
    <ul class="navbar-nav">
        
    </ul>
    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        @if (Auth::check())
    <a href="/warga" class="nav-link">Home</a>
      @else
    <a href="/" class="nav-link">Home</a>
    @endif

      </li>
      <li class="nav-item">
        <a href="#footer" class="nav-link">Contact</a>
      </li>
      <li class="nav-item">
        <a href="/about" class="nav-link">About us</a>
      </li>
        
       
    </ul>
    

      <!-- SEARCH FORM -->
      <form class="form-inline ml-0 ml-md-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      @auth
    <li class="nav-item">
      <span class="nav-link" data-toggle="modal" data-target="#profileModal">
        <i class="fas fa-user"></i> {{ Auth::user()->nama }}
      </span>
    </li>
    <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </li>
    <script>
      function confirmLogout() {
          if (confirm("Apakah Anda yakin akan logout?")) {
              window.location.href = "{{ route('logout') }}";
          }
      }
    </script>
@else
    <li class="nav-item">
        <a href="/login" class="nav-link">Login</a>
    </li>
@endauth

    </ul>
  </div>
</nav>

<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h5 class="modal-title" id="profileModalLabel">Profile</h5 >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: red">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Your profile widget starts here -->
        <div class="card card-widget widget-user" >
          <div class="widget-user-header bg-white" >
            <h3 class="widget-user-username">{{ Auth::user()->nama }}</h3>
            <h5 class="widget-user-desc">Warga</h5>
          </div>
          <div class="widget-user-image">
            <img src="{{ asset('adminlte/logo/page.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">Username</h5>
                  <span class="description-text">{{ Auth::user()->username }}</span>
                </div>
              </div>
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">Alamat</h5>
                  <span class="description-text">{{ Auth::user()->alamat }}</span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">Telepon</h5>
                  <span class="description-text">{{ Auth::user()->telepon }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Your profile widget ends here -->
      </div>
    </div>
  </div>
</div>
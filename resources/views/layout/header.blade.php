<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a h class="navbar-brand">
      <img src="{{ asset('adminlte/logo/page.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Pengaduan Warga</span>
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
        <a href="/warga" class="nav-link">Home</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">About us</a>
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
        <span class="nav-link">
            <i class="fas fa-user"> </i> {{ Auth::user()->nama }}
        </span>
    </li>
    
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
          <i class="fas fa-sign-out-alt"></i> Logout
      </a>
  </li>
  
      @endauth
    </ul>
  </div>
</nav>
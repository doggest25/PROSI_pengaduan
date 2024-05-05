@extends('layout.template')

@section('title')
<h1 class="m-0"> Dashboard <small>page</small>  </h1>@endsection
@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="card">
  
  <div class="card-body">
    <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title m-0">Pengaduan</h5>
          </div>
          <div class="card-body">
            

            <p class="card-text">Laporkan aduanmu disini.</p>
            <a href="{{url('warga/pengaduan')}}" class="btn btn-primary">Adukan</a>
          </div>
        </div>

        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title m-0">History Pengaduan</h5>
          </div>
          <div class="card-body">
           

            <p class="card-text"></p>
            <a href="{{url('warga/detail')}}" class="btn btn-primary">Klik disini</a>
          </div>
        </div>
      </div>
      <!-- /.col-md-6 -->
  </div>
</div>
@endsection
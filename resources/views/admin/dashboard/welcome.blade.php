@extends('layouts.template')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
<!-- lapisan 1 -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $diproses}}</h3>
        <p>Pengaduan Diproses</p>
      </div>
      <div class="icon">
        <i class="ion ion-refresh"></i>
      </div>
      <a href="{{url('/dpengaduan')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $diterima}}</h3>
        <p>Pengaduan Diterima</p>
      </div>
      <div class="icon">
        <i class="ion ion-checkmark"></i>
      </div>
      <a href="{{url('/dpengaduan')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $ditolak}}</h3>
        <p>Pengaduan Ditolak</p>
      </div>
      <div class="icon">
        <i class="ion ion-close"></i>
      </div>
      <a href="{{url('/dpengaduan')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $selesai}}</h3>
        <p>Pengaduan Selesai</p>
      </div>
      <div class="icon">
        <i class="ion ion-trophy"></i>
      </div>
      <a href="{{url('/dpengaduan')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>


 <!-- lapisan 2 -->
 <div class="card card-success bg-white">
  <div class="row">
    <!-- bagian 1 -->
    <div class="col-md-6">
      <div class="card-body" style="position: relative;">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card mb-3">
                <img class="card-img-top" style="width: 100%;" src="{{ asset('adminlte/logo/dash-admin.png') }}" alt="Dist Photo 1">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
                  <h3 class="card-title text-primary text-white" style="font-size: 31px;"><strong>{{ $total2 }} Pengaduan</strong></h3>
                  <p class="card-text text-white pb-2 pt-1">Sudah dilakukan pada aplikasi ini</p>
                  @if($lastComplaint)
                  <a href="/dpengaduan" class="text-primary"> Pengaduan Terbaru {{ Carbon\Carbon::parse($lastComplaint->created_at)->diffForHumans() }}</a>
                  @else
                  <p>Belum ada pengaduan yang dibuat.</p>
                  @endif
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card mb-3">
                <img class="card-img-top" style="width: 100%;" src="{{ asset('adminlte/logo/dash2.png') }}" alt="Dist Photo 2">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
                  <h3 class="card-title text-primary text-white" style="font-size: 31px;"><strong>{{ $total }} User Warga</strong></h3>
                  <p class="card-text text-white pb-2 pt-1">Sudah Mendaftar pada aplikasi ini</p>
                  @if($lastComplaint)
                  <a href="/dpengaduan" class="text-primary"> User Warga Terbaru {{ Carbon\Carbon::parse($lastRegister->created_at)->diffForHumans() }}</a>
                  @else
                  <p>Belum ada pengaduan yang dibuat.</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev" >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next" >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
    <!-- bagian 2 -->
    
    <div class="col-md-6">
      <div class="card-body" style="position: relative;">
        <div class="card">
              <div class="card-header border-transparent">
                   Kritik & Saran Terbaru <i class="fas fa-history"></i> 
              </div>
            
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesan as $p)
                            <tr>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->message  }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
            <a class="btn btn-sm btn-primary mt-1 detail-button" href="{{ url('pesan/') }}">Detail</a>  
        </div>
        
      </div>
  </div>
    
  </div>
</div>



 <!-- lapisan 3 -->
 <div class="h-screen bg-White-100">
  <div class="container px-4 mx-auto">

    <div class="p-6 m-20 bg-white rounded shadow">
        {!! $chart->container() !!}
    </div>

  </div>

  <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}
  </div>

@endsection


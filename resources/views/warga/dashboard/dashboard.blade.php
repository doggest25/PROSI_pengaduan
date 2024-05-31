@extends('layout.template')

@section('content')
@if(session('success'))
    <div class="alert alert-success"> {{ session('success') }} </div>
@endif
@if(session('error'))
    <div class="alert alert-danger"> {{ session('error') }} </div>
@endif

<!-- Banner -->
<section id="banner" style="background: url('{{ asset('images/background-pattern.jpg') }}') repeat; background-color: #f2f2f2;">
    <div class="inner">
        <header>
            <h2 style="color: grey;">Aduanmu Penting Bagi Kami</h2>
        </header>
       
        <p style="color: grey; text-align: center;">
          Selamat datang di 
          <strong>
              <a href="{{ url('/about') }}" style="color: #ffcc00; transition: color 0.3s;" onmouseover="this.style.color='#ff6600'" onmouseout="this.style.color='#ffcc00'">
                  <img src="{{ asset('picture/thr.png') }}" alt="Website Logo" style="width: 200px; height: 150px; vertical-align: middle; margin-right: 5px;" />
              </a>
          </strong>Website
          <br><br>
      </p>
      
        <footer>
            <ul class="buttons stacked">
                <li><a href="{{url('warga/pengaduan')}}" class="button fit scrolly">Adukan</a></li>
            </ul>
        </footer>
    </div>
</section>

<!-- Features -->
<section id="features" style="padding: 2em 0; background-color: #f9f9f9;">
    <div class="container">
        <header>
            <h2><strong>Riwayat Pengaduan</strong></h2>
        </header>
        <div class="row aln-center" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <div class="col-4 col-6-medium col-12-small" style="margin-bottom: 2em;">
                <!-- Feature -->
                <section style="border: 1px solid #ddd; padding: 1em; background-color: #fff; border-radius: 8px;">
                    <a href="#" class="image featured"><img src="{{ asset('images/pic01.jpg')}}" alt="" style="border-radius: 8px;"/></a>
                    <header>
                        <h3>Tanggal 5 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Sampah menumpuk di taman</p>
                    <p>Penyelesaian: Petugas kebersihan telah membersihkan taman dan mengambil tindakan pencegahan.</p>
                </section>
            </div>
            <div class="col-4 col-6-medium col-12-small" style="margin-bottom: 2em;">
                <!-- Feature -->
                <section style="border: 1px solid #ddd; padding: 1em; background-color: #fff; border-radius: 8px;">
                    <a href="#" class="image featured"><img src="{{ asset('images/pic02.jpg')}}" alt="" style="border-radius: 8px;"/></a>
                    <header>
                        <h3>Tanggal 12 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Pohon tumbang di jalan</p>
                    <p>Penyelesaian: Tim pemadam kebakaran telah membersihkan pohon dan memperbaiki kerusakan yang disebabkan.</p>    
                </section>
            </div>
            <div class="col-4 col-6-medium col-12-small" style="margin-bottom: 2em;">
                <!-- Feature -->
                <section style="border: 1px solid #ddd; padding: 1em; background-color: #fff; border-radius: 8px;">
                    <a href="#" class="image featured"><img src="{{ asset('images/pic03.jpg')}}" alt="" style="border-radius: 8px;"/></a>
                    <header>
                        <h3>Tanggal 19 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Kebocoran air di jalan</p>
                    <p>Penyelesaian: Tim teknisi telah memperbaiki pipa dan menangani kebocoran dengan cepat.</p>
                </section>
            </div>
            <div class="col-12" style="text-align: center; margin-top: 2em;">
                <ul class="actions">
                    <li><a href="{{url('warga/detail')}}" class="button icon solid fa-file">Lihat Detail</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

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
@endsection






























{{-- hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdlhjasdkjashdjhjaskdhkjahdkjahdl 
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl

    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl
    hjasdkjashdjhjaskdhkjahdkjahdl --}}
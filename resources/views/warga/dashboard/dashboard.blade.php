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
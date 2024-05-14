
@extends('layout.template')

@section('content')
<!-- Banner -->
<section id="banner">
    <!--
        ".inner" is set up as an inline-block so it automatically expands
        in both directions to fit whatever's inside it. This means it won't
        automatically wrap lines, so be sure to use line breaks where
        appropriate (<br />).
    -->
    <div class="inner">
        <header>
            <h2>Aduanmu Penting Bagi Kami</h2>
        </header>
        <p>selamat datang di <strong><a href="{{url('/about')}}">Peduli Lingkungan</a></strong> Website
            <br>
            <br>
        </p>
        <footer>
            <ul class="buttons stacked">
                <li><a href="{{url('warga/pengaduan')}}" class="button fit scrolly">Adukan</a></li>
            </ul>
        </footer>
    </div>
</section>

<!-- Features -->
<section id="features">
    <div class="container">
        <header>
            <h2><strong>Riwayat Pengaduan</strong></h2>
        </header>
        <div class="row aln-center">
            <div class="col-4 col-6-medium col-12-small">
                <!-- Feature -->
                <section>
                    <a href="#" class="image featured"><img src="{{ asset('images/pic01.jpg')}}" alt="" /></a>
                    <header>
                        <h3>Tanggal 5 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Sampah menumpuk di taman</p>
                    <p>Penyelesaian: Petugas kebersihan telah membersihkan taman dan mengambil tindakan pencegahan.</p>
                </section>
            </div>
            <div class="col-4 col-6-medium col-12-small">
                <!-- Feature -->
                <section>
                    <a href="#" class="image featured"><img src="{{ asset('images/pic02.jpg')}}" alt="" /></a>
                    <header>
                        <h3>Tanggal 12 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Pohon tumbang di jalan</p>
                    <p>Penyelesaian: Tim pemadam kebakaran telah membersihkan pohon dan memperbaiki kerusakan yang disebabkan.</p>    
                </section>
            </div>
            <div class="col-4 col-6-medium col-12-small">
                <!-- Feature -->
                <section>
                    <a href="#" class="image featured"><img src="{{ asset('images/pic03.jpg')}}" alt="" /></a>
                    <header>
                        <h3>Tanggal 19 Mei 2024</h3>
                    </header>
                    <p>Jenis Aduan: Kebocoran air di jalan</p>
                    <p>Penyelesaian: Tim teknisi telah memperbaiki pipa dan menangani kebocoran dengan cepat.</p>
                </section>
            </div>
            <div class="col-12">
                <ul class="actions">
                    <li><a href="#" class="button icon solid fa-file">Lihat Detail</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

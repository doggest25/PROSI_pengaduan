@extends('layout.template')

@section('content')
@if(session('success'))
        <div class="alert alert-success"> {{ session('success') }} </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peduli Lingkungan</title>
  <link rel="icon" href="{{ asset('adminlte/logo/page.png')}}" type="image/png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    
      
        <img src="{{ asset('adminlte/logo/landing1.png')}}" class="card-img-top mx-auto d-block" alt="..." style="width: 50%">
        <div class="card-body text-center">
            <div class="container">
                <div class="row justify-content-center button-container">
                    
                </div>
            </div>
        </div>
    
    




      <!-- Features -->
    <div class="row aln-center">
      <section id="features">
        <div class="container">
          <header>
            <h2>Aduanmu,  <strong>Penting bagi kami </strong>!</h2>
          </header>
          <div class="row aln-center">
            <div class="col-4 col-6-medium col-12-small">

              <!-- Feature -->
                <section>
                  <a href="#" class="image featured"><img src="{{ asset('adminlte/logo/jalan.png')}}" alt="" /></a>
                  <header>
                    <h3>Apa yang Kalian Tunggu?</h3>
                  </header>
                  <p><strong>Mari ! </strong>, bersama-sama menjaga keamanan dan kenyamanan perjalanan di lingkungan kita! 
                  </p>
                </section>

            </div>
            <div class="col-4 col-6-medium col-12-small">

              <!-- Feature -->
                <section>
                  <a href="#" class="image featured"><img src="{{ asset('adminlte/logo/pencuri.png')}}" alt="" /></a>
                  <header>
                    <h3>Tindakan kalian kami butuhkan !</h3>
                  </header>
                  <p><strong>Ayo ! </strong>, laporkan setiap masalah yang Anda temui di sekitar dengan mengakses website kami.
                    
                  </p>
                </section>

            </div>
            <div class="col-4 col-6-medium col-12-small">

              <!-- Feature -->
                <section>
                  <a href="#" class="image featured"><img src="{{ asset('adminlte/logo/sampah.png')}}" alt="" /></a>
                  <header>
                    <h3>Sehingga jadi seperti ini?</h3>
                  </header>
                  <p> <strong>Ingat ! </strong>, laporan Anda sangat berarti untuk kemajuan sarana dan prasarana yang lebih baik. Terima kasih atas partisipasi Anda!</p>
                </section>

            </div>
            <div class="col-12">
              <ul class="actions">
                <li><a href="/login" class="button icon solid fa-file">Laporkan</a></li>
              </ul>
            </div>
          </div>
        </div>
        </section>
    </div>
    

  
</body>
</html>

@endsection

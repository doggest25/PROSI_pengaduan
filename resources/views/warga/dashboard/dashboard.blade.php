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
       <br   >
       <br>
        </p>
        <footer>
            <ul class="buttons stacked">
                <li><a href="{{url('warga/pengaduan')}}" class="button fit scrolly">Adukan</a></li>
            </ul>
        </footer>

    </div>

</section>

    
        <div class="row">
                    <div id="sidebar" class="col-4 col-12-medium">
                        <section>
                            <ul class="divided">
                                <li>

                                    <!-- Highlight -->
                                        <article class="box highlight">
                                            <header>
                                                <h3>History Pengaduan</h3>
                                            </header>
                                            <a href="#" class="image left"><img src="{{asset('temp/images/pic06.jpg')}}" alt="" /></a>
                                            <p>Phasellus sed laoreet massa id justo mattis pharetra. Fusce suscipit ligula vel quam
                                            viverra sit amet mollis tortor congue magna lorem ipsum dolor et quisque ut odio facilisis
                                            convallis. Etiam non nunc vel est suscipit convallis non id orci. Ut interdum tempus
                                            facilisis convallis. Etiam non nunc vel est suscipit convallis non id orci.</p>
                                            <ul class="actions">
                                                <li><a href="{{url('warga/detail')}}" class="button icon solid fa-file">History Pengaduan</a></li>
                                            </ul>
                                        </article>

                                </li>
                            </ul>
                        </section>
                    </div>
        </div>
                  

@endsection
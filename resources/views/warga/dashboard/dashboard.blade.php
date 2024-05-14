@extends('layout.template')


@section('content')

<section id="main">
    <div class="container">
        <div class="row">
                    <div id="sidebar" class="col-4 col-12-medium">
                        <section>
                            <ul class="divided">
                                <li>

                                    <!-- Highlight -->
                                        <article class="box highlight">
                                            <header>
                                                <h3><a href="#">Adukan aduanmu disini !</a></h3>
                                            </header>
                                            <a href="#" class="image left"><img src="{{asset('temp/images/pic06.jpg')}}" alt="" /></a>
                                            <p>Phasellus sed laoreet massa id justo mattis pharetra. Fusce suscipit ligula vel quam
                                            viverra sit amet mollis tortor congue magna lorem ipsum dolor et quisque ut odio facilisis
                                            convallis. Etiam non nunc vel est suscipit convallis non id orci. Ut interdum tempus
                                            facilisis convallis. Etiam non nunc vel est suscipit convallis non id orci.</p>
                                            <ul class="actions">
                                                <li><a href="{{url('warga/pengaduan')}}" class="button icon solid fa-file">Adukan !</a></li>
                                            </ul>
                                        </article>

                                </li>
                                <li>

                                    <!-- Highlight -->
                                        <article class="box highlight">
                                            <header>
                                                <h3><a href="#">Something of less note</a></h3>
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
    </div>               
</section>
@endsection
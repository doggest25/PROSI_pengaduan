@extends('layout.template')
@section('content')
<!-- Main -->
<section id="main">
    <div class="container">
        <div class="row">

            <!-- Content -->
                <div id="content" class="col-8 col-12-medium">

                    <!-- Post -->
                        <article class="box post">
                            <header>
                                <h2><a href="#">Our Journey,<strong>Peduli Lingkungan</strong> ...<br/>
                                Start from Here</a></h2>
                            </header>
                            <a href="#" class="image featured"><img src="{{ asset('adminlte/logo/about.png')}}" alt="" style="width: 900px; height: 500px;" /></a>

                            <h3>PeduLingkungan</h3>
                            <p>PeduLingkungan adalah platform yang berdedikasi untuk menggalang kesadaran dan tindakan positif dalam menjaga lingkungan. 
                                Kami percaya bahwa melalui edukasi, kolaborasi, dan aksi nyata, kita dapat menciptakan perubahan yang berkelanjutan bagi planet kita. 
                                Di PeduLingkungan, kami menyediakan informasi terkini tentang isu-isu lingkungan, solusi-solusi inovatif, serta memfasilitasi komunitas 
                                untuk berbagi pengetahuan dan pengalaman. Dengan semangat kolaboratif, kami mengundang semua individu dan organisasi untuk bergabung 
                                bersama kami dalam membangun masa depan yang lebih hijau dan berkelanjutan untuk generasi mendatang. 
                                Mari bersama-sama menjaga kelestarian alam kita untuk hari esok yang lebih baik..</p>
                            <ul class="actions">
                                <li><a href="#" class="button icon solid fa-file">Continue Reading</a></li>
                                
                            </ul>
                        </article>

                    

                </div>

            <!-- Sidebar -->
                <div id="sidebar" class="col-4 col-12-medium">

                    <!-- Excerpts -->
                        <section>
                            <ul class="divided">
                                <li>

                                    <!-- Excerpt -->
                                        <article class="box excerpt">
                                            <header>
                                                <span class="date">July 30</span>
                                                <h3><a href="#">Laporan Terbaru</a></h3>
                                            </header>
                                            <p> PeduLingkungan baru saja menghadapi 
                                                tantangan baru dalam menjalankan misi
                                                kami untuk melindungi lingkungan. 
                                                Meskipun demikian, kami tetap optimis 
                                                bahwa dengan kolaborasi dan komitmen, 
                                                kita dapat mengatasi hambatan ini 
                                                dan mencapai perubahan positif yang 
                                                kita harapkan.</p>
                                        </article>

                                </li>
                                <li>

                                    <!-- Excerpt -->
                                        <article class="box excerpt">
                                            <header>
                                                <span class="date">July 28</span>
                                                <h3><a href="#">And another post</a></h3>
                                            </header>
                                            <p>Lorem ipsum dolor odio facilisis convallis. Etiam non nunc vel est
                                            suscipit convallis non id orci lorem ipsum sed magna consequat feugiat lorem dolore.</p>
                                        </article>

                                </li>
                                <li>

                                    <!-- Excerpt -->
                                        <article class="box excerpt">
                                            <header>
                                                <span class="date">July 24</span>
                                                <h3><a href="#">One more post</a></h3>
                                            </header>
                                            <p>Lorem ipsum dolor odio facilisis convallis. Etiam non nunc vel est
                                            suscipit convallis non id orci lorem ipsum sed magna consequat feugiat lorem dolore.</p>
                                        </article>

                                </li>
                            </ul>
                        </section>

                    <!-- Highlights -->
                        <section>
                            <ul class="divided">
                                <li>

                                    <!-- Highlight -->
                                        <article class="box highlight">
                                            <header>
                                                <h3><a href="#">Something of note</a></h3>
                                            </header>
                                            <a href="#" class="image left"><img src="images/pic06.jpg" alt="" /></a>
                                            <p>Phasellus sed laoreet massa id justo mattis pharetra. Fusce suscipit ligula vel quam
                                            viverra sit amet mollis tortor congue magna lorem ipsum dolor et quisque ut odio facilisis
                                            convallis. Etiam non nunc vel est suscipit convallis non id orci. Ut interdum tempus
                                            facilisis convallis. Etiam non nunc vel est suscipit convallis non id orci.</p>
                                            <ul class="actions">
                                                <li><a href="#" class="button icon solid fa-file">Learn More</a></li>
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
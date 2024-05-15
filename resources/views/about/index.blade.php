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
                    <a href="#" class="image featured"><img src="{{ asset('adminlte/logo/about.png')}}" alt="About Us Image" style="max-width: 100%;" /></a>

                    <h3>PeduLingkungan</h3>
                    <p>PeduLingkungan adalah platform yang berdedikasi untuk menggalang kesadaran dan tindakan positif dalam menjaga lingkungan. Kami percaya bahwa melalui edukasi, kolaborasi, dan aksi nyata, kita dapat menciptakan perubahan yang berkelanjutan bagi planet kita. Di PeduLingkungan, kami menyediakan informasi terkini tentang isu-isu lingkungan, solusi-solusi inovatif, serta memfasilitasi komunitas untuk berbagi pengetahuan dan pengalaman. Dengan semangat kolaboratif, kami mengundang semua individu dan organisasi untuk bergabung bersama kami dalam membangun masa depan yang lebih hijau dan berkelanjutan untuk generasi mendatang. Mari bersama-sama menjaga kelestarian alam kita untuk hari esok yang lebih baik.
                    </p>
                    <p>PeduLingkungan adalah sebuah platform yang mengemban misi mulia dalam menggalang kesadaran serta tindakan positif untuk menjaga kelestarian lingkungan. Kami teguh dalam keyakinan bahwa dengan pendekatan yang holistik, meliputi edukasi, kolaborasi lintas sektor, dan pelaksanaan tindakan nyata, kita mampu menciptakan perubahan yang berkelanjutan bagi bumi kita. Di PeduLingkungan, kami tidak hanya menyediakan informasi terkini seputar isu-isu lingkungan yang sedang berkembang, tetapi juga menghadirkan solusi-solusi inovatif yang dapat menjadi landasan untuk perubahan positif. Selain itu, kami aktif memfasilitasi komunitas untuk berpartisipasi, berdiskusi, dan berbagi pengalaman guna mendorong kolaborasi yang lebih luas dalam menjaga kelestarian alam. Dengan semangat kolaboratif yang mendalam, kami mengundang setiap individu dan organisasi untuk bersama-sama bergabung dalam upaya menjadikan masa depan bumi kita lebih hijau dan berkelanjutan bagi generasi mendatang. Mari bergandengan tangan dalam menjaga kelestarian alam untuk menciptakan hari esok yang lebih baik dan bercahaya bagi seluruh makhluk hidup di planet ini.
                    </p>
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
                                <p>PeduLingkungan baru saja menghadapi 
                                    tantangan baru dalam menjalankan misi
                                    kami untuk melindungi lingkungan. 
                                    Meskipun demikian, kami tetap optimis 
                                    bahwa dengan kolaborasi dan komitmen, 
                                    kita dapat mengatasi hambatan ini 
                                    dan mencapai perubahan positif yang 
                                    kita harapkan.</p>
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
                                    <h3><a href="#">Events</a></h3>
                                </header>
                                <ul>
                                    <li>
                                        <span class="date">5 Mei 2024 </span>
                                        <h4><a href="#">Membersihkan Selokan</a></h4>
                                        <p>Gotong royong membersihkan selokan dilakukan pada hari Minggu di seluruh RT 03 .</p>
                                    </li>
                                    <li>
                                        <span class="date">12 Mei 2024</span>
                                        <h4><a href="#">Menebang Pohon</a></h4>
                                        <p>Gotong royong menebang pohon di pinggir jalan yang sudah tua pada hari Minggu di seluruh lingkungan RW.</p>
                                    </li>
                                    <li>
                                        <span class="date">26 Mei 2024</span>
                                        <h4><a href="#">Kebersihan Lingkungan</a></h4>
                                        <p>Gotong royong memotong rumput dilakukan pada hari Minggu di seluruh jalan pada lingkungan RW.</p>
                                    </li>
                                    <li>
                                        <span class="date">9 Juni 2024</span>
                                        <h4><a href="#">Perbaikan Infrastruktur</a></h4>
                                        <p>Gotong royong dalam merawat taman yang berada pada RT 05 dilakukan pada hari Minggu.</p>
                                    </li>
                                    <li>
                                        <span class="date">30 Juni 2024</span>
                                        <h4><a href="#">Rapat RT</a></h4>
                                        <p>Rapat untuk seluruh ketua RT dilaksanakan pada hari Minggu malam hari .</p>
                                    </li>
                                </ul>
                            </article>
                        </li>
                        <li>
                            <!-- Highlight -->
                            <article class="box highlight">
                                <header>
                                    <h3><a href="#">Catatan</a></h3>
                                </header>
                                <p>Catatan Anda di sini.</p>
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

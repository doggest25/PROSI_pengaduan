<head>
  <link rel="stylesheet" href="{{asset('temp/assets/css/main.css')}}" />
</head>
<!-- Footer -->
<section id="footer">
  <div class="container">
    <header>
      <h2>Kritik dan Saran?</h2>
    </header>
    <div class="row">
      <div class="col-6 col-12-medium">
        <section>
          <form method="post" action="{{ route('contact.store') }}">
            @csrf
            <div class="row gtr-50">
                <div class="col-6 col-12-small">
                    <input name="name" placeholder="Name" type="text" required />
                </div>
                <div class="col-6 col-12-small">
                    <input name="email" placeholder="Email" type="email" required />
                </div>
                <div class="col-12">
                    <textarea name="message" placeholder="Message" required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="form-button-submit button icon solid fa-envelope">Send Message</button>
                </div>
            </div>
        </form>
        
        </section>
      </div>
      <div class="col-6 col-12-medium">
        <section>
          <p>Website Peduli Lingkungan adalah website yang sedang berkembang untuk memudahkan warga dalam hal pengaduan. Pengaduan dari berbagai macam hal untuk disampaikan pada ketua RW</p>
          <div class="row">
            <div class="col-6 col-12-small">
              <ul class="icons">
              
              <li class="icon solid fa-home">
                  <a href="https://maps.app.goo.gl/9eUVC9CLNrXyW2HK8">
                    RW 03<br />Jl. Semanggi 2-15, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141<br /></a>
                  <!-- POLITEKNIK NEGERI MALANG<br />
                  Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141<br /> -->
                </li>
                <li class="icon solid fa-phone">
                  <a href="https://wa.me/+6285749379804">085749379804</a>
                </li>
                <li class="icon solid fa-envelope">
                  <a href="#">pedulingkungan@gmail.com</a>
                </li>
              </ul>
            </div>
            <div class="col-6 col-12-small">
              <ul class="icons">
                <li class="icon brands fa-twitter">
                  <a href="#">pedulingkungan@gmail.com</a>
                </li>
                <li class="icon brands fa-instagram">
                  <a href="#">pedulingkungan</a>
                </li>
                <!-- <li class="icon brands fa-dribbble">
                  <a href="#">dribbble.com/untitled</a>
                </li> -->
                <li class="icon brands fa-facebook-f">
                  <a href="#">pedulingkungan</a>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <div id="copyright" class="container">
    <ul class="links">
      <li>&copy; Pedulingkungan. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
    </ul>
  </div>
</section>
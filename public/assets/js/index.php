<?php include 'head.php'; ?>
<body>
  <?php $selected="home"; $selec="class='selec'"; include 'menu.php'; ?>
    <section class="col-xs-12 pad">
      <div id="carousel-home" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="item active">
            <img src="img/banner/1.jpg" alt="">
            <div class="caption">
              <h1>Descubre el estilo<br>que vive cada niño!</h1>
              <h2>DIVERTIDO Y EXCLUSIVO</h2>
            </div>
          </div>
          <div class="item">
              <img src="img/banner/2.jpg" alt="">
              <div class="caption">
                <h1>Descubre el estilo<br>que vive cada niño!</h1>
                <h2>DIVERTIDO Y EXCLUSIVO</h2>
              </div>
          </div>
          <div class="item">
              <img src="img/banner/3.jpg" alt="">
              <div class="caption">
                <h1>Descubre el estilo<br>que vive cada niño!</h1>
                <h2>DIVERTIDO Y EXCLUSIVO </h2>
              </div>
          </div>
          <div class="item">
              <img src="img/banner/4.jpg" alt="">
              <div class="caption">
                <h1>Descubre el estilo<br>que vive cada niño!</h1>
                <h2>DIVERTIDO Y EXCLUSIVO</h2>
              </div>
          </div>
          <div class="item">
              <img src="img/banner/5.jpg" alt="">
              <div class="caption">
                <h1>Productos de cocina</h1>
                <h2>DISEÑOS EXCLUSIVOS</h2>
              </div>
          </div>
        </div>
        <ol class="carousel-indicators">
          <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-home" data-slide-to="1"></li>
          <li data-target="#carousel-home" data-slide-to="2"></li>
          <li data-target="#carousel-home" data-slide-to="3"></li>
          <li data-target="#carousel-home" data-slide-to="4"></li>
        </ol>
      </div>
    </section>
    <section class="col-xs-12 pad" id="contenido">
      <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-lg-offset-2">
        <div class="home1">
          <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 hvr-buzz">
            <div class="home-btn1">
              <h1>CURIOSITY<br>SALE</h1>
              <h2>Descubre nuestras últimas promociones y ofertas en productos específicos.</h2>
              <a href="productos.php#contenido">
                <img src="img/ver.png" onMouseOver="javascript:this.src='img/ver-h.png';" onMouseOut="javascript:this.src='img/ver.png';" class="img-responsive center-block"/>
              </a>
            </div>
          </div>
          <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 hvr-wobble-to-bottom-right">
            <div class="home-btn2">
              <img src="img/btn1.jpg" class="img-responsive " alt="" />
            </div>
            <div class="home-btn2-tex">
              <h1>CURIOSITY<br>SPECIALS</h1>
              <h2>Curiosidades para fechas especiales y momentos importantes. </h2>
              <a href="productos.php#contenido">
                <img src="img/ver-2.png" onMouseOver="javascript:this.src='img/ver-2-h.png';" onMouseOut="javascript:this.src='img/ver-2.png';" class="img-responsive center-block"/>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a href="productos.php#contenido" class="btn-home1">
            <span>
              <h1>CURIOSITY KIDS</h1>
              <p>
                Selección de accesorios y ropa para tu bebé de marcas y diseños exclusivos, escogidos con el tiempo y cariño para ti. Ideales para Babyshowers.
              </p>
              <img src="img/ver-3.png" onMouseOver="javascript:this.src='img/ver-3-h.png';" onMouseOut="javascript:this.src='img/ver-3.png';" class="img-responsive center-block"/>
            </span>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <a href="productos.php#contenido" class="btn-home2">
            <span>
              <h1>CURIOSITY CHEF</h1>
              <p>
                Productos de cocina de marcas y diseños exclusivos.
 Ideales para regalos de matrimonio, inauguración de casas o para amigos amantes de la cocina. 
              </p>
              <img src="img/ver.png" onMouseOver="javascript:this.src='img/ver-h.png';" onMouseOut="javascript:this.src='img/ver.png';" class="img-responsive center-block"/>
            </span>
          </a>
        </div>
      </div>
    </section>
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12 photo" data-stellar-background-ratio="0.6">
      <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 col-lg-offset-1">
        <h1>Accesorios y Ropa para Pequeños</h1>
        <p>Curiosidades para amantes de la cocina y Chefs!</p>
      </div>
    </section>
<?php include 'footer.php'; ?>

<?php 
  defined('SITE') OR exit('Неразрешен директен достъп');
?>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-xl-10 d-flex align-items-center">
          <h1 class="logo mr-auto"><a href="index.php"><?=SITE_NAME?>-Admin<span>.</span></a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt=""></a>-->

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li <?=($menu_active == 'Страници')? 'class="active"' : '' ?>><a href="index.php">Страници</a></li>
              <li <?=($menu_active == 'Нова Страница')? 'class="active"' : '' ?>><a href="add_page.php">Нова страница</a></li>
              <li <?=($menu_active == 'Файлове')? 'class="active"' : '' ?>><a href="upload.php">Файлове</a></li>
              <li ><a href="../index.php">>> Към сайта</a></li>
            </ul>
          </nav><!-- .nav-menu -->

         
        </div>
      </div>

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <!-- <ol>
          <li><a href="index.html">Home</a></li>
          <li>Inner Page</li>
        </ol> -->
        <h2><?= $html_title;?></h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
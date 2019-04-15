<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Design System for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>MaratonShp</title>
  <!-- Favicon -->
  <link href="./assets/img/brand/ms.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet">
  <!-- Icons -->
  <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="./assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Style CSS -->
  <link type="text/css" href="./assets/css/style.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="./assets/css/argon.css?v=1.0.0" rel="stylesheet">
  <!-- Docs CSS -->
  <link type="text/css" href="./assets/css/docs.min.css" rel="stylesheet">
</head>

<body>
    
  <?php
    require_once("../class_php/Class.php");

    $loginModal = true;
    //$_SESSION['id_table_user'] = 123;
    $globalData['table_user_gambar'] = "profil-default.png";

    if(isset($_SESSION['id_table_user'])){
      $loginModal = false;
      $globalSql = "SELECT * FROM table_user WHERE id_table_user = '$_SESSION[id_table_user]'";
      $globalGet = $query->select($globalSql);
      $globalData = mysqli_fetch_array($globalGet);

      if($globalData['table_user_gambar'] == null | $globalData['table_user_gambar'] == ''){
          $globalData['table_user_gambar'] = "profil-default.png";
      }
    }else{
      $loginModal = true;
    }

  ?>

  <header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="./index.php">
          <img src="./assets/img/brand/ms.png"> <span class="text-brand">MaratonShop</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="./index.html">
                  <img src="./assets/img/brand/ms.png"> <span class="text-brand">MaratonShop</span>
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
            <li class="nav-item">
              <a href="#" class="nav-link" role="button">
                <span class="badge badge-pill badge-primary">5</span>
                <i class="ni ni-ui-04 d-lg-none"></i>
                <span class="nav-link-inner--text">Keranjang Belanjaanku</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="../belakang/index.php" class="nav-link" role="button">
                <i class="ni ni-collection d-lg-none"></i>
                <span class="nav-link-inner--text">Tokoku Sendiri</span>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Pantau terus Facebook kami">
                <i class="fa fa-facebook-square"></i>
                <span class="nav-link-inner--text d-lg-none">Facebook</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" title="Follow juga ya Instagram kami">
                <i class="fa fa-instagram"></i>
                <span class="nav-link-inner--text d-lg-none">Instagram</span>
              </a>
            </li>
            <li class="nav-item dropdown d-none d-lg-block">
              <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
                <img src="../img/profil/<?=$globalData['table_user_gambar']?>" alt="Foto Profil" class="img-fluid rounded-circle shadow-lg" style="width: 45px;">
              </a>
              <div class="dropdown-menu">
                <a href="../belakang/index.php" class="dropdown-item">Profile</a>
                <a href="./examples/profile.html" class="dropdown-item">Setting</a>
                <a href="" id="keluar" class="dropdown-item">Keluar</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="position-relative">
      <!-- Hero for FREE version -->
      <section class="section-hero section-shaped my-0">
        <div class="shape shape-style-1 shape-primary">
          <span class="span-150"></span>
          <span class="span-50"></span>
          <span class="span-50"></span>
          <span class="span-75"></span>
          <span class="span-100"></span>
          <span class="span-75"></span>
          <span class="span-50"></span>
          <span class="span-100"></span>
          <span class="span-50"></span>
          <span class="span-100"></span>
        </div>
        <div class="container shape-container d-flex align-items-center">
          <div class="col px-0">
            <div class="row justify-content-center align-items-center">
              <div class="col-lg-7 text-center pt-lg">
                <h1 class="text-lg text-white">Selamat datang di MaratonShop!</h1>
                <p class="lead text-white mt-4 mb-5">Temukan berbagai barang dengan pembelian secara cepat (flash sale)</p>
                <div class="btn-wrapper">
                  <a href="#mulai-belanja" class="btn btn-info btn-lg mb-3 mb-sm-0" data-toggle="scroll">
                    <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                    <span class="btn-inner--text">Mulai Belanja</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <section class="section section-lg section-shaped overflow-hidden my-0" id="mulai-belanja">
      <div class="shape shape-style-1 shape-default shape-skew">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="container py-0 pb-lg">
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-5 mb-5 mb-lg-0">
            <h1 class="text-white font-weight-light">Produk Paling Laris Gaes!</h1>
            <p class="lead text-white mt-4">Segera beli produk-produk paling laris di online shop ini, cepetan keburu habis. Kalo kehabisan belum tentu ada untuk kali kedua loh.</p>
            <a href="#" class="btn btn-info mt-4">Aku Pengen Beli</a>
            <a href="#semua-produk" class="btn btn-white mt-4" data-toggle="scroll">Lihat Produk Lain</a>
          </div>
          <div class="col-lg-6 mb-lg-auto">
            <div class="rounded shadow-lg overflow-hidden transform-perspective-right">
              <div id="carousel_example" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel_example" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel_example" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="./assets/img/theme/img-1-1200x1000.jpg" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="./assets/img/theme/img-2-1200x1000.jpg" alt="Second slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel_example" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel_example" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section section-components pb-0" id="semua-produk">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <!-- Basic elements -->
            <h2 class="mb-5">
              <span>Semua Produk</span>
            </h2>

            <div class="row row-grid">
                <div class="col-lg-4 pb-5">
                  <div class="card card-lift--hover shadow border-0">
                    <div class="card-body py-5">
                      <img class="card-img-top" src=".\assets\img\theme\profile.jpg" alt="Card image cap">
                      <h6 class="text-primary text-uppercase pt-4">SAMBEL KECAP</h6>
                      <p class="description mt-3">Sangat cocok dimakan bersama tahu, tempe ataupun gorengan. Juga cocok dimakan bersama aneka jenis ikan goreng, ayam goreng dan yang semisalnya.</p>
                      <div>
                        <span class="badge badge-pill badge-lg badge-info">Rp. 10.000,-</span>
                        <span class="badge badge-pill badge-danger">Baru</span>
                      </div>
                      <a href="#" class="btn btn-primary mt-4">Saya Beli Deh</a>
                      <a href="#" class="btn btn-warning mt-4">
                        <span class="ni ni-bag-17"></span>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 pb-5">
                  <div class="card card-lift--hover shadow border-0">
                    <div class="card-body py-5">
                      <img class="card-img-top" src=".\assets\img\theme\profile.jpg" alt="Card image cap">
                      <h6 class="text-primary text-uppercase pt-4">SAMBEL KECAP</h6>
                      <p class="description mt-3">Sangat cocok dimakan bersama tahu, tempe ataupun gorengan. Juga cocok dimakan bersama aneka jenis ikan goreng, ayam goreng dan yang semisalnya.</p>
                      <div>
                        <span class="badge badge-pill badge-lg badge-info">Rp. 10.000,-</span>
                        <span class="badge badge-pill badge-danger">Baru</span>
                      </div>
                      <a href="#" class="btn btn-primary mt-4">Saya Beli Deh</a>
                      <a href="#" class="btn btn-warning mt-4">
                          <span class="ni ni-bag-17"></span>
                        </a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 pb-5">
                  <div class="card card-lift--hover shadow border-0">
                    <div class="card-body py-5">
                      <img class="card-img-top" src=".\assets\img\theme\profile.jpg" alt="Card image cap">
                      <h6 class="text-primary text-uppercase pt-4">SAMBEL KECAP</h6>
                      <p class="description mt-3">Sangat cocok dimakan bersama tahu, tempe ataupun gorengan. Juga cocok dimakan bersama aneka jenis ikan goreng, ayam goreng dan yang semisalnya.</p>
                      <div>
                        <span class="badge badge-pill badge-lg badge-info">Rp. 10.000,-</span>
                        <span class="badge badge-pill badge-danger">Baru</span>
                      </div>
                      <a href="#" class="btn btn-primary mt-4">Saya Beli Deh</a>
                      <a href="#" class="btn btn-warning mt-4">
                          <span class="ni ni-bag-17"></span>
                        </a>
                    </div>
                  </div>
                </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Anda Harus Masuk Dulu</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-white pb-5">
                  <div class="text-muted text-center mb-0">
                    <small>Masukan Username dan Password anda</small>
                  </div>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control" id="username" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" id="password" name="password" placeholder="Password" type="password">
                        </div>
                    </div>
                    <div class="custom-control custom-control-alternative custom-checkbox">
                        <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                        <label class="custom-control-label" for=" customCheckLogin">
                        <span>Remember me</span>
                        </label>
                    </div>
                    <div class="text-center">
                        <input type="submit" id="Masuk" name="Masuk" class="btn btn-primary my-4" value="Masuk">
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
    //     if(isset($_GET['Masuk'])){
    //         $loginCek = $admin->login($_GET['username'], $_GET['password']);
            
    //         if($loginCek){
    //             echo "<script>window.location = 'index.php';</script>";
    //         }else{
    //             echo "<script>alert('Masuk Gagal');</script>";
    //         }
    //     }
    //   ?>

  </main>
  <footer class="footer has-cards">
    <div class="container">
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            &copy; 2019
            <a href="https://www.creative-tim.com" target="_blank">CodingMaraton</a> | <a href="https://themewagon.com/">#RMY</a>
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank">MaratonShop</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">Tentang Kami</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- Core -->
  <script src="./assets/vendor/jquery/jquery.min.js"></script>
  <script src="./assets/vendor/popper/popper.min.js"></script>
  <script src="./assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="./assets/vendor/headroom/headroom.min.js"></script>
  <!-- Optional JS -->
  <script src="./assets/vendor/onscreen/onscreen.min.js"></script>
  <script src="./assets/vendor/nouislider/js/nouislider.min.js"></script>
  <script src="./assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Argon JS -->
  <script src="./assets/js/argon.js?v=1.0.0"></script>

  <script>
    <?php
        if($loginModal == true){
    ?>
    $('#loginModal').modal('show');
    <?php
        }else{
    ?>
    $('#loginModal').modal('hide');
    <?php
        }
    ?>
    
    

    $(document).ready(function(){ 
      $('#Masuk').click(function(){  
           var username = $('#username').val();  
           var password = $('#password').val();  
           if(username != '' && password != '')  
           {  
                $.ajax({  
                     url:"../class_php/login.php",  
                     method:"POST",  
                     data: {username:username, password:password},  
                     success:function(data)  
                     {  
                          //alert(data);  
                          if(data == 'No')  
                          {  
                               alert("Data Salah");  
                          }  
                          else  
                          {  
                               $('#loginModal').hide();  
                               location.reload();  
                          }  
                     }  
                });  
           }  
           else  
           {  
                alert("Username dan Password harus diisi");  
           }  
      });  
      
      $('#keluar').click(function(){  
           var aksi = "keluar";  
           $.ajax({  
                url:"../class_php/logout.php",  
                method:"POST",  
                data:{aksi:aksi},  
                success:function()  
                {  
                    $('#loginModal').show();
                    location.reload();  
                }  
           });  
      }); 

    });  
  </script>
</body>

</html>

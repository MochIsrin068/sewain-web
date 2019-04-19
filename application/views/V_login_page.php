<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Design System for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title><?php echo APP_NAME ?></title>
  <!-- Favicon -->
  <link href="<?php echo base_url();?>assets/images/logo/icon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?php echo base_url();?>assets-front/assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets-front/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="<?php echo base_url();?>assets-front/assets/css/argon.css?v=1.0.0" rel="stylesheet">
  <!-- Docs CSS -->
  <link type="text/css" href="<?php echo base_url();?>assets-front/assets/css/docs.min.css" rel="stylesheet">
</head>

<body>
  <header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="../">
            <img src="<?php echo base_url();?>assets/images/logo/icon.png"> <span class="text-brand"><?php echo APP_NAME ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="../">
                <img src="<?php echo base_url();?>assets/images/logo/icon.png"> <span class="text-brand"><?php echo APP_NAME ?></span>
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
        </div>
      </div>
    </nav>
  </header>
  <main>
    <section class="section section-shaped section-lg my-0">
      <div class="shape shape-style-1 bg-gradient-default">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="container pt-lg-md">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card bg-secondary shadow border-0">
              <div class="card-header bg-white ">
                <div class="text-muted text-center ">
                  <small>Sign in </small>
                </div>
                <div class="">
                <?php
                  if($this->session->flashdata('alert')){
                    echo $this->session->flashdata('alert');
                  }
                ?>
                </div>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <?php echo form_open("");?>
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Email" name="identity"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                      <input type="password" class="form-control" placeholder="Password" name="user_password" />
                    </div>
                  </div>
                  <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                    <label class="custom-control-label" for=" customCheckLogin">
                      <span>Remember me</span>
                    </label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary my-4">Sign in</button>
                  </div>
                <?php echo form_close();?>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <a href="#" class="text-light">
                  <small>Forgot password?</small>
                </a>
              </div>
              <div class="col-6 text-right">
                <a href="<?php echo base_url("auth/register");?>" class="text-light">
                  <small>Register</small>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Core -->
  <script src="<?php echo base_url();?>assets-front/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets-front/assets/vendor/popper/popper.min.js"></script>
  <script src="<?php echo base_url();?>assets-front/assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>assets-front/assets/vendor/headroom/headroom.min.js"></script>
  <!-- Argon JS -->
  <script src="<?php echo base_url();?>assets-front/assets/js/argon.js?v=1.0.0"></script>
</body>

</html>
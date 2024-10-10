
<!DOCTYPE html>
<html id="html_login">

  <head>
    <base href="<?= base_url(); ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" property="og:title" content="<?= $name_app ?>">
    <meta name="image" property="og:image" content="assets/images/og-image.webp">
    <meta name="description" property="og:description" content="<?= $deskripsi?>">
    <meta name="author" property="og:author" content="Pejuang Rupiah">
    <link rel="icon" type="image/png" sizes="64x64" href="assets/images/favicon.webp">
    <title><?= $titlehead ?> &mdash; <?= $judul ?></title>
    <link href="assets/css/style.min.css" rel="stylesheet">
    <!-- sweetalert2 - https://sweetalert2.github.io/ -->
    <link href="assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="assets/css/custom.min.css" rel="stylesheet">

    <?php if (isset($view_background_img) && $view_background_img !== '') : ?>
    <style>
      #html_login {
        background-image: url('uploads/situs/<?= $view_background_img ?>') !important;
      }
      #html_login::before {
        background-color: rgba(0, 0, 0, 0) !important;
      }
    </style>
    <?php endif; ?>
  </head>

  <body>    
    <section id="wrapper" class="login-register" style="padding-top:6%;">
      <div class="login-box login-sidebar" style="margin-top:auto !important;">
        <div class="white-box">
          <a href="javascript:void(0)" class="text-center d-block m-b-10">
            <img height="75px" src="assets/images/logo.webp" alt="Home" />
          </a>
          <h4><?= $name_app ?></h4>
          <div id="infoMessage"><?= $message;?></div>

          <?php
            echo form_open("auth/login" , array("class" => "form-horizontal needs-validation form-material m-t-20", 'novalidate' => 'true', "id" => "loginform"));
            $has_error = array(
              'identity' => '',
              'password' => ''
            );
          ?>

            <div class="form-group has-feedback <?= $has_error['identity']; ?>">
              <div class="col-xs-12">
                <input type="text" name="identity" value="" id="identity" class="form-control" placeholder="Username" required autofocus="true" style="border-radius: 10px" />
                <div class="invalid-feedback">
                    Username tidak valid
                </div>
              </div>
            </div>

            <div class="form-group has-feedback <?= $has_error['password']; ?>">
              <div class="col-xs-12 position-relative">
                <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" required style="border-radius: 10px" />
                <span class="toggle-password fa fa-eye f-s-16"></span>
                <div class="invalid-feedback">
                    Password tidak valid
                </div>
              </div>
            </div>
            <div class="numcha-wrapper">
              <div class="numcha-nums">
                <div class="numcha-container">
                  <span id="numcha-num-1" class="numcha-num">&nbsp;</span>
                  <span id="numcha-num-2" class="numcha-num">&nbsp;</span>
                  <span id="numcha-num-3" class="numcha-num">&nbsp;</span>
                  <span id="numcha-num-4" class="numcha-num">&nbsp;</span>
                </div>
                <button type="button" class="numcha-refresh btn btn-sm" tabindex="-1"><i class="fa fa-sync text-secondary"></i></button>
              </div>
              <input type="text" name="numcha-input" id="numcha-input" placeholder="Ketikkan kode captcha" class="form-control" maxlength="4" minlength="4" pattern="^[0-9]*$" required>
              <div class="invalid-feedback">
                  Kode captcha tidak valid
              </div>
            </div>
            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button id="btnSubmit" class="btn btn-primary w-100 btn-block text-uppercase waves-effect waves-light text-white" type="submit">Login
                </button>
                <div class="text-start m-t-10">
                Belum mempunyai akun ? <a class="text-info" href="register">Daftar disini</a>
                </div>
              </div>
            </div>
          <?= form_close(); ?>
          <p class="m-b-0"><a href="forgot_password">Lupa Password ?</a></p>
        </div>
      </div>

      <div class="login-footer"><?= $foot ?></div>
    </section>

    <script>
      const BASE_URL = '<?= base_url(); ?>';
    </script>
    <script src="assets/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/script.min.js"></script>
    <script src="assets/node_modules/toastr/build/toastr.min.js"></script>
    <script src="assets/node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/node_modules/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js"></script>
    <script src="assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
      numchaGenerate();
    </script>
  </body>

</html>

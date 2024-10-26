
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
    <link rel="icon" type="image/png" sizes="64x64" href="assets/images/favicon.png">
    <title>Register &mdash; <?= $judul ?></title>
    <link href="assets/css/style.min.css" rel="stylesheet">
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
    <section id="wrapper" class="login-register" style="padding-top:7%;">
      <div class="login-box login-sidebar" style="margin-top:auto !important;">
        <div class="white-box">
         
          <h4 class="text-center"><?= $titlehead ?></h4>
          
          <?php if (isset($_SESSION['message'])) { ?>
              <script type="text/javascript">
                  window.setTimeout(function () {
                      $(".alert").alert('close');
                  }, 5000);
              </script>
              <div class="alert alert-info alert-dismissable">
                  <?php echo $_SESSION['message']; ?>
              </div>
          <?php } ?>
          <?php if (isset($_SESSION['err'])) { ?>
              <div class="alert alert-danger alert-dismissable">
                  <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
              </div>
          <?php } ?>

          <?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal needs-validation form-material m-t-20', 'novalidate' => 'true')); ?>

            <div class="form-group has-feedback">
              <div class="col-xs-12">
                <input type="text" name="full_name" value="<?= (isset($_SESSION['full_name']))? $_SESSION['full_name'] : '' ?>" id="full_name" class="form-control" placeholder="Nama Lengkap*" autofocus="true" required />
                <div class="invalid-feedback">
                    Nama Lengkap tidak valid
                </div>
              </div>
            </div>
            
            <div class="form-group has-feedback">
              <div class="col-xs-12">
                <input type="email" name="email" value="<?= (isset($_SESSION['email']))? $_SESSION['email'] : '' ?>" id="email" class="form-control" placeholder="Email*" required />
                <div class="invalid-feedback">
                    Email tidak valid
                </div>
              </div>
            </div>

            <div class="form-group has-feedback">
              <div class="col-xs-12">
                <input type="text" name="username" value="<?= (isset($_SESSION['username']))? $_SESSION['username'] : '' ?>" id="username" class="form-control" placeholder="Username*" required />
                <div class="invalid-feedback">
                    Username tidak valid
                </div>
              </div>
            </div>

            <div class="form-group has-feedback">
              <div class="col-xs-12 position-relative">
                <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password*" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" />
                <span class="toggle-password fa fa-eye f-s-16"></span>
                <small>Min. 8 karakter, terdiri dari kombinasi huruf kecil, huruf kapital, simbol, dan angka</small>
                <div class="invalid-feedback">
                    Password tidak valid
                </div>
              </div>
            </div>

            <div class="form-group has-feedback">
              <div class="col-xs-12 position-relative">
                <input type="password" name="password_confirm" value="" id="password_confirm" class="form-control" placeholder="Konfirmasi Password*" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" />
                <span class="toggle-password fa fa-eye f-s-16"></span>
                <div class="invalid-feedback">
                    Konfirmasi Password tidak valid
                </div>
              </div>
            </div>
            
            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button class="btn btn-primary w-100 btn-block text-uppercase waves-effect waves-light text-white" type="submit">Register
                </button>
              </div>
            </div>
            
          <?php echo form_close(); ?>
          <p><a href="auth/login"><i class="fa fa-arrow-left"></i>&nbsp; Kembali ke halaman Login</a></p>
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
    <script src="assets/js/custom.js"></script>
  </body>

</html>

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
    <title>Reset Password &mdash; <?= $judul ?></title>
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
    <section id="wrapper" class="login-register" style="padding-top:10%;">
      <div class="login-box login-sidebar" style="margin-top:auto !important;">
        <div class="white-box">
		  <h4><?php echo lang('Auth.reset_password_heading');?></h4>

          <div id="infoMessage"><?php echo $message;?></div>
          
          <?php
            echo form_open("auth/reset_password/".$code , array("class" => "form-horizontal needs-validation form-material m-t-20", 'novalidate' => 'true'));
          ?>

            <div class="form-group">
              <div class="col-xs-12 position-relative">
                <input type="password" name="new" value="" id="new" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" class="form-control" placeholder="<?php echo sprintf(lang('Auth.reset_password_new_password_label'), $minPasswordLength);?>" autofocus="true" required />
                <span class="toggle-password fa fa-eye f-s-16"></span>
                <small>Min. 8 karakter, terdiri dari kombinasi huruf kecil, huruf kapital, simbol, dan angka</small>
                <div class="invalid-feedback">
                    Password tidak valid
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 position-relative">
                <input type="password" name="new_confirm" value="" id="new_confirm" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" class="form-control" placeholder="<?php echo sprintf(lang('Auth.reset_password_new_password_confirm_label'), 'new_password_confirm')?>" autofocus="true" required />
                <span class="toggle-password fa fa-eye f-s-16"></span>
                <div class="invalid-feedback">
                    Konfirmasi Password tidak valid
                </div>
              </div>
            </div>

			<?php echo form_input($user_id);?>

            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button class="btn btn-primary w-100 btn-block text-uppercase waves-effect waves-light text-white" type="submit">Submit
                </button>
              </div>
            </div>

          <?php echo form_close(); ?>
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

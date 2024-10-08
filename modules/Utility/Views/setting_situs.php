<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">

    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $titlehead ?></h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Utilitas</a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12 mb-3">
              <div class="row form-group">
                <div class="col-sm-2">
                  <i class="fa fa-info-circle"></i> <i><b>(*)</b> wajib diisi !</i>
                  <div class="clearfix"></div>
                </div>
              </div>
              <?php echo form_open_multipart(current_url()."/save", array('class' => 'form-horizontal needs-validation', 'novalidate' => 'true')); ?>
              <?php
                $input = array(
                    'class' => 'form-control'
                );

                $label = array(
                    'class' => 'control-label text-start text-md-end col-sm-2 col-form-label'
                );

                $label_d = array(
                    'class' => 'control-label text-start text-md-end col-sm-3 col-form-label'
                );
              ?>
              <?php if (isset($_SESSION['message'])) { ?>
                  <script type="text/javascript">
                      window.setTimeout(function () {
                          $(".alert").alert('close');
                      }, 3000);
                  </script>
                  <div class="alert alert-success">
                      <?php echo $_SESSION['message']; ?>
                  </div>
              <?php } ?>
              <?php if (isset($_SESSION['err'])) { ?>
                  <script type="text/javascript">
                      window.setTimeout(function () {
                          $(".alert").alert('close');
                      }, 5000);
                  </script>
                  <div class="alert alert-danger">
                      <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
                  </div>
              <?php } ?>
              <div class="x_content">
                  <div class="row">
                          <div class="row form-group">
                            <?php echo form_label('Nama App*', 'input_name_app', $label) ?>
                            <div class="col-sm-9">
                              <?php
                              echo form_input($input_name_app);
                              ?>
                              <div class="invalid-feedback">
                                Name App tidak valid
                              </div>
                            </div>
                          </div>

                          <div class="row form-group">
                            <?php echo form_label('Deskripsi App*', 'description', $label) ?>
                            <div class="col-sm-9">
                              <?php
                              echo form_textarea($description);
                              ?>
                              <div class="invalid-feedback">
                                Deskripsi App tidak valid
                              </div>
                            </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('Site Title*', 'title', $label) ?>
                              <div class="col-sm-9">
                                  <?php
                                  echo form_input($title);
                                  ?>
                                  <div class="invalid-feedback">
                                    Site Title tidak valid
                                  </div>
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('Footer*', 'footer', $label) ?>
                              <div class="col-sm-9">
                                  <?php
                                  echo form_input($footer);
                                  ?>
                                  <div class="invalid-feedback">
                                    Footer tidak valid
                                  </div>
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('Logo', 'file_id_logo', $label) ?>
                              <div class="col-sm-9">
                                  <?php
                                  echo form_upload($file_id_logo);
                                  ?>
                                  <small class="form-text">Tipe file *.webp, *.jpg atau *.png, ukuran maks. 500 KB</small>
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('','',$label) ?>
                              <div class="col-sm-9">
                                <img height="60px" class="rounded-circle" src="uploads/situs/<?= $view_logo; ?>">
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('Logo Text', 'file_id_logo_text', $label) ?>
                              <div class="col-sm-9">
                                  <?php
                                  echo form_upload($file_id_logo_text);
                                  ?>
                                  <small class="form-text">Tipe file *.webp, *.jpg atau *.png, ukuran maks. 500 KB</small>
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('','',$label) ?>
                              <div class="col-sm-9">
                                <img width="130px" class="img-thumbnail logo-text" src="uploads/situs/<?= $view_logo_text; ?>">
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('Login Background', 'file_id_background_img', $label) ?>
                              <div class="col-sm-9">
                                  <?php
                                  echo form_upload($file_id_background_img);
                                  ?>
                                  <small class="form-text">Tipe file *.webp, *.jpg atau *.png, ukuran maks. 500 KB</small>
                              </div>
                          </div>

                          <div class="row form-group">
                              <?php echo form_label('','',$label) ?>
                              <div class="col-sm-9">
                                <img width="260px" class="img-thumbnail" src="uploads/situs/<?= $view_background_img; ?>">
                              </div>
                          </div>

                          <div class="row form-group form-group-light-color">
                              <?php echo form_label('Warna Utama', 'theme_primary_color', $label) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_primary_color);
                                  ?>
                              </div>
                              <?php echo form_label('Warna Header Tabel', 'theme_bg_thead_color', $label_d) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_bg_thead_color);
                                  ?>
                              </div>
                          </div>

                          <div class="row form-group form-group-light-color">
                              <?php echo form_label('Warna Aksen', 'theme_accent_color', $label) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_accent_color);
                                  ?>
                              </div>
                              <?php echo form_label('Warna Text Header Tabel', 'theme_text_thead_color', $label_d) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_text_thead_color);
                                  ?>
                              </div>
                          </div>

                          <div class="row form-group form-group-dark-color">
                              <?php echo form_label('Warna Utama (Dark)', 'theme_primary_dark_color', $label) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_primary_dark_color);
                                  ?>
                              </div>
                              <?php echo form_label('Warna Header Tabel (Dark)', 'theme_bg_thead_dark_color', $label_d) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_bg_thead_dark_color);
                                  ?>
                              </div>
                          </div>

                          <div class="row form-group form-group-dark-color">
                              <?php echo form_label('Warna Aksen (Dark)', 'theme_accent_dark_color', $label) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_accent_dark_color);
                                  ?>
                              </div>
                              <?php echo form_label('Warna Text Header Tabel (Dark)', 'theme_text_thead_dark_color', $label_d) ?>
                              <div class="col-sm-3">
                                  <?php
                                  echo form_input($theme_text_thead_dark_color);
                                  ?>
                              </div>
                          </div>

                          <div class="form-group row">
                            <label class="control-label text-start text-md-end col-md-2">Warna Tema Default</label>
                            <div class="col-md-9">
                              <button type="button" id="reset_color" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset ke warna tema default"><i class="fa fa-fw fa-history"></i></button>
                            </div>
                          </div>
                      </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-10 offset-sm-2">
                      <button id="submit" type="submit" class='btn btn-success pull-left'>
                          <span class="fa fa-save"></span> Simpan
                      </button>
                    </div>
                  </div>
              </div>
              <?php echo form_hidden('file_id_logo_old',$file_id_logo_old); ?>
              <?php echo form_hidden('file_id_logo_text_old',$file_id_logo_text_old); ?>
              <?php echo form_hidden('file_id_background_img_old',$file_id_background_img_old); ?>
              <?php echo form_hidden('id',$situs_id_edit); ?>
              <?php echo form_hidden($csrf); ?>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?= $this->endSection('content'); ?>
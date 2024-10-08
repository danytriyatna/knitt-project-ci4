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
            <li class="breadcrumb-item"><a href="./"><?= $name_app ?></a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="row form-group">
                  <div class="col-sm-2">
                  <i class="fa fa-info-circle"></i> <i><b>(*)</b> wajib diisi !</i>
                  <div class="clearfix"></div>
                  </label>
                  </div>
                </div>
                  <?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal needs-validation', 'novalidate' => 'true'));
                    $input = array('class' => 'form-control');
                    $label = array('class' => 'control-label text-start text-md-end col-sm-2 col-form-label');
                  ?>

                  <?php if (isset($_SESSION['message'])) { ?>
                      <script type="text/javascript">
                          window.setTimeout(function () {
                              $(".alert").alert('close');
                          }, 3000);
                      </script>
                      <div class="alert alert-info alert-dismissable">
                          <?php echo $_SESSION['message']; ?>
                      </div>
                  <?php } ?>
                  <?php if (isset($_SESSION['err'])) { ?>
                      <script type="text/javascript">
                          window.setTimeout(function () {
                              $(".alert").alert('close');
                          }, 5000);
                      </script>
                      <div class="alert alert-danger alert-dismissable">
                          <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
                      </div>
                  <?php } ?>

                  <div class="row">
                    <div class="col-md-12">
                      <?= csrf_field() ?>
                      
                      <div class="row form-group">
                          <?php echo form_label('Nama Lengkap*', 'full_name', $label) ?>
                          <div class="col-sm-8">
                              <?php
                              echo form_input($full_name);
                              ?>
                              <div class="invalid-feedback">
                                Nama Lengkap tidak valid
                              </div>
                          </div>
                      </div>

                      <div class="row form-group">
                          <?php echo form_label('Username*', 'username', $label) ?>
                          <div class="col-sm-8">
                              <?php
                              echo form_input($username);
                              ?>
                          </div>
                      </div>

                      <div class="row form-group">
                          <?php echo form_label('Email*', 'email', $label) ?>
                          <div class="col-sm-8">
                              <?php
                              echo form_input($email);
                              ?>
                          </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                        <button id="submit" type="submit" class='btn btn-success'>
                            <span class="fa fa-save"></span> Simpan
                        </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<?= $this->endSection('script'); ?>
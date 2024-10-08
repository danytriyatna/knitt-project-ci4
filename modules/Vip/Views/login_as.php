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
            <li class="breadcrumb-item"><a href="./">Go to</a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row form-group">
                  <div class="col-sm-6">
                  <i class="fa fa-info-circle"></i> <i><b>(*)</b> wajib diisi !</i>
                  </div>
                </div>
                <form name="form_login_as" id="form_login_as" class="form-horizontal needs-validation" action="" method="post" accept-charset="utf-8" novalidate="true">
                    <?= csrf_field() ?>
                    <div class="form-body">
                        <div class="form-group row">
                        <label class="control-label text-start text-md-end col-md-2" for="role_id">Role*</label>
                        <div class="col-md-9">
                            <select id="role_id" name="role_id" class="form-select select2" data-placeholder="-- Pilih Role --" required>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role->id ?>" ><?= $role->description ?></option>
                            <?php endforeach ?>
                            </select>
                            <script>
                                document.getElementById("role_id").value = null;
                            </script>
        										<div class='invalid-feedback'>
                              Harap pilih Role
                            </div>  
                        </div>
                        </div>
                        <div class="form-group row">
                        <label class="control-label text-start text-md-end col-md-2" for="user_id">User*</label>
                        <div class="col-md-9">
                            <select id="user_id" name="user_id" class="form-select select2" data-placeholder="-- Pilih User --" required>
                            </select>
                            <script>
                                document.getElementById("user_id").value = null;
                            </script>
        										<div class='invalid-feedback'>
                              Harap pilih User
                            </div>  
                        </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                            <div class="offset-sm-2 col-md-9">
                              <button id="btn_ambil_alih" class="m-s-5 btn btn-success">Submit</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="script/vip/login_as.js"></script>
<?= $this->endSection('script'); ?>
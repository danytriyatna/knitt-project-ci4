<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>

      <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
          <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"><?= $titlehead ?></h4>
          </div>
          <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><?= $name_app ?></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active"><?= $titlehead ?></li>
              </ol>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
              <form action="<?= base_url().'/'.uri_string(); ?>" id="fmain" method="post" enctype='multipart/form-data' class="form-horizontal">
                  <div class="form-body">

                    <?php if (isset($message) && $message != "") { ?>
                        <?php echo (isset($message) && $message != "") ? $message : ""; ?>
                    <?php } ?>
                    <?php if (isset($errmsg) && $errmsg != "") { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true" type="button">
                                x
                            </button>
                            <?php echo (isset($errmsg) && $errmsg != "") ? $errmsg : ""; ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                      <div class="col-md-6">

                        <div class="form-group row">
                          <label class="control-label text-start text-md-end col-md-4" for="parent_id">Parent Akun Beban</label>
                          <div class="col-md-8">
                            <?= (isset($parent_id) && !empty($parent_id)) ? form_dropdown($parent_id) : ""; ?>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="control-label text-start text-md-end col-md-4" for="kode">Nomor Akun Beban</label>
                          <div class="col-md-8">
                            <?= (isset($kode) && !empty($kode)) ? form_input($kode) : ""; ?>
                          </div>
                        </div>


                        <div class="form-group row">
                          <label class="control-label text-start text-md-end col-md-4" for="nama">Nama Akun Beban</label>
                          <div class="col-md-8">
                            <?= (isset($nama) && !empty($nama)) ? form_input($nama) : ""; ?>
                          </div>
                        </div>

                        
                        <div hidden class="form-group row">
                          <label class="control-label text-start text-md-end col-md-4" for="position">position</label>
                          <div class="col-md-8">
                            <?= (isset($position) && !empty($position)) ? form_dropdown($position) : ""; ?>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-6">
                        &nbsp;
                      </div>
                    </div>

                  </div>
                  <div class="form-actions m-t-30">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="offset-sm-2 col-md-9">
                          <?php echo isset($id) ? form_hidden('id', $id) : ""; ?>
                            <a href="<?= base_url(); ?>/keuangan/daftar_akun" class="btn btn-secondary" ><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button id="btn-save" type="submit" class="m-s-5 btn btn-success"> <i class="fa fa-save"></i> Simpan</button>
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
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
      </div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="/script/app/keuangan/daftar_akun/form.js"></script>
<?= $this->endSection('script'); ?>

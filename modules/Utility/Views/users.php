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
            <div class="row">
              <div class="col-md-12 mb-3">
                <?php if (isset($_SESSION['message'])) { ?>
                    <script type="text/javascript">
                        window.setTimeout(function () {
                            $(".alert").alert('close');
                        }, 3000);
                    </script>
                    <div class="alert alert-success">
                        <strong><b>Info! </b><br></strong><?php echo $_SESSION['message']; ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['err'])) { ?>
                    <script type="text/javascript">
                        window.setTimeout(function () {
                            $(".alert").alert('close');
                        }, 5000);
                    </script>
                    <div class="alert alert-error">
                        <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
                    </div>
                <?php } ?>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group m-b-0">
                      <label class="control-label text-start text-md-end" for="filter_role">Role</label>
                      <select id="filter_role" name="filter_role" class="form-control custom-select select2">
                        <option value="">- Pilih Role -</option>
                          <?php foreach ($list_roles as $r) : ?>
                            <option value="<?= $r->id ?>"><?= $r->description ?></option>
                          <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group m-b-0">
                      <label class="control-label text-start text-md-end" for="filter_status">Status Aktif</label>
                      <select id="filter_status" name="filter_status" class="form-control custom-select select2">
                        <option value="">- Pilih Status -</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-3 align-self-end">
                    <button type="button" id="btn-tampilkan" class="btn btn-primary" title="Filter"><i class="fa fa-filter"></i>&nbsp; Filter</button>
                    <button type="button" id="btn-reset" class="btn btn-secondary m-s-5" title="Reset Filter"><i class="fa fa-history"></i>&nbsp; Reset Filter</button>
                  </div>
                </div><hr>
                <a href="utilitas/users/add" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah User</a>
                <div class="col-md-3" style="float: right; position: relative; right: 15px;">
                    <div class="homeSearch w-100" style="width: 100%; margin-left: 5%; margin-top: 0;">
                        <input type="text" id="tb-search" class="form-control" placeholder="Search . . .">
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="dt-list" class="table-responsive table-striped"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/user/index.js"></script>
<?= $this->endSection('script'); ?>

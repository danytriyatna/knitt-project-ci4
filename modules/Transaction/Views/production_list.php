<?= $this->extend('template'); ?>

<?= $this->section('modal') ?>

<?= $this->endSection('modal') ?>

<?= $this->section('content'); ?>

<div class="container-fluid">

  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor"><?= $titlehead ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><?= $name_app ?></li>
          <li class="breadcrumb-item">Transaksi</li>
          <li class="breadcrumb-item active"><?= $titlehead ?></li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group m-b-0 d-flex align-items-center">
                <label class="control-label text-start text-md-end m-e-8" for="filter_status">Status</label>
                <select id="filter_status" name="filter_status" class="form-control custom-select select2">
                  <option value="0">All</option>
                  <option value="1">Draft</option>
                  <option value="2">Process</option>
                  <option value="3">Done</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="table-responsive">
            <div class="table-responsive">
              <div class="table-striped" id="dt-list"> </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/app/transaction/production/index.js"></script>
<?= $this->endSection('script'); ?>
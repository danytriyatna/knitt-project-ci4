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
            <div class="col-sm-7">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="trans_no">Trans No.</label>
                    <div class="col-md-9">
                      <input type="text" id="trans_no" name="trans_no" class="form-control" placeholder="Diisi otomatis oleh sistem" value="" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="tanggal">Date</label>
                    <div class="col-md-8">
                      <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Pilih tanggal transfer" value="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="select_warehouse">Transfer From</label>
                    <div class="col-md-8">
                      <select id="gudang_asal" name="gudang_asal" class="form-select select2" data-placeholder="-- Pilih Warehouse --">
                        <option value="1" selected>Warehouse 1</option>
                        <option value="2">Warehouse 2</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="gudang_tujuan">Transfer To</label>
                    <div class="col-md-8">
                      <select id="gudang_tujuan" name="gudang_tujuan" class="form-select select2" data-placeholder="-- Pilih Warehouse --">
                        <option value="1">Warehouse 1</option>
                        <option value="2" selected>Warehouse 2</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="offset-sm-6 col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="select_cmt">CMT</label>
                    <div class="col-md-8">
                      <select id="select_cmt" name="select_cmt" class="form-select select2" data-placeholder="-- Pilih CMT --">
                        <option value="1">CMT 1</option>
                        <option value="2" selected>CMT 2</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="trans_desc">Desc</label>
                <div class="col-md-10">
                  <textarea rows="3" id="trans_desc" name="trans_desc" class="form-control" placeholder="Ketikkan uraian deskripsi"></textarea>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-sm-12">
              <p><i>(Section select SO)</i></p>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-sm-12">
              <p><i>(Section select item)</i></p>
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
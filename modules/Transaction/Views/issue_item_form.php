<?= $this->extend('template'); ?>

<?= $this->section('modal') ?>
<div id="modal-detail-item" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Detail Item</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="select_item">Item</label>
          <div class="col-md-9">
            <select id="select_item" name="select_item" class="form-select select2" data-placeholder="-- Pilih Item --">
              <option value="1">W-001 WHITE NEW 001</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="select_unit">Unit</label>
          <div class="col-md-9">
            <input type="text" id="select_unit" name="select_unit" class="form-control" placeholder="Terisi otomatis oleh sistem" value="KGM" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="qty_item">Qty</label>
          <div class="col-md-9">
            <input type="text" id="qty_item" name="qty_item" class="form-control" placeholder="Ketikkan qty item" value="100">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="lot_no">Lot No.</label>
          <div class="col-md-9">
            <input type="text" id="lot_no" name="lot_no" class="form-control" placeholder="Ketikkan nomor lot" value="6458765432">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
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
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="gi_no">GI No.</label>
                    <div class="col-md-9">
                      <input type="text" id="gi_no" name="gi_no" class="form-control" placeholder="Ketikkan GI No." value="GIC24100001">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="gi_date">GI Date</label>
                    <div class="col-md-8">
                      <input type="text" id="gi_date" name="gi_date" class="form-control datepicker" placeholder="Pilih tanggal GI" value="01 November 2024">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-2 col-form-label custom-col-md-2" for="select_gudang">Gudang</label>
                    <div class="col-md-10">
                      <select id="select_gudang" name="select_gudang" class="form-select select2" data-placeholder="-- Pilih Gudang --">
                        <option value="1" selected>GUDANG UTAMA</option>
                        <option value="2">GUDANG PRODUKSI</option>
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
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="min-width: 95px; width: 95px;">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail-item"><i class="fa fa-plus"></i></button>
                      </th>
                      <th>ITEM CODE</th>
                      <th>ITEM DESCRIPTION</th>
                      <th>AVAILABLE STOCK</th>
                      <th>QTY</th>
                      <th>UNIT</th>
                      <th>LOT NO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail-item"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                      </td>
                      <td>W-001</td>
                      <td>WHITE NEW 001</td>
                      <td>300</td>
                      <td>100</td>
                      <td>KGM</td>
                      <td>6458765432</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/issue-item" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="trans/issue-item" class='btn btn-success'>
                    <span class="fa fa-save"></span> Simpan
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>
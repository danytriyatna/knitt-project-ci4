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
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="unit_price">Unit Price</label>
          <div class="col-md-9">
            <input type="text" id="unit_price" name="unit_price" class="form-control form-idr" placeholder="Ketikkan unit price" value="300000">
            <small class="form-text">Hanya menerima input berupa angka, penulisan koma bisa menggunakan titik ( . ), contoh: 100000.50, 8500.99</small>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="disc_item">Disc (%)</label>
          <div class="col-md-5">
            <input type="text" id="disc_item" name="disc_item" class="form-control" placeholder="Ketikkan nilai diskon" value="0">
          </div>
          <div class="col-md-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check_tax" checked>
              <label class="form-check-label" for="check_tax">
                Tax
              </label>
            </div>
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
          <li class="breadcrumb-item">Pembelian</li>
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
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_no">PO No.</label>
                    <div class="col-md-9">
                      <input type="text" id="po_no" name="po_no" class="form-control" placeholder="Ketikkan nomor PO" value="POD2410001">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="tgl_po">PO Date</label>
                    <div class="col-md-8">
                      <input type="text" id="tgl_po" name="tgl_po" class="form-control datepicker" placeholder="Pilih tanggal PO" value="01 November 2024">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tgl_expected"><span class="text-nowrap">Expected</span><br>Date</label>
                    <div class="col-md-9">
                      <input type="text" id="tgl_expected" name="tgl_expected" class="form-control datepicker" placeholder="Pilih expected date" value="01 November 2024">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="select_term">Term</label>
                    <div class="col-md-8">
                      <select id="select_term" name="select_term" class="form-select select2" data-placeholder="-- Pilih Term --">
                        <option value="1" selected>7 Days</option>
                        <option value="2">14 Days</option>
                        <option value="3">21 Days</option>
                        <option value="4">30 Days</option>
                        <option value="5">60 Days</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="select_vendor">Vendor</label>
                <div class="col-md-10">
                  <select id="select_vendor" name="select_vendor" class="form-select select2" data-placeholder="-- Pilih Vendor --">
                    <option value="1" selected>Vedor Citraknitt 01</option>
                    <option value="2">Vedor Citraknitt 02</option>
                    <option value="3">Vedor Citraknitt 03</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="ship_to">Ship To</label>
                <div class="col-md-10">
                  <textarea rows="3" id="ship_to" name="ship_to" class="form-control" placeholder="Ketikkan uraian pengiriman"></textarea>
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
                      <th>QTY</th>
                      <th>UNIT</th>
                      <th>UNIT PRICE</th>
                      <th>DISC (%)</th>
                      <th>TAX (%)</th>
                      <th>AMOUNT</th>
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
                      <td>100</td>
                      <td>KGM</td>
                      <td class="text-nowrap text-end">300.000,00</td>
                      <td></td>
                      <td></td>
                      <td class="text-nowrap text-end">1.800.000,00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="purchasing/purchase-order" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="purchasing/purchase-order" class='btn btn-success'>
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
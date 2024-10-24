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
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="do_no">DO No.</label>
                    <div class="col-md-9">
                      <input type="text" id="do_no" name="do_no" class="form-control" placeholder="Ketikkan nomor DO" value="DOD2410001">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="so_no">SO NO.</label>
                    <div class="col-md-9">
                      <select id="so_no" name="so_no" class="form-select select2" data-placeholder="-- Pilih nomor SO --">
                        <option value="1">SOD2410001</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tgl_do">DO Date</label>
                    <div class="col-md-9">
                      <input type="text" id="tgl_do" name="tgl_do" class="form-control datepicker" placeholder="Pilih tanggal DO" value="01 Oktober 2024">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-2 col-form-label custom-col-md-2" for="select_style">Style</label>
                    <div class="col-md-10">
                      <select id="select_style" name="select_style" class="form-select select2" data-placeholder="-- Pilih Style --" disabled>
                        <option value="1">K-17 (CARDIGAN PITA)</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="select_buyer">Buyer</label>
                <div class="col-md-9">
                  <select id="select_buyer" name="select_buyer" class="form-select select2" data-placeholder="-- Pilih Buyer --" disabled>
                    <option value="1">Yusuf</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="alamat_buyer">Alamat</label>
                <div class="col-md-9">
                  <textarea rows="3" id="alamat_buyer" name="alamat_buyer" class="form-control" placeholder="Ketikkan alamat" disabled>Bandung</textarea>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-striped table-centered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>COLOUR</th>
                      <th style="min-width: 80px;">S</th>
                      <th style="min-width: 80px;">M</th>
                      <th style="min-width: 80px;">L</th>
                      <th style="min-width: 80px;">XL</th>
                      <th style="min-width: 80px;">2XL</th>
                      <th style="min-width: 80px;">ALL</th>
                      <th rowspan="2">ORDER QTY</th>
                      <th rowspan="2">DO QTY</th>
                      <th rowspan="2">REMAIN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td class="text-nowrap">M38 - MINT- HITAM- OFF WHITE</td>
                      <td>1511</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>1511</td>
                      <td>36</td>
                      <td>1475</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          <br>

          <div class="row">
            <div class="col-sm-12">
              <div class="input-group my-2">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-qrcode"></i></span>
                <input type="text" class="form-control bg-info bg-opacity-25" placeholder="Scan" aria-label="Scan" aria-describedby="basic-addon1" disabled>
              </div>

              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>DATE</th>
                      <th>COLOUR</th>
                      <th>SIZE</th>
                      <th>AVAILABLE QTY</th>
                      <th>DO QTY</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
                      </td>
                      <td>01-10-2024</td>
                      <td>M38 - MINT- HITAM- OFF WHITE</td>
                      <td>M</td>
                      <td>12</td>
                      <td>
                        <input type="text" class="form-control" value="12">
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
                      </td>
                      <td>05-10-2024</td>
                      <td>M38 - MINT- HITAM- OFF WHITE</td>
                      <td>M</td>
                      <td>24</td>
                      <td>
                        <input type="text" class="form-control" value="24">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/delivery-order" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="trans/delivery-order" class='btn btn-success'>
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
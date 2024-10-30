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
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="cr_no">CR No.</label>
                    <div class="col-md-9">
                      <input type="text" id="cr_no" name="cr_no" class="form-control" placeholder="Ketikkan nomor CR" value="CRC2410001">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="tgl_cr">CR Date</label>
                    <div class="col-md-8">
                      <input type="text" id="tgl_cr" name="tgl_cr" class="form-control datepicker" placeholder="Pilih tanggal CR" value="01 Oktober 2024">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-2 col-form-label custom-col-md-2" for="select_buyer">Buyer</label>
                    <div class="col-md-10">
                      <select id="select_buyer" name="select_buyer" class="form-select select2" data-placeholder="-- Pilih Buyer --">
                        <option value="1">Yusuf</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="select_payment_type">Payment Type</label>
                <div class="col-md-9">
                  <select id="select_payment_type" name="select_payment_type" class="form-select select2" data-placeholder="-- Pilih Payment Type --">
                    <option value="1">BCA 0000000000 CITRAKNIT</option>
                  </select>
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
                      <th>SI NO.</th>
                      <th>SI DATE</th>
                      <th>DUE DATE</th>
                      <th>INV. AMOUNT</th>
                      <th>PAID</th>
                      <th>REMAINING AMOUNT</th>
                      <th>PAYMENT AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>SIV24100001</td>
                      <td>01-10-2024</td>
                      <td>31-10-2024</td>
                      <td class="text-nowrap">1.800.000,00</td>
                      <td class="text-nowrap">0,00</td>
                      <td class="text-nowrap">1.800.000,00</td>
                      <td>
                        <input type="text" class="form-control form-idr" value="1800000">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/customer-receipt" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="trans/customer-receipt" class='btn btn-success'>
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
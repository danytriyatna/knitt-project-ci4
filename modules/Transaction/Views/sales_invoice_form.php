<?= $this->extend('template'); ?>

<?= $this->section('modal') ?>
<div id="modal-view-detail-do" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Detail Deliver Order</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group my-0 row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label">SO. No.</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control-plaintext" value="SOD24100001" disabled>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group my-0 row">
                  <label class="control-label text-start text-md-end col-md-4 col-form-label">SO. Date</label>
                  <div class="col-md-8">
                    <input type="text" class="form-control-plaintext" value="01-10-2024" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group my-0 row">
                  <label class="control-label text-start text-md-end col-md-2 custom-col-md-2 col-form-label">Buyer</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control-plaintext" value="Yusuf" disabled>
                  </div>
                </div>
                <div class="form-group my-0 row">
                  <label class="control-label text-start text-md-end col-md-2 custom-col-md-2 col-form-label">Style</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control-plaintext" value="K-17 (CARDIGAN PITA)" disabled>
                  </div>
                </div>
                <div class="form-group my-0 row">
                  <label class="control-label text-start text-md-end col-md-2 custom-col-md-2 col-form-label">Desc</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control-plaintext" value="K-17 (CARDIGAN PITA)" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group my-0 row">
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
                    <th>DO NO.</th>
                    <th>DO DATE</th>
                    <th>COLOUR</th>
                    <th style="min-width: 80px;">S</th>
                    <th style="min-width: 80px;">M</th>
                    <th style="min-width: 80px;">L</th>
                    <th style="min-width: 80px;">XL</th>
                    <th style="min-width: 80px;">2XL</th>
                    <th style="min-width: 80px;">ALL</th>
                    <th rowspan="2">DO QTY</th>
                    <th rowspan="2">AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>DOD24100001</td>
                    <td>01-10-2024</td>
                    <td class="text-nowrap">M38</td>
                    <td></td>
                    <td>1511</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>36</td>
                    <td>4.500.000,00</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="m-s-5 btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="si_no">SI No.</label>
                    <div class="col-md-9">
                      <input type="text" id="si_no" name="si_no" class="form-control" placeholder="Ketikkan nomor SI" value="<?= !empty($row) ? $row->kode_invoice : ""; ?>">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="tgl_si">SI Date</label>
                    <div class="col-md-8">
                      <input type="text" id="tgl_si" name="tgl_si" class="form-control datepicker" placeholder="Pilih tanggal SI" value="<?= !empty($row) ? $row->tgl_transaksi : ""; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-3 col-form-label" for="select_buyer">Buyer</label>
                    <div class="col-md-9">
                      <select id="select_buyer" name="select_buyer" value="<?= !empty($row) ? $row->konsumen_id : ""; ?>" class="form-select select2" data-placeholder="-- Pilih Buyer --">
                        <option value=""> - Pilih Buyer - </option>
                        <?php foreach ($buyer as $item) { ?>
                          <option value="<?= $item['id']; ?>"><?= $item['nama']; ?></option> 
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <!-- <div class="form-group row">
                    <label class="control-label text-start text-md-end col-md-4 col-form-label" for="due_date">Due Date</label>
                    <div class="col-md-8">
                      <input type="text" id="due_date" name="due_date" class="form-control datepicker" placeholder="Pilih due date" value="03 November 2024">
                    </div>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-2 col-form-label" for="notes_si">Notes</label>
                <div class="col-md-9">
                  <textarea rows="3" id="notes_si" name="notes_si" class="form-control" placeholder="Ketikkan notes">-</textarea>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <div id="dt-detail" class="table-striped"></div>
              </div>
              <hr>
              <table class="table table-bordered table-condensed table-warning">
                <tbody>
                  <tr class="warning">
                    <!-- <td>Items: <span class="f-w-700 totals_val float-end" id="sl_qty_items">0</span>
                        <input type="hidden" value="" name="sl_qty_item" id="sl_qty_item" >
                    </td> -->
                    <td></td>
                    <td>Total: <span class="f-w-700 totals_val float-end" id="sl_ttl_items">0.00</span>
                        <input type="hidden" value="" name="sl_ttl_item" id="sl_ttl_item" >
                    </td>
                    <!-- <td>Diskon: <span class="f-w-700 totals_val float-end" id="tds">0.00</span></td> -->
                    <td>Pajak: <span class="f-w-700 totals_val float-end" id="sl_pajak_items">0.00</span>
                        <input type="hidden" value="" name="sl_pajak_item" id="sl_pajak_item" >
                    </td>
                    
                    <!-- <td hidden>Pengiriman: <span class="f-w-700 totals_val float-end" id="tship">0.00</span></td> -->
                    <!-- <td colspan="2"></td> -->
                    <td >Grand Total <span class="f-w-700 totals_val float-end" id="sl_ttl_exts">0.00</span>
                        <input type="hidden" value="" name="sl_ttl_ext" id="sl_ttl_ext" >
                        <input type="hidden" value="" name="sl_ppn_ext" id="sl_ppn_ext" >
                    </td>
                    
                  </tr>
                  <!-- <tr class="border-bottom-0">
                    <td class="bg-transparent border-0" colspan="3"></td>
                    <td colspan="2" class="w-30" >Grand Total <span class="f-w-700 totals_val float-end" id="sl_gttl_items">0.00</span>
                        <input type="hidden" value="" name="sl_gttl_item" id="sl_gttl_item" >
                    </td>
                  </tr> -->
                 
                </tbody>
              </table> 
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/sales-invoice" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="trans/sales-invoice" class='btn btn-success'>
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

<?= $this->section('script'); ?>
<script src="script/app/transaction/sales_invoice/form.js"></script>
<?= $this->endSection('script'); ?>
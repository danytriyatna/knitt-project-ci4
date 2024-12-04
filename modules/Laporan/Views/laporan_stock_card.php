<?= $this->extend('template'); ?>
<?= $this->section('modal') ?>
<div id="modal-barang" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List Barang</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="col-md-4" style="float: right; position: relative; right: 15px;">
              <div class="homeSearch w-100" style="width: 100%; margin-left: 5%; margin-top: 0;">
                <input type="text" id="tb-search" class="form-control" placeholder="Pencarian . . .">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="dt-list-barang" class="table-responsive table-striped"></div>
        </div>
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
          <li class="breadcrumb-item"><a href="./">Laporan</a></li>
          <li class="breadcrumb-item active"><?= $titlehead ?></li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-sm-2">
              <div class="form-group m-b-0">
                <label class="control-label text-left text-md-right" for="filter_fitur">Barang</label>
                <input type="hidden" id="filter_barang_id" name="filter_barang_id">
                <input type="text" id="filter_barang" name="filter_barang" class="form-control" placeholder="Semua Barang" readonly>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group m-b-0">
                <label class="control-label text-left text-md-right" for="filter_penguji">Tanggal Mulai</label>
                <input type='date' class='form-control' id='tgl_mulai' name='tgl_mulai' value="<?= date("Y-m-d") ?>">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group m-b-0">
                <label class="control-label text-left text-md-right" for="filter_penguji">Tanggal Akhir</label>
                <input type='date' class='form-control' id='tgl_akhir' name='tgl_akhir' value="<?= date("Y-m-d", strtotime('+7 days')) ?>">
              </div>
            </div>
            <div class="col-sm-2 align-self-end">
              <button class="btn btn-primary" id="btn-tampilkan" type="button"><i class="fa fa-filter"></i>&nbsp;</button>
              <button type="button" id="btn-reset" class="btn btn-secondary m-s-5" title="Reset Filter"><i class="fa fa-history"></i>&nbsp;</button>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-sm-12 text-right">
              <!-- <button class="btn btn-info m-l-5" id="filter">Lihat Laporan</button> -->
              <a class="btn btn-success m-l-5 exportExcel">Export to XLSX</a>
              <!-- <?= base_url('adminpanel/laporan_indeks/print_pdf') ?> -->
              <a class="btn btn-danger m-l-5 exportPDF">Export to PDF</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">

          <div class="form-group row">
            <div class="col-sm-3 offset-sm-9">

            </div>
          </div>
          <!--<div id="dt-list" tabulator-movableRows="true" class="table-responsive table-striped"></div> -->
          <br>
          <div class="col-sm-12">
            <div id="dt-list" class="table-responsive table-striped"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/app/laporan/stock_card.js"></script>
<?= $this->endSection('script'); ?>
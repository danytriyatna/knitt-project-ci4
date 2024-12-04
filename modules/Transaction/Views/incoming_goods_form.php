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
          <div id="dt-list" class="table-responsive table-striped"></div>
        </div>
      </div>

    </div>
  </div>
</div>

<div id="modal-vendor" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List Vendor</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="col-md-4" style="float: right; position: relative; right: 15px;">
              <div class="homeSearch w-100" style="width: 100%; margin-left: 5%; margin-top: 0;">
                <input type="text" id="tb-search2" class="form-control" placeholder="Pencarian . . .">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="dt-list-vendor" class="table-responsive table-striped"></div>
        </div>
      </div>

    </div>
  </div>
</div>
<div id="modal-konsumen" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List Konsumen</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="col-md-4" style="float: right; position: relative; right: 15px;">
              <div class="homeSearch w-100" style="width: 100%; margin-left: 5%; margin-top: 0;">
                <input type="text" id="tb-search3" class="form-control" placeholder="Pencarian . . .">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="dt-list-konsumen" class="table-responsive table-striped"></div>
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
            <div class="col-sm-8">
              <div class="row">
                <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="select_kategori">Kategori<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <select id="select_kategori" name="select_kategori" class="form-select select2" data-placeholder="-- Pilih Kategori --" required>
                      <option value=""></option>
                      <?php foreach ($kategori as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['kategori'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                      Kategori tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row d-none" id="divGudangTujuan">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="select_gudang_tujuan">Gudang Tujuan<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <select id="select_gudang_tujuan" name="select_gudang_tujuan" class="form-select select2" data-placeholder="-- Pilih Gudang --" required>
                      <option value=""></option>
                      <?php foreach ($gudang as $item) : ?>
                        <option value="<?= $item->id ?>"><?= $item->nama_gudang ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                      Gudang Tujuan
                    </div>
                  </div>
                </div>
                <div class="form-group row d-none" id="divGudangAsal">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="select_gudang_asal">Gudang Asal<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <select id="select_gudang_asal" name="select_gudang_asal" class="form-select select2" data-placeholder="-- Pilih Gudang --" required>
                      <option value=""></option>
                      <?php foreach ($gudang as $item) : ?>
                        <option value="<?= $item->id ?>"><?= $item->nama_gudang ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                      Gudang Asal
                    </div>
                  </div>
                </div>
                <div class="form-group row d-none" id="divNamaKonsumen">
                  <label id="labelNama" class="control-label text-start text-md-end col-md-3 col-form-label" for="nama">Nama Konsumen<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <input type="text" id="nama_konsumen" name="nama_konsumen" class="form-control" placeholder="Ketikkan Nama Konsumen" required>
                      <span id="spanKonsumen" class="input-group-text bg-white" id="basic-addon11"><i class="ti-search"></i></span>
                    </div>

                    <div class="invalid-feedback">
                      Nama Konsumen tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row d-none" id="divNamaVendor">
                  <label id="labelNama" class="control-label text-start text-md-end col-md-3 col-form-label" for="nama">Nama Vendor<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <input type="text" id="nama_vendor" name="nama_vendor" class="form-control" placeholder="Ketikkan Nama Vendor" required>
                      <span id="spanVendor" class="input-group-text bg-white" id="basic-addon11"><i class="ti-search"></i></span>
                    </div>
                    <div class="invalid-feedback">
                      Nama Vendor tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="barang">Barang<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <input type="text" id="barang" name="barang" class="form-control" placeholder="Pilih Barang" required>
                    <input type="hidden" id="idBarang" name="idBarang" class="form-control">
                    <div class="invalid-feedback">
                      Barang tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="jenis_barang">Jenis Barang<span class="text-danger">*</span></label>
                  <div class="col-md-9">
                    <input type="text" id="jenis_barang" name="jenis_barang" class="form-control" disabled placeholder="Jenis Barang Otomatis" required>
                    <div class="invalid-feedback">
                      Jenis Barang tidak valid
                    </div>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="stok">Stok<span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok Otomatis" disabled>
                      <span class="input-group-text bg-gray" id="satuan" id="basic-addon11"></span>
                    </div>
                    <div class="invalid-feedback">
                      Stok tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row d-none" id="divStokGudangAsal">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="stok">Stok Gudang Asal<span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <div class="input-group">
                      <input type="text" class="form-control" id="stok_asal" name="stok_asal" placeholder="Stok Otomatis" disabled>
                    </div>
                    <div class="invalid-feedback">
                      Stok Gudang Asal tidak valid
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label" for="stok">Jumah Masuk<span class="text-danger">*</span></label>
                  <div class="col-md-4">
                    <input type="number" id="jml_masuk" name="jml_masuk" class="form-control" placeholder="Ketikkan Jumlah Masuk" required>
                  </div>
                  <div class="invalid-feedback">
                    Jumlah Masuk valid
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="stok">Total Stok<span class="text-danger">*</span></label>
                <div class="col-md-4">
                  <input type="text" id="total_stok" name="total_stok" class="form-control" placeholder="Total Stok Otomatis" disabled>
                  <div class="invalid-feedback">
                    Total Stok tidak valid
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tanggal">Tanggal<span class="text-danger">*</span></label>
                <div class="col-md-9">
                  <input type="text" id="tanggal" name="tanggal" class="form-control datepicker" placeholder="Pilih tanggal transfer" value="01 November 2024">
                  <div class="invalid-feedback">
                    Tanggal tidak valid
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="keterangan">Keterangan</label>
                <div class="col-md-9">
                  <textarea name="keterangan" id="keterangan" class="form-control" rows="5"></textarea>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/item-transfer" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <button id="save" class='btn btn-success'>
                    <span class="fa fa-save"></span> Simpan
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>

        <hr>


      </div>
    </div>
  </div>
</div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/app/transaction/incoming_goods/form.js"></script>
<?= $this->endSection('script'); ?>
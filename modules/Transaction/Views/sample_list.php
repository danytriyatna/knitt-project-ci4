<?= $this->extend('template'); ?>

<?= $this->section('modal') ?>
<div id="modal-form-add-po" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Tambah Sample</h5>
        <input type="hidden" id="data_id">
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-secondary p-y-8 text-muted">
          <i>*) Wajib diisi</i>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="no_sample">Sample No.<span class="text-danger">*</span></label>
          <div class="col-md-9">
            <input type="text" id="no_sample" name="no_sample" class="form-control" placeholder="Ketikkan nomor sample" value="" required>
            <div class="invalid-feedback">
              Sample No. tidak valid
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="desc_style">Description<span class="text-danger">*</span></label>
          <div class="col-md-9">
            <input type="text" id="desc_style" name="desc_style" class="form-control" placeholder="Ketikkan sample description" value="" required>
            <div class="invalid-feedback">
              Sample Description tidak valid
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="select_buyer">Buyer<span class="text-danger">*</span></label>
          <div class="col-md-9">
            <select id="select_buyer" name="select_buyer" class="form-select select2" data-placeholder="-- Pilih Buyer --" required>
              <option value=""></option>
              <?php foreach ($buyer as $item) : ?>
                <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
              Buyer tidak valid
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="tgl_sample">Date<span class="text-danger">*</span></label>
          <div class="col-md-9">
            <input type="text" id="tgl_sample" name="tgl_sample" class="form-control datepicker" placeholder="Pilih tanggal sample" value="" required>
            <div class="invalid-feedback">
              Date tidak valid
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="tgl_deadline">Deadline<span class="text-danger">*</span></label>
          <div class="col-md-9">
            <input type="text" id="tgl_deadline" name="tgl_deadline" class="form-control datepicker" placeholder="Pilih tanggal deadline" value="" required>
            <div class="invalid-feedback">
              Deadline tidak valid
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="ket_sample">Keterangan</label>
          <div class="col-md-9">
            <input type="text" id="ket_sample" name="ket_sample" class="form-control" placeholder="Ketikkan uraian keterangan" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-2 col-form-label" for="foto_style">Foto</label>
          <div class="col-md-9">
            <input type="hidden" id="fileSampleOld">
            <input type="file" id="fileSample" onchange="readURL(this,'#fileSample')" name="fileSample" class="form-control file-drag-drop" accept=".jpg, .jpeg, .png">
            <small class="form-text">Format file *.JPG, *.JPEG, *.PNG, ukuran maks. 1 MB</small>
            <br>
            <img class="m-t-10 w-40 d-none" id="linkFileSample" alt="Foto Sample">
          </div>
        </div>
        <div id="rowDet">
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <button type="button" class="btn btn-sm btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modal-form-po"> Tambah <i class="fa fa-plus"></i></button>
              <div id="dt-detail" class="table-responsive table-striped"></div>

            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="m-s-5 btn btn-success" id="btn-save"> <i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<div id="modal-form-po" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Detail Warna & Ukuran Sample</h5>
        <button class="btn-close" data-bs-toggle="modal" data-bs-target="#modal-form-add-po" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-3">
            <img class="w-100" src="assets/images/sample-dummy.png" alt="Foto Sample">
          </div>
          <div class="col-sm-9">
            <h6 class="f-w-700 m-b-6">SPL/003/10/2024</h6>
            <h5 class="f-w-700 m-b-12">K-17 (CARDIGAN PITA)</h5>
            <p class="m-y-0">7 Mei 2024</p>
            <p class="m-y-0"><em>Deadline: 3 Juni 2024</em></p>
            <p class="f-w-700 m-t-4">YUSUF</p>
          </div>
        </div>

        <hr>

        <h6 class="f-w-700">Pilih Warna Style</h6>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna1">Warna 1</label>
              <div class="col-md-9">
                <select id="po_warna1" name="po_warna1" class="form-select select2" data-placeholder="-- Pilih Warna 1 --">
                  <option value=""></option>
                  <option value="1">M38</option>
                  <option value="2">M527</option>
                  <option value="3">SAGE</option>
                  <option value="4">HITAM</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna2">Warna 2</label>
              <div class="col-md-9">
                <select id="po_warna2" name="po_warna2" class="form-select select2" data-placeholder="-- Pilih Warna 2 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna3">Warna 3</label>
              <div class="col-md-9">
                <select id="po_warna3" name="po_warna3" class="form-select select2" data-placeholder="-- Pilih Warna 3 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna4">Warna 4</label>
              <div class="col-md-9">
                <select id="po_warna4" name="po_warna4" class="form-select select2" data-placeholder="-- Pilih Warna 4 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna5">Warna 5</label>
              <div class="col-md-9">
                <select id="po_warna5" name="po_warna5" class="form-select select2" data-placeholder="-- Pilih Warna 5 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna6">Warna 6</label>
              <div class="col-md-9">
                <select id="po_warna6" name="po_warna6" class="form-select select2" data-placeholder="-- Pilih Warna 6 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna7">Warna 7</label>
              <div class="col-md-9">
                <select id="po_warna7" name="po_warna7" class="form-select select2" data-placeholder="-- Pilih Warna 7 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna8">Warna 8</label>
              <div class="col-md-9">
                <select id="po_warna8" name="po_warna8" class="form-select select2" data-placeholder="-- Pilih Warna 8 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna9">Warna 9</label>
              <div class="col-md-9">
                <select id="po_warna9" name="po_warna9" class="form-select select2" data-placeholder="-- Pilih Warna 9 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="po_warna10">Warna 10</label>
              <div class="col-md-9">
                <select id="po_warna10" name="po_warna10" class="form-select select2" data-placeholder="-- Pilih Warna 10 --">
                  <option value=""></option>
                  <option value="1">MINT</option>
                  <option value="2">OFF WHITE K</option>
                  <option value="3">CREAM</option>
                  <option value="4">HITAM</option>
                  <option value="5">SMA</option>
                  <option value="6">ROSE TUA</option>
                  <option value="7">OFF WHITE</option>
                  <option value="8">LILAC</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <hr>

        <h6 class="f-w-700">Quantity dan Harga per Ukuran</h6>
        <div class="row m-t-16">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>UKURAN</th>
                    <th style="min-width: 80px; width: 80px;">QTY</th>
                    <th style="min-width: 200px;">PRICE</th>
                    <th>TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>S</td>
                    <td><input type="text" id="qty_s" name="qty_s" class="form-control" placeholder="Ketikkan qty ukuran S" value="100"></td>
                    <td><input type="text" id="price_s" name="price_s" class="form-control form-idr" placeholder="Ketikkan harga ukuran S" value="20000"></td>
                    <td>Rp 2.000.000</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>M</td>
                    <td><input type="text" id="qty_m" name="qty_m" class="form-control" placeholder="Ketikkan qty ukuran M" value="100"></td>
                    <td><input type="text" id="price_m" name="price_m" class="form-control form-idr" placeholder="Ketikkan harga ukuran M" value="25000"></td>
                    <td>Rp 2.500.000</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>L</td>
                    <td><input type="text" id="qty_l" name="qty_l" class="form-control" placeholder="Ketikkan qty ukuran L" value="100"></td>
                    <td><input type="text" id="price_l" name="price_l" class="form-control form-idr" placeholder="Ketikkan harga ukuran L" value="30000"></td>
                    <td>Rp 3.000.000</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>XL</td>
                    <td><input type="text" id="qty_xl" name="qty_xl" class="form-control" placeholder="Ketikkan qty ukuran XL" value="100"></td>
                    <td><input type="text" id="price_xl" name="price_xl" class="form-control form-idr" placeholder="Ketikkan harga ukuran XL" value="35000"></td>
                    <td>Rp 3.500.000</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>2XL</td>
                    <td><input type="text" id="qty_2xl" name="qty_2xl" class="form-control" placeholder="Ketikkan qty ukuran 2XL" value="100"></td>
                    <td><input type="text" id="price_2xl" name="price_2xl" class="form-control form-idr" placeholder="Ketikkan harga ukuran 2XL" value="40000"></td>
                    <td>Rp 4.000.000</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>3XL</td>
                    <td><input type="text" id="qty_3xl" name="qty_3xl" class="form-control" placeholder="Ketikkan qty ukuran 3XL" value="100"></td>
                    <td><input type="text" id="price_3xl" name="price_3xl" class="form-control form-idr" placeholder="Ketikkan harga ukuran 3XL" value="45000"></td>
                    <td>Rp 4.500.000</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>ALL SIZE</td>
                    <td><input type="text" id="qty_all" name="qty_all" class="form-control" placeholder="Ketikkan qty ukuran ALL SIZE" value="100"></td>
                    <td><input type="text" id="price_all" name="price_all" class="form-control form-idr" placeholder="Ketikkan harga ukuran ALL SIZE" value="50000"></td>
                    <td>Rp 5.000.000</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="m-s-5 btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-form-add-po"> <i class="fa fa-save"></i> Simpan</button>
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
            <div class="col-md-12 mb-3">
              <?php if (isset($_SESSION['message'])) { ?>
                <script type="text/javascript">
                  window.setTimeout(function() {
                    $(".alert").alert('close');
                  }, 3000);
                </script>
                <div class="alert alert-success">
                  <?php echo $_SESSION['message']; ?>
                </div>
              <?php } ?>
              <?php if (isset($_SESSION['err'])) { ?>
                <script type="text/javascript">
                  window.setTimeout(function() {
                    $(".alert").alert('close');
                  }, 5000);
                </script>
                <div class="alert alert-error">
                  <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
                </div>
              <?php } ?>
            </div>
            <div class="col-sm-3">
              <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" id="btn-add"> <i class="fa fa-plus"></i> Tambah</button>
            </div>
            <div class="col-sm-4 offset-md-5">
              <div class="form-group">
                <div class="input-group mb-3">
                  <span class="input-group-text bg-white" id="basic-addon11" style="border-right-width: 0px;"><i class="ti-search"></i></span>
                  <input type="text" class="form-control p-s-0" id="tb-search" placeholder="Pencarian" aria-label="Username" aria-describedby="basic-addon11" style="border-left-width: 0px;">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div id="dt-list"></div>
              <!-- <?php for ($i = 0; $i < 3; $i++) : ?>
                <div class="card shadow-sm">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-sm-6">
                        <button type="button" class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modal-form-add-po"> <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> Hapus</button>
                      </div>
                      <div class="col-sm-6">
                        <div class="d-flex justify-content-end" style="column-gap: 8px;">
                          <div class="card m-y-8 cursor-pointer">
                            <div class="card-body p-y-6">
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fa fa-check-circle f-s-20 text-success m-e-6"></i>
                                <span class="f-w-700 text-success">PROGRAM</span>
                              </div>
                            </div>
                          </div>

                          <div class="card m-y-8 cursor-pointer">
                            <div class="card-body p-y-6">
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fa fa-check-circle f-s-20 text-success m-e-6"></i>
                                <span class="f-w-700 text-success">RAJUT</span>
                              </div>
                            </div>
                          </div>

                          <div class="card m-y-8 cursor-pointer">
                            <div class="card-body p-y-6">
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fa fa-dot-circle f-s-20 text-muted m-e-6"></i>
                                <span class="f-w-700 text-muted">KIRIM</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-3 text-center">
                        <h6 class="f-w-700 m-b-6">SPL/00<?= 3 - $i; ?>/10/2024</h6>
                        <h5 class="f-w-700 m-b-12">K-17 (CARDIGAN PITA)</h5>
                        <p class="m-y-0">7 Mei 2024</p>
                        <p class="m-y-0"><em>Deadline: 3 Juni 2024</em></p>
                        <p class="f-w-700 m-t-4">YUSUF</p>
                        <img class="m-t-10 w-90" src="assets/images/sample-dummy.png" alt="Foto Sample">
                      </div>
                      <div class="col-sm-9">
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
                                <th rowspan="2">QTY</th>
                                <th rowspan="2">AMOUNT</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td class="text-nowrap">M38 - MINT - HITAM - OFF WHITE</td>
                                <td>44</td>
                                <td>90</td>
                                <td>66</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>200</td>
                                <td class="text-nowrap">Rp 200.000.000,00</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td class="text-nowrap">M527 - OFF WHITE K - SMA - ROSE TUA</td>
                                <td>66</td>
                                <td>135</td>
                                <td>99</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>300</td>
                                <td class="text-nowrap">Rp 300.000.000,00</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td class="text-nowrap">SAGE - OFF WHITE K - ROSE TUA - LILAC</td>
                                <td>33</td>
                                <td>68</td>
                                <td>50</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>151</td>
                                <td class="text-nowrap">Rp 151.000.000,00</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td class="text-nowrap">HITAM - CREAM - ROSE TUA - LILAC</td>
                                <td>55</td>
                                <td>113</td>
                                <td>83</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>251</td>
                                <td class="text-nowrap">Rp 251.000.000,00</td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="2" class="text-end">TOTAL</th>
                                <th>198</th>
                                <th>406</th>
                                <th>298</th>
                                <th>0</th>
                                <th>0</th>
                                <th>0</th>
                                <th>902</th>
                                <th class="text-nowrap">Rp 902.000.000,00</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endfor; ?> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/app/transaction/sample/index.js"></script>
<?= $this->endSection('script'); ?>
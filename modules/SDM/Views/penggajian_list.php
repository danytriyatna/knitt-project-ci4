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
            <div class="col-sm-2">
              <div class="form-group row mb-0">
                <div class="col-md-12">
                  <label class="control-label text-start col-form-label" for="filter_tgl_from">Tanggal</label>
                  <input type="text" id="filter_tgl_from" name="filter_tgl_from" class="form-control datepicker" placeholder="Pilih tanggal awal" value="">
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group row mb-0">
                <div class="col-md-12">
                  <label class="control-label text-start col-form-label" for="filter_tgl_to">&nbsp;</label>
                  <input type="text" id="filter_tgl_to" name="filter_tgl_to" class="form-control datepicker" placeholder="Pilih tanggal akhir" value="">
                </div>
              </div>
            </div>
            <div class="col-sm-3 align-self-end">
              <button id="btn-generate" class="btn btn-success" type="button"><i class="fa fa-table"></i>&nbsp; Generate</button>
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
          <div class="table-responsive">
            <table class="table table-striped datatable">
              <thead>
                <tr>
                  <th>NIK</th>
                  <th>NAMA</th>
                  <th>JABATAN</th>
                  <th>HADIR</th>
                  <th>IZIN</th>
                  <th>SAKIT</th>
                  <th>TANPA KETERANGAN</th>
                  <th>GAJI/UPAH</th>
                  <th>JAM LEMBUR HK</th>
                  <th>JAM LEMBUR HL</th>
                  <th>LEMBUR</th>
                  <th>POTONGAN</th>
                  <th>KETERANGAN POTONGAN</th>
                  <th>JML GAJI/UPAH</th>
                </tr>
              </thead>
              <tbody class="d-none">
                <?php for($i = 0; $i < 3; $i++) : ?>
                <tr>
                  <td>24120<?= $i ?></td>
                  <td><?= ['Ayi', 'Rosa', 'Tono'][$i] ?></td>
                  <td>Karyawan/Staff</td>
                  <td>7</td>
                  <td>1</td>
                  <td>0</td>
                  <td>0</td>
                  <td class="text-nowrap">450.000,00</td>
                  <td>3</td>
                  <td>0</td>
                  <td class="text-nowrap">225.000,00</td>
                  <td style="min-width: 130px;">
                    <input id="input_potongan_<?= $i ?>" name="input_potongan_<?= $i ?>" type="text" class="form-control form-idr" value="50000">
                  </td>
                  <td>
                    <textarea id="ket_potongan_<?= $i ?>" name="ket_potongan_<?= $i ?>" class="form-control" rows="2"></textarea>
                  </td>
                  <td class="text-nowrap">625.000,00</td>
                </tr>
                <?php endfor; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script') ?>
<script>
  const btnGenerate = document.querySelector('#btn-generate');
  const rowData = document.querySelector('table > tbody');

  if (rowData)

  btnGenerate.addEventListener('click', () => {
    iLoader.start()

    setTimeout(() => {
      rowData.classList.remove('d-none');
      iLoader.stop();
    }, 1000)
  })
</script>
<?= $this->endSection('script') ?>
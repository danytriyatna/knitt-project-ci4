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
                  <label class="control-label text-start col-form-label" for="filter_tgl">Tanggal</label>
                  <input type="text" id="filter_tgl" name="filter_tgl" class="form-control datepicker" placeholder="Pilih tanggal" value="">
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
                  <th>TANGGAL</th>
                  <th>JAM MASUK</th>
                  <th>JAM KELUAR</th>
                  <th>STATUS KEHARIDAN</th>
                  <th>KEHADIRAN (HARI)</th>
                  <th>KETERANGAN KEHADIRAN</th>
                  <th>STATUS LEMBUR</th>
                  <th>JAM LEMBUR</th>
                  <th>KETERNAGAN LEMBUR</th>
                </tr>
              </thead>
              <tbody class="d-none">
                <?php for($i = 0; $i < 3; $i++) : ?>
                <tr>
                  <td>24120<?= $i ?></td>
                  <td><?= ['Ayi', 'Rosa', 'Tono'][$i] ?></td>
                  <td>Karyawan/Staff</td>
                  <td>01/12/2024</td>
                  <td></td>
                  <td></td>
                  <td>
                    <select id="status_absensi_<?= $i ?>" name="status_absensi_<?= $i ?>" class="form-select">
                      <option value="1" selected>HADIR</option>
                      <option value="2">IZIN</option>
                      <option value="3">SAKIT</option>
                      <option value="4">TANPA KETERANGAN</option>
                    </select>
                  </td>
                  <td>
                    <input id="jml_kehadiran_<?= $i ?>" name="jml_kehadiran_<?= $i ?>" type="text" class="form-control">
                  </td>
                  <td>
                    <textarea id="ket_kehadiran_<?= $i ?>" name="ket_kehadiran_<?= $i ?>" class="form-control" rows="2"></textarea>
                  </td>
                  <td>
                    <select id="status_lembur_<?= $i ?>" name="status_lembur_<?= $i ?>" class="form-select">
                      <option value="0" selected>-</option>
                      <option value="1">LEMBUR WEEKDAY</option>
                      <option value="2">LEMBUR WEEKEND/HARI LIBUR</option>
                    </select>
                  </td>
                  <td>
                    <input id="jml_lembur_<?= $i ?>" name="jml_lembur_<?= $i ?>" type="text" class="form-control">
                  </td>
                  <td>
                    <textarea id="ket_lembur_<?= $i ?>" name="ket_lembur_<?= $i ?>" class="form-control" rows="2"></textarea>
                  </td>
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
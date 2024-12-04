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
          <div class="table-responsive">
            <table class="table table-striped datatable">
              <thead>
                <tr>
                  <th style="min-width: 105px; width: 105px;">
                    <a href="trans/item-transfer/form" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a>
                  </th>
                  <th>TRANSFER NO.</th>
                  <th>DATE</th>
                  <th>TRANSFER FROM</th>
                  <th>TRANSFER TO</th>
                  <th>TRANSFER STATUS</th>
                </tr>
              </thead>
              <tbody>
                <?php for($i = 0; $i < 3; $i++) : ?>
                <tr>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i> Aksi <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-act" role="menu">
                        <li><a href="trans/item-transfer/form" title="Edit"><i class="fa fa-fw fa-edit"></i> Edit</a></li>
                        <li><a href="javascript:void(0)" title="Hapus"><i class="fa fa-fw fa-trash"></i> Hapus</a>
                        </li>
                      </ul>
                    </div>
                  </td>
                  <td>TRF24100001</td>
                  <td>01-11-2024</td>
                  <td>GUDANG UTAMA</td>
                  <td>GUDANG PRODUKSI</td>
                  <td>
                    <span class="badge bg-secondary">DRAFT</span>
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
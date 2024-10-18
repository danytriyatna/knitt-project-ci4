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
            <div class="col-sm-3">
              <div class="form-group m-b-0 d-flex align-items-center">
                <label class="control-label text-start text-md-end m-e-8" for="filter_status">Status</label>
                <select id="filter_status" name="filter_status" class="form-control custom-select select2">
                  <option value="0">All</option>
                  <option value="1">Draft</option>
                  <option value="2">Process</option>
                  <option value="3">Done</option>
                </select>
              </div>
            </div>
          </div>
          <hr>
          <div class="table-responsive">
            <table class="table table-striped datatable">
              <thead>
                <tr>
                  <th style="min-width: 105px; width: 105px;">
                    <!-- <a href="trans/production/form" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</a> -->
                  </th>
                  <th>PROD NO.</th>
                  <th>WO NO.</th>
                  <th>WO DATE</th>
                  <th>DEADLINE</th>
                  <th>STYLE</th>
                  <th>BUYER</th>
                  <th>WO QTY</th>
                  <th>PROD RESUT</th>
                  <th>REMAIN QTY</th>
                  <th>PROD STATUS</th>
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
                        <li><a href="trans/production/form" title="Edit"><i class="fa fa-fw fa-edit"></i> Edit</a></li>
                        <li><a href="javascript:void(0)" title="Hapus"><i class="fa fa-fw fa-trash"></i> Hapus</a>
                        </li>
                      </ul>
                    </div>
                  </td>
                  <td>PRD24100001</td>
                  <td>WOD2410001</td>
                  <td>01-10-2024</td>
                  <td>31-10-2024</td>
                  <td>K-17 (CARDIGAN PITA)</td>
                  <td>YUSUF</td>
                  <td>1.000</td>
                  <td>0</td>
                  <td>1.000</td>
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
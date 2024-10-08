<?= $this->extend('template'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">

    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $titlehead ?></h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./"><?= $name_app ?></a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="col-md-3" style="float: right; position: relative; right: 15px;">
                    <div class="homeSearch w-100" style="width: 100%; margin-left: 5%; margin-top: 0;">
                        <input type="text" id="tb-search" class="form-control" placeholder="Search . . .">
                    </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div id="dt-list" class="table-responsive table-striped"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?= $this->endSection('content'); ?>
<?= $this->section('script'); ?>
<script src="script/log_activity/index.js"></script>
<?= $this->endSection('script'); ?>
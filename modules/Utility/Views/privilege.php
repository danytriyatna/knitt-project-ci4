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
            <li class="breadcrumb-item"><a href="./">Utilitas</a></li>
            <li class="breadcrumb-item active"><?= $titlehead ?></li>
          </ol>
        </div>
      </div>
    </div>
    <?php echo form_open("utilitas/privileges/save"); ?>
    
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row form-group">
                  <div class="col-sm-2 text-end"><?php echo form_label('Nama Role', 'role_id') ?></div>
                  <div class="col-sm-3" data-bs-toggle="tooltip" data-original-title="" title="" data-select2-id="6">
                  <?php
                    $selectedrole = '';
                    if (isset($priv->role_id) && trim($priv->role_id) != '') $selectedmod = $priv->role_id;
                    $js = 'id="role_id" class="form-control select2" ';
                    echo form_dropdown('role_id', $list_roles, $selectedrole, $js);
                  ?>
                  </div>
                  <div class="col-md-6">
                    <button id="submit" type="submit" class='btn btn-success'><span class="fa fa-save"></span> Update</button>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                  <?php if (isset($_SESSION['message'])) { ?>
                      <script type="text/javascript">
                          window.setTimeout(function () {
                              $(".alert").alert('close');
                          }, 3000);
                      </script>
                      <div class="alert alert-info alert-dismissable">
                          <?php echo $_SESSION['message']; ?>
                      </div>
                  <?php } ?>
                  <?php if (isset($_SESSION['err'])) { ?>
                      <script type="text/javascript">
                          window.setTimeout(function () {
                              $(".alert").alert('close');
                          }, 5000);
                      </script>
                      <div class="alert alert-danger alert-dismissable">
                          <strong>Warning! </strong><?php echo $_SESSION['err']; ?>
                      </div>
                  <?php } ?>

                  <?php
                      $input = array(
                          'class' => 'form-control'
                      );

                      $label = array(
                          'class' => 'control-label col-sm-2'
                      );
                  ?>
                  
                  <div class="col-md-12">
                      <table class="table table-striped table-bordered table-hover w-100" id="dt-listpriv" data-page-length="100">
                          <thead>
                          <tr>
                              <th>Nama Modul</th>
                              <th>View</th>
                              <th>New</th>
                              <th>Edit</th>
                              <th>Delete</th>
                              <th>Print</th>
                              <th>Approve</th>
                          </tr>
                          </thead>
                          <tbody id="modul_det">
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php echo form_hidden($csrf); ?>
    <?php echo form_close(); ?>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>
<script src="script/privilege/index.js"></script>
<?= $this->endSection('script'); ?>
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

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="row form-group">
                  <div class="col-sm-2">
                  <i class="fa fa-info-circle"></i> <i><b>(*)</b> wajib diisi !</i>
                  <div class="clearfix"></div>
                  </label>
                  </div>
                </div>

                <?php echo form_open(current_url(), array('class' => 'form-horizontal needs-validation', 'novalidate' => 'true')); ?>
                <?php
                $input = array(
                    'class' => 'form-control'
                );

                $label = array(
                    'class' => 'control-label text-start text-md-end col-sm-2 col-form-label'
                );
                ?>

                <div class="x_content">
                    <?php if (isset($message) && $message != "") { ?>
                        <div class="alert alert-info alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true"
                                    type="button">x
                            </button>
                            <?php echo (isset($message) && $message != "") ? $message : $this->session->getFlashdata('message'); ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($errmsg) && $errmsg != "") { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true"
                                    type="button">x
                            </button>
                            <?php echo (isset($errmsg) && $errmsg != "") ? $errmsg : $this->session->getFlashdata('errmsg'); ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="row form-group">
                                <?php echo form_label('Nama Modul*', 'module_name', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($module_name);
                                    ?>
                                    <div class="invalid-feedback">
                                        Nama Modul tidak valid
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('Parent Modul*', 'module_pid', $label) ?>
                                <div class="col-md-8">
                                    <?php
                                    $selectedmod = '';
                                    if (isset($module->pid) && trim($module->pid) != '') $selectedmod = $module->pid;
                                    $js = 'id="pid" class="form-control select2" data-placeholder="-- Pilih Parent Modul --" required ';
                                    echo form_dropdown('pid', $list_pmod, $selectedmod, $js);
                                    ?>
                                    <div class="invalid-feedback">
                                        Harap pilih Parent Modul
                                    </div>
                                    <?php if ($selectedmod == '') : ?>
                                    <script>
                                        document.getElementById("pid").value = null;
                                    </script>
                                    <?php endif; ?>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('Alias*', 'module_alias', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($module_alias);
                                    ?>
                                    <div class="invalid-feedback">
                                        Alias tidak valid
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('URL*', 'module_url', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($module_url);
                                    ?>
                                    <div class="invalid-feedback">
                                        URL tidak valid
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('Urutan*', 'mod_seq', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($mod_seq);
                                    ?>
                                    <div class="invalid-feedback">
                                        Urutan tidak valid
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('Icon Class', 'mod_icon_cls', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($mod_icon_cls);
                                    ?>
                                    <small class="form-text">Daftar icon class dapat dilihat pada <a href="http://eliteadmin.themedesigner.in/demos/bt4/hospital/icon-simple-lineicon.html" target="_blank">halaman ini</a></small>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                            <div class="row form-group">
                                <?php echo form_label('Kelompok', 'mod_group', $label) ?>
                                <div class="col-sm-8">
                                    <?php
                                    echo form_input($mod_group);
                                    ?>
                                </div><!-- /.col -->
                            </div><!-- /.form-group -->

                        </div><!-- /.col-md-9 -->
                    </div>
                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <a href="utilitas/modules" class="btn btn-secondary m-e-5" type="submit">
                                <span class="fa fa-arrow-left"></span> Kembali
                            </a>
                            <button id="submit" type="submit" class='btn btn-success'>
                                <span class="fa fa-save"></span> Simpan
                            </button>
                        </div><!-- /.box-footer -->
                    </div>
                </div>
                <?php echo form_hidden('id', $id); ?>
                <?php echo form_hidden('module_alias_edit', $module_alias_edit); ?>
                <?php echo form_hidden($csrf); ?>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>

<?= $this->endSection('content'); ?>

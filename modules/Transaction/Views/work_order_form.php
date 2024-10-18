<?= $this->extend('template'); ?>

<?= $this->section('modal') ?>
<div id="modal-form-wo" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Detail Work Order</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8">
            <h5 class="f-w-700 m-b-12">K-17 (CARDIGAN PITA)</h5>
            <p class="f-w-700 m-b-8 m-t-4">YUSUF</p>
            <p class="m-b-8 m-t-4">COLOUR: A. HITAM</p>
            <p class="m-t-4">QTY: 50</p>
          </div>
          <div class="col-sm-4">
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-4 col-form-label" for="loss_perc">Loss (%)</label>
              <div class="col-md-8">
                <input type="text" id="loss_perc" name="loss_perc" class="form-control" placeholder="Ketikkan nilai loss" value="-5,00">
              </div>
            </div>
          </div>
        </div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>COLOUR</th>
              <th>%</th>
              <th>GRAM</th>
              <th>NEEDS (GRAM)</th>
              <th>IN KGS</th>
              <th>LOSS (KG)</th>
              <th>NFP (KG)</th>
              <th>QTY ON HAND</th>
              <th>(+/-)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-nowrap">A. HITAM</td>
              <td><input type="text" class="form-control"></td>
              <td><input type="text" class="form-control"></td>
              <td>26.400,10</td>
              <td>26,40</td>
              <td>1,32</td>
              <td>27,72</td>
              <td>29,90</td>
              <td>2,18</td>
            </tr>
            <tr>
              <td class="text-nowrap">B. BW.K</td>
              <td>17,20</td>
              <td>64,00</td>
              <td>9.599,83</td>
              <td>9,60</td>
              <td>0,48</td>
              <td>10,08</td>
              <td>10,02</td>
              <td>-0,06</td>
            </tr>
            <tr>
              <td class="text-nowrap">C. CREAM77</td>
              <td>19,36</td>
              <td>72,00</td>
              <td>10.800,09</td>
              <td>10,80</td>
              <td>0,54</td>
              <td>11,34</td>
              <td>11,34</td>
              <td>0,00</td>
            </tr>
            <tr>
              <td class="text-nowrap">D. MOCHA50</td>
              <td>16,31</td>
              <td>60,00</td>
              <td>8.999,99</td>
              <td>8,99</td>
              <td>0,45</td>
              <td>9,45</td>
              <td>9,45</td>
              <td>0,00</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">TOTAL</th>
              <th>372,00</th>
              <th>55.800,00</th>
              <th>55,80</th>
              <th>2,79</th>
              <th>58,59</th>
              <th>60,71</th>
              <th>2,12</th>
            </tr>
          </tfoot>
        </table>

        <hr>

        <h6 class="f-w-700">PRODUCTION PROCESS</h6>
        <div class="row m-t-16">
          <div class="col-sm-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-1">
              <label class="form-check-label" for="check-process-1">
                RAJUT
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-2">
              <label class="form-check-label" for="check-process-2">
                LINKING-OBRAS
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-3">
              <label class="form-check-label" for="check-process-3">
                RABUT-SONTEK
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-4">
              <label class="form-check-label" for="check-process-4">
                WASHING
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-5">
              <label class="form-check-label" for="check-process-5">
                STEAM
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-6">
              <label class="form-check-label" for="check-process-6">
                LUBANG-KANCING
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="check-process-7">
              <label class="form-check-label" for="check-process-7">
                LABEL-SIZE
              </label>
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
            <div class="col-sm-3 text-center">
              <h6 class="f-w-700 m-b-6">WOD2410002</h6>
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
                      <th rowspan="2">QTY ORDER</th>
                      <th rowspan="2">QTY PROD</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td class="text-nowrap">A. HITAM</td>
                      <td>10</td>
                      <td>10</td>
                      <td>10</td>
                      <td>10</td>
                      <td>10</td>
                      <td></td>
                      <td>50</td>
                      <td>20</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>COLOUR</th>
                      <th>QTY</th>
                      <th>GRAM</th>
                      <th>NEEDS</th>
                      <th>KG</th>
                      <th>LOSS</th>
                      <th>NEEDS FOR PROD (KG)</th>
                      <th>STOCK</th>
                      <th>MARGIN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-form-wo"> <i class="fa fa-edit"></i></button>
                      </td>
                      <td>A. HITAM</td>
                      <td>150</td>
                      <td>372,00</td>
                      <td>55.800,00</td>
                      <td>55,80</td>
                      <td>2,79</td>
                      <td>58,59</td>
                      <td>60,71</td>
                      <td>2,12</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <br>

              <div class="row">
                <div class="col-sm-10">
                  <a href="trans/work-order" class="btn btn-default m-e-5">
                    <span class="fa fa-arrow-left"></span> Kembali
                  </a>
                  <a href="trans/work-order" class='btn btn-success'>
                    <span class="fa fa-save"></span> Simpan
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection('content'); ?>
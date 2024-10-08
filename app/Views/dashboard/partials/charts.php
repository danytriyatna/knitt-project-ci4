<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-2">
            <div class="form-group m-b-0">
              <label class="control-label text-left text-md-right" for="filter_tahun">Tahun</label>
              <select id="filter_tahun" name="filter_tahun" class="form-control custom-select">
                <option value="1">2022</option>
                <option value="2">2021</option>
                <option value="3">2020</option>
              </select>
            </div>
          </div>
          <div class="col-sm-3 align-self-end">
            <button class="btn btn-primary" type="button"><i class="fa fa-filter"></i>&nbsp; Filter</button>
          </div>
          <div class="col-sm-3 offset-sm-4 align-self-end text-end">
            <button class="btn btn-success" type="button"><i class="fa fa-file-excel"></i> Export Excel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row m-b-5 m-t-10">
  <div class="col-sm-12">
    <h4>Dataset 1</h4>
  </div>
</div>

<div class="card-group">
  <!-- Column -->
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex no-block align-items-center">
            <div>
              <h3><i class="ti-file"></i></h3>
              <p class="text-muted">DATA 1</p>
            </div>
            <div class="ms-auto">
              <h2 class="counter text-primary">1.000.000</h2>
              <h3 class="counter text-end">25%</h3>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="progress">
            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%; height: 6px;"
              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="col-12 m-t-15">
          <h5 class="text-muted">Label Data 1</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex no-block align-items-center">
            <div>
              <h3><i class="ti-file"></i></h3>
              <p class="text-muted">DATA 2</p>
            </div>
            <div class="ms-auto">
              <h2 class="counter text-warning">1.000.000</h2>
              <h3 class="counter text-end">25%</h3>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="progress">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%; height: 6px;"
              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="col-12 m-t-15">
          <h5 class="text-muted">Label Data 2</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex no-block align-items-center">
            <div>
              <h3><i class="ti-file"></i></h3>
              <p class="text-muted">DATA 3</p>
            </div>
            <div class="ms-auto">
              <h2 class="counter text-success">1.000.000</h2>
              <h3 class="counter text-end">25%</h3>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%; height: 6px;"
              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="col-12 m-t-15">
          <h5 class="text-muted">Label Data 3</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="d-flex no-block align-items-center">
            <div>
              <h3><i class="ti-file"></i></h3>
              <p class="text-muted">DATA 4</p>
            </div>
            <div class="ms-auto">
              <h2 class="counter text-danger">1.000.000</h2>
              <h3 class="counter text-end">25%</h3>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="progress">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%; height: 6px;"
              aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="col-12 m-t-15">
          <h5 class="text-muted">Label Data 4</h5>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <div id="chart_bar" style="height: 280px;"></div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <div id="chart_pie" style="height: 280px;"></div>
      </div>
    </div>
  </div>
</div>

<div class="row m-b-5 m-t-10">
  <div class="col-sm-12">
    <h4>Dataset 2</h4>
  </div>
</div>

<div class="row">
  <!-- Column -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="row p-t-10 p-b-10">
          <!-- Column -->
          <div class="col-8 p-r-0">
            <h3 class="font-light">Data 1</h3>
            <h5 class="text-muted">Total: 10.000.000</h5>
          </div>
          <!-- Column -->
          <div class="col text-end align-self-center">
            <div data-label="50,0%" class="css-bar m-b-0 css-bar-info css-bar-50"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="row p-t-10 p-b-10">
          <!-- Column -->
          <div class="col-8 p-r-0">
            <h3 class="font-light">Data 2</h3>
            <h5 class="text-muted">Total: 10.000.000</h5>
          </div>
          <!-- Column -->
          <div class="col text-end align-self-center">
            <div data-label="50,0%" class="css-bar m-b-0 css-bar-warning css-bar-50"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
  <!-- Column -->
  <div class="col-lg-4 d-none">
    <div class="card">
      <div class="card-body">
        <div class="row p-t-10 p-b-10">
          <!-- Column -->
          <div class="col-8 p-r-0">
            <h3 class="font-light">Selisih</h3>
            <h5 class="text-muted">-</h5>
            <h5 class="text-muted">&nbsp;</h5>
          </div>
          <!-- Column -->
          <div class="col text-end align-self-center">
            <div data-label="0,0%" class="css-bar m-b-0 css-bar-info css-bar-0"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Column -->
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-list"></i> <b>Group Data 1</b></h4>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Column -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="row p-t-10">
                  <!-- Column -->
                  <div class="col-12 p-r-0 m-b-15">
                    <h5 class="font-light">Data 1</h5>
                    <h5 class="text-muted">Total: 5.000.000</h5>
                  </div>
                  <!-- Column -->
                  <div class="col text-end align-self-center">
                    <div data-label="50,0%" class="css-bar m-b-0 css-bar-info css-bar-50"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="row p-t-10">
                  <!-- Column -->
                  <div class="col-12 p-r-0 m-b-15">
                    <h5 class="font-light">Data 2</h5>
                    <h5 class="text-muted">Total: 5.000.000</h5>
                  </div>
                  <!-- Column -->
                  <div class="col text-end align-self-center">
                    <div data-label="50,0%" class="css-bar m-b-0 css-bar-warning css-bar-50"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-header">
        <h4><i class="fas fa-list"></i> <b>Group Data 2</b></h4>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Column -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="row p-t-10">
                  <!-- Column -->
                  <div class="col-12 p-r-0 m-b-15">
                    <h5 class="font-light">Data 1</h5>
                    <h5 class="text-muted">Total: 5.000.000</h5>
                  </div>
                  <!-- Column -->
                  <div class="col text-end align-self-center">
                    <div data-label="50,0%" class="css-bar m-b-0 css-bar-info css-bar-50"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
          <!-- Column -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="row p-t-10">
                  <!-- Column -->
                  <div class="col-12 p-r-0 m-b-15">
                    <h5 class="font-light">Data 2</h5>
                    <h5 class="text-muted">Total: 5.000.000</h5>
                  </div>
                  <!-- Column -->
                  <div class="col text-end align-self-center">
                    <div data-label="50,0%" class="css-bar m-b-0 css-bar-warning css-bar-50"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Column -->
        </div>
      </div>
    </div>
  </div>
</div>
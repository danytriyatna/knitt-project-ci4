

$(document).ready(function () {
    let inpData         = $('#data_id');
    let inpNoSample = $('#no_sample');
    let inpDeskripsi       = $('#desc_style');
    let inpBuyer         = $('#select_buyer');
    let inpTglTransaksi       = $('#tgl_sample');
    let inpTglDeadline       = $('#tgl_deadline');
    let inpKetSample       = $('#ket_sample');
    let fileSample       = $('#fileSample');
    let fileSampleOld       = $('#fileSampleOld');
    let linkFileSample       = $('#linkFileSample');
    let deskripsiText       = $('#deskripsiText');
    let tglSampleText       = $('#tglSampleText');
    let buyerText       = $('#buyerText');
    let tglDeadlineText       = $('#tglDeadlineText');
    let noSampleText       = $('#noSampleText');
    let fotoText       = $('#fotoText');
    let rowDet = $("#rowDet")

    let isModal       = $("#modal-form-add-po");
    let isModalPO      = $("#modal-form-po");

    let buttonRowAction = function(cell) {
        let fmBtnDelete = "";        
        let fmBtnEdit = "";        
       
     
        fmBtnDelete = `<button type="button" class="btn btn-sm btn-danger" title='delete'><i class="fa fa-trash"></i></button>`;
        fmBtnEdit = ` <button type="button" class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modal-form-po" title='edit'><i class="fa fa-edit"></i></button>`;
        return fmBtnEdit + " " + fmBtnDelete;
    };

    let dtList = new Tabulator("#dt-list", {
        columns: [
            {formatter: cardFormatter, hozAlign:"center", widthGrow: 1,headerSort: false},
        ],
        locale: 'id',    
        layout: 'fitColumns',
        ajaxURL: "/trans/sample/list",
        ajaxConfig: "POST",
        sortMode: "remote",
        filterMode: "remote",
        placeholder: "Tidak ada data",
        ajaxRequesting: function (url, params) {
            params.start = params.size * (params.page - 1);
            params.length = params.size;
        },
        ajaxResponse: function (url, params, response) {
            let pageSize = dtList.getPageSize();
            let pageNo = dtList.getPage();
            let startRow = (pageSize * (pageNo - 1)) + 1;
            let endRow = response.data.length + startRow - 1;
            if (response.data.length === 0) {
                startRow = 0; endRow = 0;
            }
            let recordsFiltered = parseInt(response.recordsFiltered);
            let recordsTotal = parseInt(response.recordsTotal);

            $("#table-footer .tabulator-startrow").text(startRow);
            $("#table-footer .tabulator-endrow").text(endRow);
            $("#table-footer .tabulator-totalrow").text(recordsFiltered);

            let elTotalFilteredRow = $("#table-footer .tabulator-totalfilteredrow");
            elTotalFilteredRow.text("");
            if (recordsTotal > recordsFiltered) {
                elTotalFilteredRow.text(" (disaring dari " + recordsTotal
                    + " entri keseluruhan)");
            }
            return response;
        },
        footerElement: '<div id="table-footer" class="pull-left tabulator-info">'
            + 'Menampilkan <span class="tabulator-startrow"></span> - <span class="tabulator-endrow"></span> dari '
            + '<span class="tabulator-totalrow"></span> entri<span class="tabulator-totalfilteredrow"></span></div>',
        pagination: true,
        paginationMode: "remote",
        paginationSize: 25,
        paginationButtonCount: 10,
        dataSendParams: {
            sorters: "order"
        },
        selectable: false,
	});

    let dtListDetail = new Tabulator("#dt-detail", {
        pagination: true, 
        paginationSize: 10,
        paginationButtonCount: 5,
        columns:[
            {title:"ID", field:"id", visible:false},
            {
                headerSort: false,  
                title: 'Aksi', 
                formatter: buttonRowAction,
                width: 100, align: "center", cssClass: "text-center",
                cellClick: function(e, cell) {
                    let row = cell.getRow();
                    let data_row = row.getData();
                    if (e.target.title === 'delete') {
                        if (confirm("Anda yakin akan menghapus data?")) {
                            window.location.replace(baseUrl + "/master-data/konsumen/delete/" + data_row.id);
                        }
                    }else if(e.target.title === 'edit'){
                        // inpData.val(data_row.id)
                        // isModal.modal("show");
                    }   
                }
            },
            {title:"Colour", field:"colour", width:"40%"},
            {title:"S", field:"s", hozAlign:"center",width:"7%"},
            {title:"M", field:"m", hozAlign:"center",width:"7%"},
            {title:"L", field:"l", hozAlign:"center",width:"7%"},
            {title:"XL", field:"xl", hozAlign:"center",width:"7%"},
            {title:"XXL", field:"xxl", hozAlign:"center",width:"7%"},
            {title:"3XL", field:"xxxl", hozAlign:"center",width:"7%"},
            {title:"All", field:"all", hozAlign:"center",width:"7%"},
            {title:"Amount", field:"harga_satuan",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",width:"16%"},
        ],
        locale: 'id',    
        layout: 'fitColumns',
        placeholder: "Tidak ada data",
	});

    let dtListDetailQty = new Tabulator("#dt-detail-qty", {
        pagination: true, 
        paginationSize: 10,
        paginationButtonCount: 5,
        columns:[
            {title:"ID", field:"id", visible:false},
            {title:"No", field:"no", width:"5%"},
            {title:"id_ukuran", field:"id_ukuran", hozAlign:"center",width:"7%",visible:false},
            {title:"Ukuran", field:"ukuran", hozAlign:"center",width:"7%"},
            {title:"QTY", field:"qty", hozAlign:"center",width:"7%"},
            {title:"Price", field:"harga_satuan",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",width:"16%"},
            {title:"Total", field:"harga_total",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",width:"16%"},
        ],
        locale: 'id',    
        layout: 'fitColumns',
        placeholder: "Tidak ada data",
        pagination:false
	});

    
    let searchThread = null;
    let elSearch = $("#tb-search");
    if (elSearch != null) {
        elSearch.on("keyup", function (e) {
            if ($(this).val().length < 3 && e.keyCode > 13) {
                return;
            }
            clearTimeout(searchThread);
            searchThread = setTimeout(function () {
                dtList.setFilter("", "like", elSearch.val());
            }, 600);
        });
    }

    function cardFormatter(cell, formatterParams, onRendered){
        var data = cell.getRow().getData(); // Ambil data row
        
        // HTML Card Layout
        var cardHtml = `<div class="card shadow-sm">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-sm-6">
                        <button type="button" class="btn btn-sm btn-warning text-dark edit" data-id="${data.id}"> <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete" data-id="${data.id}"> <i class="fa fa-trash"></i> Hapus</button>
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
                        <h6 class="f-w-700 m-b-6">${data.kode_sample}</h6>
                        <h5 class="f-w-700 m-b-12">${data.deskripsi}</h5>
                        <p class="m-y-0">${formatterDate(data.tgl_transaksi)}</p>
                        <p class="m-y-0"><em>Deadline: ${formatterDate(data.tgl_deadline)}</em></p>
                        <p class="f-w-700 m-t-4">${data.nama}</p>
                        <img class="m-t-10 w-20" src="${data.file_gambar}" alt="Foto Sample">
                      </div>
                      <div class="col-sm-9">
                           <div id="dt-list-detail-${data.id}" class="table-responsive table-striped"></div>
                      </div>
                    </div>
                  </div>
                </div>`;
    
        onRendered(()=>{
            
            document.querySelector(`.edit[data-id='${data.id}']`).addEventListener('click', ()=>{
                fileSample.val('')
                linkFileSample.attr('src', "")
                getDetail(data.id)
            });
            document.querySelector(`.delete[data-id='${data.id}']`).addEventListener('click', ()=>{
                if (confirm("Anda yakin akan menghapus data?")) {
                    window.location.replace(baseUrl + "/trans/sample/delete/list" + data.id);
                }
            });
            new Tabulator(`#dt-list-detail-${data.id}`, {
                data: data.detail, 
                layout:"fitColumns",
                pagination: true, 
                paginationSize: 10,
                paginationButtonCount: 5,
                columns:[
                    {title:"No", field:"no",   width: "5%"},
                    {title:"Colour", field:"colour", width:"40%"},
                    {title:"S", field:"s", hozAlign:"center",width:"7%"},
                    {title:"M", field:"m", hozAlign:"center",width:"7%"},
                    {title:"L", field:"l", hozAlign:"center",width:"7%"},
                    {title:"XL", field:"xl", hozAlign:"center",width:"7%"},
                    {title:"XXL", field:"xxl", hozAlign:"center",width:"7%"},
                    {title:"3XL", field:"xxxl", hozAlign:"center",width:"7%"},
                    {title:"All", field:"all", hozAlign:"center",width:"7%"},
                    {title:"Amount", field:"harga_satuan",formatter: "money", formatterParams: {
                        decimal: ",",
                        thousand: ".",
                        symbol: "Rp",  // Simbol mata uang Rupiah
                        precision: 0,   // Tidak ada desimal
                    }, hozAlign:"right",width:"16%"},
                ],
            });
        });
    
        return cardHtml; // Return HTML Card
    }

    $("#btn-add").on("click", function(){
        inpData.val("")
        linkFileSample.attr('src', "")
        inpNoSample.val("")
        fileSampleOld.val("")
        fileSample.val("")
        inpDeskripsi.val("")
        inpBuyer.val("").trigger("change")
        inpTglTransaksi.val("")
        inpTglDeadline.val("")
        inpKetSample.val("")
        rowDet.hide()
        isModal.modal("show");
    });

    $("#btn-add-detail").on("click", function(){
       
        getDetailQty(inpData.val(),0)
    });

    $("#btn-save").on("click", function(e){
        e.preventDefault()
        simpanData()
    });

    function formatterDate($date){
        let newDate = new Date($date);
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const formattedDate = newDate.toLocaleDateString('id-ID', options);
        return formattedDate
    }
    
    function formatLocaleDate(localeDate) {
    
        var months = {
            "Januari": "01",
            "Februari": "02",
            "Maret": "03",
            "April": "04",
            "Mei": "05",
            "Juni": "06",
            "Juli": "07",
            "Agustus": "08",
            "September": "09",
            "Oktober": "10",
            "November": "11",
            "Desember": "12"
        };

        var parts = localeDate.split(" ");
        var day = parts[0].padStart(2, '0'); 
        var month = months[parts[1]]; 
        var year = parts[2];

        return `${year}-${month}-${day}`;
    }

    function getDetail(id) {
        $.ajax({
            url: `/trans/sample/detail/${id}`,
            type: 'GET',
            dataType: 'json', 
            success: function(data) {
         
                rowDet.show()
                inpData.val(data.id)
                inpDeskripsi.val(data.deskripsi)
                inpNoSample.val(data.kode_sample)
                fileSampleOld.val(data.gambar_id)
                inpKetSample.val(data.keterangan)
                inpBuyer.val(data.id_konsumen).trigger('change')
                inpTglDeadline.val(formatterDate(data.tgl_deadline))
                inpTglTransaksi.val(formatterDate(data.tgl_transaksi))
               
                dtListDetail.setData(data.detail)
                isModal.modal("show");
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    function getDetailQty(id,idDet) {
        $.ajax({
            url: `/trans/sample/detail-qty/${id}/${idDet}`,
            type: 'GET',
            dataType: 'json', 
            success: function(data) {
                noSampleText.html(data.kode_sample)
                deskripsiText.html(data.deskripsi)
                tglSampleText.html(formatterDate(data.tgl_transaksi))
                buyerText.html(data.nama)
                fotoText.attr("src",data.file_gambar)
                tglDeadlineText.html(`<em>Deadline: ${formatterDate(data.tgl_deadline)}</em>`)
                isModalPO.modal("show");
                dtListDetailQty.setData(data.detailUkuran)
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }



    
    function simpanData() {
        
        let validation = true
        if(inpNoSample.val().length == 0) validation = false
        if(inpDeskripsi.val().length == 0) validation = false
        if(inpBuyer.val().length == 0) validation = false
        if(inpTglDeadline.val().length == 0) validation = false
        if(inpTglTransaksi.val().length == 0) validation = false
        if(fileSample[0].files[0] == undefined) validation = false
    
        if(validation){
            var formData = new FormData();
            formData.append("id",inpData.val());
            formData.append("noSample",inpNoSample.val());
            formData.append("deskripsi",inpDeskripsi.val());
            formData.append("fileSample",fileSample[0].files[0]);
            formData.append("fileIdSampleOld",fileSampleOld.val());
            formData.append("idKonsumen",inpBuyer.val());
            formData.append("tglDeadline",formatLocaleDate(inpTglDeadline.val()));
            formData.append("tglTransaksi",formatLocaleDate(inpTglTransaksi.val()));
            formData.append("keterangan",inpKetSample.val());
            $.ajax({
                type: 'POST',
                url: '/trans/sample/save',
                data: formData,
                processData: false,  // Jangan ubah data menjadi string
            contentType: false,  // Agar jQuery tidak mengatur tipe konten
                beforeSend: function () {
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (response) {
        
                    if(response.status == true){
                        Swal.fire({
                            text: response.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        dtList.setData()
                        Swal.close();
                        isModal.modal("hide");
                    }else{
                        Swal.fire({
                            text: response.message,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function (e) {
                    let msg = e.responseJSON.message;
                    Swal.close();
        
                    Swal.fire({
                        text: msg,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        }else{
            Swal.fire({
                text: "Lengkapi isian pada form !",
                icon: 'warning',
                showConfirmButton: false,
                timer: 2000
            });
        }
    }
    
});

function readURL(input,id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        const imageUrl = e.target.result;
        console.log(e.target)
        const imgElement = document.getElementById('linkFileSample');
        imgElement.classList.remove("d-none");
        imgElement.src = imageUrl; // Set src dari <img> ke data URL
      };
      reader.readAsDataURL(input.files[0]);
    }
  }


$(document).ready(function () {
    let inpData         = $('#data_id');
    let inpDeskripsi       = $('#desc_style');
    let inpBuyer         = $('#select_buyer');
    let inpTglTransaksi       = $('#tgl_sample');
    let inpTglDeadline       = $('#tgl_deadline');
    let inpKetSample       = $('#ket_sample');
    let inpPoWarna1       = $('#po_warna1');
    let inpPoWarna2       = $('#po_warna2');
    let inpPoWarna3       = $('#po_warna3');
    let inpPoWarna4       = $('#po_warna4');
    let inpPoWarna5       = $('#po_warna5');
    let inpPoWarna6       = $('#po_warna6');
    let inpPoWarna7       = $('#po_warna7');
    let inpPoWarna8       = $('#po_warna8');

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
    var idSample = null
    var idSampleDet = null
    var status = null

    let buttonQRAction = function(cell){
       if(cell.getData().id){
           let fmBtnQRCode = "";
           fmBtnQRCode = ` <button type="button" class="btn btn-sm btn-info" title='qr code'><i class="fa fa-print" title='qr code'></i></button>`;
           return fmBtnQRCode;
        }
    }

    let buttonRowAction = function(cell) {
        let fmBtnDelete = "";        
        let fmBtnEdit = "";        

        if (status == 0){
            fmBtnDelete = `<button type="button" class="btn btn-sm btn-danger" title='delete'><i class="fa fa-trash" title='delete'></i></button>`;
        }
       
        fmBtnEdit = ` <button type="button" class="btn btn-sm btn-warning text-dark" title='edit'><i class="fa fa-edit" title='edit'></i></button>`;

        return fmBtnEdit + " " + fmBtnDelete;
    };

    let dtList = new Tabulator("#dt-list", {
        columns: [
            {formatter: cardFormatter, hozAlign:"center", widthGrow: 1,headerSort: false},
        ],
        responsiveLayout: true, // Untuk membuat tabel responsif
        layout: "fitColumns",
        locale: 'id',    
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
                width: '15%', align: "center", cssClass: "text-center",
                cellClick: function(e, cell) {
                    let row = cell.getRow();
                    let data_row = row.getData();
                    if (e.target.title === 'delete') {
                        Swal.fire({
                            title: "Apakah anda yakin ingin menghapus data?",
                            icon: 'question',
                            confirmButtonText: 'Hapus',
                            confirmButtonColor: '#dc3545',
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                            cancelButtonColor: '#6C757D'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteData(data_row.id)
                            }
                        })
                    }else if(e.target.title === 'edit'){
                        getDetailQty(idSample,data_row.id)
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
            }, hozAlign:"right"},
        ],
        locale: 'id',    
        // layout: 'fitColumns',
        placeholder: "Tidak ada data",
	});

    function calculateTotal(row) {
    if(row){
        let qty = row.qty || 0;
        let harga = row.harga_satuan || 0;
        return qty * harga;
    }
        
    }

    let dtListDetailQty = new Tabulator("#dt-detail-qty", {
        pagination: true, 
        paginationSize: 10,
        paginationButtonCount: 5,
        columns:[
            {title:"ID", field:"id", visible:false},
            {
                headerSort: false,  
                title: 'Aksi', 
                formatter: buttonQRAction,
                width: '10%', align: "center", cssClass: "text-center",
                cellClick: function(e, cell) {
                    let row = cell.getRow();
                    let data_row = row.getData();
                    if (e.target.title === 'qr code') {
                        generateQRCode(data_row)
                    } 
                }
            },
            {title:"No",formatter: "rownum",hozAlign: "center", width:"5%"},
            {title:"id_ukuran", field:"id_ukuran", hozAlign:"center",width:"7%",visible:false},
            {title:"Ukuran", field:"ukuran", hozAlign:"center",width:"23%"},
            {title:"QTY", field:"qty", hozAlign:"center",width:"22%",editor: "number",cellEdited: updateTotal},
            {title:"Price", field:"harga_satuan",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",width:"25%",editor: "number",cellEdited: updateTotal},
            {title:"Total", field:"harga_total",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",width:"25%"},
        ],
     
        locale: 'id',    
        // layout: 'fitColumns',
        placeholder: "Tidak ada data",
        pagination:false
	});

    function updateTotal(cell) {
        let row = cell.getRow();
        if (row) { 
            let newTotal = calculateTotal(row.getData());
            row.update({ harga_total: newTotal });
        } 
    }

    
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
        let btnAksi = `<button type="button" class="btn btn-sm btn-warning text-dark edit" data-id="${data.id}"> <i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete" data-id="${data.id}"> <i class="fa fa-trash"></i> Hapus</button>`
        let status = ` <i class="fa fa-dot-circle f-s-20 text-muted m-e-6"></i>
                    <span class="f-w-700 text-muted">`+data.status+`</span>`
        if(data.status === 'Submit'){
            btnAksi = `<button type="button" class="btn btn-sm btn-warning text-dark edit" data-id="${data.id}"> <i class="fa fa-edit"></i> Edit</button>
            <button type="button" hidden class="btn btn-sm btn-danger delete" data-id="${data.id}"> <i class="fa fa-trash"></i> Hapus</button>`
             status = ` <i class="fa fa-check-circle f-s-20 text-success m-e-6"></i>
                    <span class="f-w-700 text-success">`+data.status+`</span>`
        }
        
        var cardHtml = `<div class="card shadow-sm">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-sm-6 text-start">
                        ${btnAksi}
                      </div>
                      <div class="col-sm-6">
                        <div class="d-flex justify-content-end" style="column-gap: 8px;">
                          
                          <div class="card m-y-8 cursor-pointer">
                            <div class="card-body p-y-6">
                              <div class="d-flex justify-content-start align-items-center">
                                ${status}
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
                        <img class="m-t-10 w-100" src="${data.file_gambar}" alt="Foto Sample">
                      </div>
                      <div class="col-sm-9">
                           <div id="dt-list-detail-${data.id}" class="table-responsive table-striped"></div>
                      </div>
                    </div>
                  </div>
                </div>`;
    
        onRendered(()=>{
            
            document.querySelector(`.edit[data-id='${data.id}']`).addEventListener('click', ()=>{
                fileSample.val(null)
                linkFileSample.attr('src', "")
                linkFileSample.addClass("d-none")
                getDetail(data.id)
            });
            document.querySelector(`.delete[data-id='${data.id}']`).addEventListener('click', ()=>{
                Swal.fire({
                    title: "Apakah anda yakin ingin menghapus data?",
                    icon: 'question',
                    confirmButtonText: 'Hapus',
                    confirmButtonColor: '#dc3545',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#6C757D'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace(baseUrl + "/trans/sample/delete/list" + data.id);
                    }
                })
            });
            new Tabulator(`#dt-list-detail-${data.id}`, {
                data: data.detail, 
                layout:"fitColumns",
                pagination: true, 
                paginationSize: 10,
                paginationButtonCount: 5,
                columns:[
                    {title:"No", field:"no",   width: "5%"},
                    {title:"Colour", field:"colordasar", width:"20%"},
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
                    }, hozAlign:"right"},
                ],
            });
        });
    
        return cardHtml; // Return HTML Card
    }

    $("#btn-add").on("click", function(){
        inpData.val("")
        linkFileSample.addClass("d-none")
        linkFileSample.attr('src', "")
        fileSampleOld.val("")
        fileSample.val("")
        inpDeskripsi.val("")
        inpBuyer.val("").trigger("change")
        inpTglTransaksi.val("")
        inpTglDeadline.val("")
        inpKetSample.val("")
        rowDet.hide()
        $("#btn-save").hide()
        $("#btn-draft").show()
        isModal.modal("show");
    });

    $("#btn-add-detail").on("click", function(){
        idSample = inpData.val()
        idSampleDet = null
        inpPoWarna1.val('').trigger('change');
        inpPoWarna2.val('').trigger('change');
        inpPoWarna3.val('').trigger('change');
        inpPoWarna4.val('').trigger('change');
        inpPoWarna5.val('').trigger('change');
        inpPoWarna6.val('').trigger('change');
        inpPoWarna7.val('').trigger('change');
        inpPoWarna8.val('').trigger('change');
        getDetailQty(inpData.val(),0)
    });

    $("#btn-save").on("click", function(e){
        e.preventDefault()
        if(dtListDetail.getData().length > 0){
            Swal.fire({
                title: "Apakah anda ingin mensubmit data Sample ?",
                icon: 'question',
                confirmButtonText: 'Simpan',
                confirmButtonColor: '#198754',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6C757D'
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanData(1)
                }
            })
        } else{
            Swal.fire({
                text: "Detail data harus diisi",
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
    $("#btn-draft").on("click", function(e){
        e.preventDefault()
        simpanData(0)
    });
    $("#btn-save-detail").on("click", function(e){
        e.preventDefault()
        simpanDataDetail()
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
                idSample = id
                status = data.status
                rowDet.show()
                if(data.status == 1){
                    $("#btn-save").hide()
                    $("#btn-draft").hide()
                    $("#btn-add-detail").hide()
                } else{
                    $("#btn-save").show()
                    $("#btn-draft").show()
                    $("#btn-add-detail").show()
                }
                inpData.val(data.id)
                inpDeskripsi.val(data.deskripsi)
                fileSampleOld.val(data.gambar_id)
                inpKetSample.val(data.keterangan)
                inpBuyer.val(data.id_konsumen).trigger('change')
                inpTglDeadline.val(formatterDate(data.tgl_deadline))
                inpTglTransaksi.val(formatterDate(data.tgl_transaksi))
                if(data.file_gambar){
                    fileSampleOld.val(data.gambar_id)
                    linkFileSample.removeClass("d-none")
                    linkFileSample.attr('src', data.file_gambar)
                }
                
                dtListDetail.setData(data.detail)
                isModal.modal("show");

                setTimeout(() => {
                    dtListDetail.redraw(true)
                }, 500);
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
                isModal.modal("hide")
                if(status == 1){
                    $("#btn-save-detail").hide()
                } else{
                    $("#btn-save-detail").show()
                }
                noSampleText.html(data.kode_sample)
                deskripsiText.html(data.deskripsi)
                tglSampleText.html(formatterDate(data.tgl_transaksi))
                buyerText.html(data.nama)
                fotoText.attr("src",data.file_gambar)
                tglDeadlineText.html(`<em>Deadline: ${formatterDate(data.tgl_deadline)}</em>`)
                if(data.detail){
                    idSampleDet = data.detail.id
                    inpPoWarna1.val(data.detail.id_warna_1).trigger('change');
                    inpPoWarna2.val(data.detail.id_warna_2).trigger('change');
                    inpPoWarna3.val(data.detail.id_warna_3).trigger('change');
                    inpPoWarna4.val(data.detail.id_warna_4).trigger('change');
                    inpPoWarna5.val(data.detail.id_warna_5).trigger('change');
                    inpPoWarna6.val(data.detail.id_warna_6).trigger('change');
                    inpPoWarna7.val(data.detail.id_warna_7).trigger('change');
                    inpPoWarna8.val(data.detail.id_warna_8).trigger('change');
                }
               
                dtListDetailQty.setData(data.detailUkuran)
                isModalPO.modal("show");
                setTimeout(() => {
                    dtListDetailQty.redraw(true)
                }, 500);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function generateQRCode(data){
        $.ajax({
            type: 'POST',
            url: '/trans/sample/generate',
            data:{data:JSON.stringify(data)},
            dataType: "json",
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
                    const blob = base64ToBlob(response.file_base64, 'image/png');
                    const url = URL.createObjectURL(blob);
                    const downloadLink = document.createElement('a');
                    downloadLink.href = url;  
                    downloadLink.download = response.file_name; 

                    downloadLink.click();
                
                    URL.revokeObjectURL(url);
                    Swal.close();
                
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
    }

    function base64ToBlob(base64, contentType = '', sliceSize = 512) {
        const byteCharacters = atob(base64); // Hapus prefix "data:image/png;base64,"
        const byteArrays = [];
    
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
    
            const byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
    
        return new Blob(byteArrays, { type: contentType });
    }

    function deleteData($id) {
        
            $.ajax({
                type: 'POST',
                url: '/trans/sample/delete/detail',
                data: {id:$id},
                dataType: "json",
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
                        getDetail(idSample)
                        dtList.setData()
                        Swal.close();
                    
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
        
    }
    
    function simpanData(status) {
        
        let validation = true
        if(inpDeskripsi.val().length == 0) validation = false
        if(inpBuyer.val().length == 0) validation = false
        if(inpTglDeadline.val().length == 0) validation = false
        if(inpTglTransaksi.val().length == 0) validation = false
        if(fileSample[0].files[0] == undefined && fileSampleOld.val().length == 0) validation = false
    
        if(validation){
            var formData = new FormData();
            formData.append("id",inpData.val());
            formData.append("status",status);
            formData.append("deskripsi",inpDeskripsi.val());
            formData.append("fileSample",fileSample[0].files[0] == undefined ? null : fileSample[0].files[0] );
            formData.append("fileIdSampleOld",fileSampleOld.val());
            formData.append("idKonsumen",inpBuyer.val());
            formData.append("tglDeadline",formatLocaleDate(inpTglDeadline.val()));
            formData.append("tglTransaksi",formatLocaleDate(inpTglTransaksi.val()));
            formData.append("keterangan",inpKetSample.val());
            let data = dtListDetail.getData()
            if (data){
                const totalHarga = data.reduce((sum, item) => sum + parseFloat(item.harga_satuan), 0);
                const totalQty = data.reduce((sum, item) => sum + parseInt(item.s) +parseInt(item.m)+parseInt(item.l)+parseInt(item.xl)+parseInt(item.xxl)+parseInt(item.xxxl)+parseInt(item.all)     , 0);
                formData.append("qty",totalQty)
                formData.append("hargaTotal",totalHarga)
            }
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

    function simpanDataDetail() {
        if(inpPoWarna1.val() == "")
        {
            return Swal.fire({
                text: "Warna 1 Belum terpilih!",
                icon: 'warning',
                showConfirmButton: false,
                timer: 2000
            });
        }

        let dataUkuran = dtListDetailQty.getData().filter(x => x.qty && x.harga_satuan);
        if(dataUkuran.length ==0)
            {
                return Swal.fire({
                    text: "Ukuran Minimal satu harus diisi",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
    
            $.ajax({
                type: 'POST',
                url: '/trans/sample/save-detail',
                data: {
                    warna1:inpPoWarna1.val(),
                    warna2:inpPoWarna2.val(),
                    warna3:inpPoWarna3.val(),
                    warna4:inpPoWarna4.val(),
                    warna5:inpPoWarna5.val(),
                    warna6:inpPoWarna6.val(),
                    warna7:inpPoWarna7.val(),
                    warna8:inpPoWarna8.val(),
                    dataUkuran: dataUkuran,
                    idSample:idSample,
                    idSampleDet:idSampleDet,
                },
                dataType: "json",
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
                        Swal.close();
                        getDetail(idSample)
                        dtList.setData()
                        isModalPO.modal("hide");
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
        
    }
    
});

function readURL(input,id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        const imageUrl = e.target.result;
        const imgElement = document.getElementById('linkFileSample');
        imgElement.classList.remove("d-none");
        imgElement.src = imageUrl; // Set src dari <img> ke data URL
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
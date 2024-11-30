let inpBarang = $('#barang');
let inpIdBarang = $('#idBarang');
let inpJenisBarang = $('#jenis_barang');
let inpVendor = $('#nama_vendor');
let inpKonsumen = $('#nama_konsumen');
let inpTotalStok = $('#total_stok');
let inpJmlStok = $('#jml_keluar');
let inpStok = $('#stok'); 
let inpStokTujuan = $('#stok_tujuan'); 
let inpTanggal = $('#tanggal');
let inpKeterangan = $('#keterangan');
let spanSatuan = $('#satuan');
let selectKategori = $('#select_kategori');
let selectGudangAsal = $('#select_gudang_asal');
let selectGudangTujuan = $('#select_gudang_tujuan');
let divGudangAsal = $('#divGudangAsal');
let divGudangTujuan = $('#divGudangTujuan');
let divNamaKonsumen = $('#divNamaKonsumen');
let divNamaVendor = $('#divNamaVendor');
let divStokGudangAsal = $('#divStokGudangAsal');
let spanVendor = $('#spanVendor');
let spanKonsumen = $('#spanKonsumen');
let btnSave = $('#save');


let dtList = new Tabulator("#dt-list", {
    columns: [
        {
            title: "ID Barang", field: "id", headerSort: false,
            width: "15%",visible:false
        },
        {
            title: "Kode Barang", field: "kode_barang", headerSort: false,
            width: "20%"
        },
        {
            title: "Nama Barang", field: "nama_barang", headerSort: false,
            width: "30%"
        },
        {
            title: "Jenis Barang", field: "nama_jenis_barang", headerSort: false,
            width: "25%"
        },
        {
            title: "Stok Minimum", field: "stok_minimum", headerSort: false,
            width: "15%",visible:false
        },
        {
            title: "Satuan", field: "nama_satuan", headerSort: false,
            width: "10%"
        },
        {
            title: "Harga Satuan",visible:false, field: "harga_satuan", headerSort: false,
            width: "15%",formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right",
        },
       
        {
            title: "Keterangan", field: "keterangan", formatter: "html", headerSort: false,
            width:"15%"
        },
    ],
    locale: 'id',    
    ajaxURL: "/master-data/barang/list",
    ajaxConfig: "POST",
    sortMode: "remote",
    filterMode: "remote",
    selectableRows: true,
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

selectKategori.on("change",function(e){
    var nilai = e.target.value;
    if(nilai == 4){
        divGudangAsal.removeClass("d-none")
        divGudangTujuan.removeClass("d-none")
        divNamaVendor.addClass("d-none")
        divNamaKonsumen.addClass("d-none")
        divStokGudangAsal.removeClass("d-none")
    } else if(nilai == 8){
        divGudangAsal.removeClass("d-none")
        divGudangTujuan.addClass("d-none")
        divNamaVendor.removeClass("d-none")
        divNamaKonsumen.addClass("d-none")
        divStokGudangAsal.addClass("d-none")
    
    } else if(nilai == 6){
        divGudangAsal.removeClass("d-none")
        divGudangTujuan.addClass("d-none")
        divNamaVendor.addClass("d-none")
        divNamaKonsumen.removeClass("d-none")
        divStokGudangAsal.addClass("d-none")
    
    } else if(nilai == 5){
        divGudangAsal.removeClass("d-none")
        divGudangTujuan.addClass("d-none")
        divNamaVendor.addClass("d-none")
        divNamaKonsumen.addClass("d-none")
        divStokGudangAsal.addClass("d-none")
    } else if(nilai == 7){
        divGudangAsal.removeClass("d-none")
        divGudangTujuan.addClass("d-none")
        divNamaVendor.addClass("d-none")
        divNamaKonsumen.addClass("d-none")
        divStokGudangAsal.addClass("d-none")
    }
})

dtList.on("rowClick", function(e, row){
    if(selectKategori.val().length == 0){
        return Swal.fire({
            text: "Kategori harus dipilih",
            icon: 'error',
            showConfirmButton: false,
            timer: 2000
        });
    }
    if(selectKategori.val().length> 0){
        if(selectKategori.val() == 4){
            if(selectGudangAsal.val() == 0 || selectGudangTujuan.val() == 0){
                return Swal.fire({
                    text: "Gudang Asal dan Gudang Tujuan harus dipilih",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        } else if(selectKategori.val() == 4 || selectKategori.val() == 5  || selectKategori.val() == 6 || selectKategori.val() == 7 || selectKategori.val() == 8){
            if(selectGudangAsal.val() == 0){
                return Swal.fire({
                    text: "Gudang Asal harus dipilih",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
       
    }
    var kodeBarang = row._row.data.kode_barang.replace(/<[^>]*>/g, '');
    var idBarang = row._row.data.id;
    var namaBarang = row._row.data.nama_barang.replace(/<[^>]*>/g, '');
    var namaJenisBarang = row._row.data.nama_jenis_barang.replace(/<[^>]*>/g, '');
    var namaSatuan = row._row.data.nama_satuan.replace(/<[^>]*>/g, '');
    inpJenisBarang.val(namaJenisBarang)
    inpIdBarang.val(idBarang)
    inpBarang.val(`${kodeBarang} - ${namaBarang}`)
    spanSatuan.html(namaSatuan)
   
    getLastStock(idBarang, selectGudangTujuan.val(),selectGudangAsal.val())
    $("#modal-barang").modal("hide");
})

let dtListVendor = new Tabulator("#dt-list-vendor", {
    columns: [
        
        {
            title: "Nama Vendor", field: "nama", headerSort: false,
            width: "25%"
        },
        {
            title: "Alamat", field: "alamat", formatter: "html", headerSort: false,
             width: "45%"
            
        },
        {
            title: "Email", field: "email", headerSort: false,
            width: "15%", cssClass : 'text-center'
        },
        {
            title: "No. HP", field: "no_hp", headerSort: false,
            width: "15%", cssClass : 'text-center'
        },
    ],
    locale: 'id',    
    ajaxURL: "/master-data/vendor/list",
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

        $("#table-footer2 .tabulator-startrow").text(startRow);
        $("#table-footer2 .tabulator-endrow").text(endRow);
        $("#table-footer2 .tabulator-totalrow").text(recordsFiltered);

        let elTotalFilteredRow = $("#table-footer2 .tabulator-totalfilteredrow");
        elTotalFilteredRow.text("");
        if (recordsTotal > recordsFiltered) {
            elTotalFilteredRow.text(" (disaring dari " + recordsTotal
                + " entri keseluruhan)");
        }
        return response;
    },
    footerElement: '<div id="table-footer2" class="pull-left tabulator-info">'
        + 'Menampilkan <span class="tabulator-startrow"></span> - <span class="tabulator-endrow"></span> dari '
        + '<span class="tabulator-totalrow"></span> entri<span class="tabulator-totalfilteredrow"></span></div>',
    pagination: true,
    paginationMode: "remote",
    paginationSize: 25,
    paginationButtonCount: 10,
    dataSendParams: {
        sorters: "order"
    },
    selectableRows: false,
});


let searchThreadVendor = null;
let elSearchVendor = $("#tb-search2");
if (elSearchVendor != null) {
    elSearchVendor.on("keyup", function (e) {
        if ($(this).val().length < 3 && e.keyCode > 13) {
            return;
        }
        clearTimeout(searchThreadVendor);
        searchThreadVendor = setTimeout(function () {
            dtListVendor.setFilter("", "like", elSearchVendor.val());
        }, 600);
    });
}

dtListVendor.on("rowClick", function(e, row){
    var namaVendor = row._row.data.nama.replace(/<[^>]*>/g, '');
    inpVendor.val(namaVendor)
    $("#modal-vendor").modal("hide");
})

let dtListKonsumen = new Tabulator("#dt-list-konsumen", {
    columns: [
        {
            title: "Nama Konsumen", field: "nama", headerSort: false,
            width: "25%"
        },
        {
            title: "Alamat", field: "alamat", formatter: "html", headerSort: false,
             width: "45%"
            
        },
        {
            title: "Email", field: "email", headerSort: false,
            width: "15%", cssClass : 'text-center'
        },
        {
            title: "No. HP", field: "no_hp", headerSort: false,
            width: "15%", cssClass : 'text-center'
        },
    ],
    locale: 'id',    
    ajaxURL: "/master-data/konsumen/list",
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

        $("#table-footer3 .tabulator-startrow").text(startRow);
        $("#table-footer3 .tabulator-endrow").text(endRow);
        $("#table-footer3 .tabulator-totalrow").text(recordsFiltered);

        let elTotalFilteredRow = $("#table-footer3 .tabulator-totalfilteredrow");
        elTotalFilteredRow.text("");
        if (recordsTotal > recordsFiltered) {
            elTotalFilteredRow.text(" (disaring dari " + recordsTotal
                + " entri keseluruhan)");
        }
        return response;
    },
    footerElement: '<div id="table-footer3" class="pull-left tabulator-info">'
        + 'Menampilkan <span class="tabulator-startrow"></span> - <span class="tabulator-endrow"></span> dari '
        + '<span class="tabulator-totalrow"></span> entri<span class="tabulator-totalfilteredrow"></span></div>',
    pagination: true,
    paginationMode: "remote",
    paginationSize: 25,
    paginationButtonCount: 10,
    dataSendParams: {
        sorters: "order"
    },
    selectableRows: false,
});


let searchThreadKonsumen = null;
let elSearchKonsumen = $("#tb-search3");
if (elSearchKonsumen != null) {
    elSearchKonsumen.on("keyup", function (e) {
        if ($(this).val().length < 3 && e.keyCode > 13) {
            return;
        }
        clearTimeout(searchThreadKonsumen);
        searchThreadKonsumen = setTimeout(function () {
            dtListKonsumen.setFilter("", "like", elSearchKonsumen.val());
        }, 600);
    });
}

dtListKonsumen.on("rowClick", function(e, row){
    var namaKonsumen = row._row.data.nama.replace(/<[^>]*>/g, '');
    inpKonsumen.val(namaKonsumen)
    $("#modal-konsumen").modal("hide");
})

selectGudangTujuan.change(function(e){
    inpBarang.val("")
    inpJenisBarang.val("")
    inpIdBarang.val("")
    inpStok.val("")
    inpJmlStok.val("")
    inpTotalStok.val("")
    spanSatuan.html("")
    inpKonsumen.val("")
    inpVendor.val("")
   
})
selectGudangAsal.change(function(e){
    inpBarang.val("")
    inpJenisBarang.val("")
    inpIdBarang.val("")
    inpStok.val("")
    inpJmlStok.val("")
    inpTotalStok.val("")
    spanSatuan.html("")
    inpKonsumen.val("")
    inpVendor.val("")
    selectGudangTujuan.val("").trigger("change")
})
selectKategori.change(function(e){
    selectGudangAsal.val("").trigger("change")
    selectGudangTujuan.val("").trigger("change")
    inpBarang.val("")
    inpJenisBarang.val("")
    inpIdBarang.val("")
    inpStok.val("")
    inpJmlStok.val("")
    inpTotalStok.val("")
    spanSatuan.html("")
    inpKonsumen.val("")
    inpVendor.val("")
})

inpBarang.click(function () {
    setTimeout(() => {
        dtList.redraw(true)
    }, 500);
    $("#modal-barang").modal("show");
    dtList.deselectRow();
});
inpJmlStok.keyup(function (e) {
    if(inpJmlStok.val() != ""){
            if(parseFloat(e.target.value) > parseFloat(inpStok.val())){
                e.target.value = ""
                return Swal.fire({
                    text: "Gudang Asal tidak memiliki stok yang cukup",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        let totalStok = parseFloat(inpStok.val()) - parseFloat(e.target.value)
        inpTotalStok.val(totalStok)
    }
});
spanKonsumen.click(function () {
    setTimeout(() => {
        dtListKonsumen.redraw(true)
    }, 500);
    $("#modal-konsumen").modal("show");
    dtListKonsumen.deselectRow();
});
spanVendor.click(function () {
    setTimeout(() => {
        dtListVendor.redraw(true)
    }, 500);
    $("#modal-vendor").modal("show");
    dtListVendor.deselectRow();
});
btnSave.click(function () {
    Swal.fire({
        title: "Apakah anda ingin mensubmit data Produksi?",
        icon: 'question',
        confirmButtonText: 'Simpan',
        confirmButtonColor: '#198754',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        cancelButtonColor: '#6C757D'
    }).then((result) => {
        if (result.isConfirmed) {
            simpanData()
        }
    })
  
});

function simpanData() {
        
    let validation = true
    if(selectKategori.val().length == 0) validation = false
    if(selectKategori.val() > 0){
        if(selectKategori.val() == 4){
            if(selectGudangAsal.val() == 0 || selectGudangTujuan.val() == 0){
                validation = false
            }
            if(parseFloat(inpJmlStok) > parseFloat(inpStok.val())){
                return Swal.fire({
                    text: "Gudang Asal tidak memiliki stok yang cukup",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        } else if(selectKategori.val() == 4 || selectKategori.val() == 5  || selectKategori.val() == 6 || selectKategori.val() == 7 || selectKategori.val() == 8){
            if(selectGudangAsal.val() == 0){
                validation = false
            }
        }
    }
    if(inpJmlStok.val().length == 0) validation = false
    if(inpTotalStok.val().length == 0) validation = false
    if(inpStok.val().length == 0) validation = false
    if(inpBarang.val().length == 0) validation = false

    if(validation){
        $.ajax({
            type: 'POST',
            url: '/trans/outgoing-goods/simpan',
            data: {
                idBarang   : inpIdBarang.val(),
                keterangan : inpKeterangan.val(),
                namaKonsumen  : inpKonsumen.val(),
                namaVendor  : inpVendor.val(),
                jmlMasuk  : inpJmlStok.val(),
                totalStok  : inpTotalStok.val(),
                tanggal : formatLocaleDate(inpTanggal.val()),
                idGudangAsal : selectGudangAsal.val(),
                idGudangTujuan : selectGudangTujuan.val(),
                idKategori :selectKategori.val(),
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
                    window.location.href = 'trans/outgoing-goods'
                
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

function getLastStock(idBarang,idGudangTujuan,idGudangAsal){
    $.ajax({
        type: 'POST',
        url: '/trans/outgoing-goods/last-stock',
        data:{idBarang:idBarang,idGudangTujuan:idGudangTujuan,idGudangAsal:idGudangAsal},
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
                inpStok.val(response.stok)
                inpStokTujuan.val(response.stokTujuan)
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

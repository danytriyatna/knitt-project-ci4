

$(document).ready(function () {
    let inpData         = $('#data_id');
    let inpNamaOperator = $('#nama_operator');
    let inpAlamat       = $('#alamat');
    let inpNoHP         = $('#no_hp');
    let inpTglBergabung        = $('#tgl_bergabung');
    let inpHarga        = $('#harga');

    let isModal       = $("#modal-form-add-po");

    let buttonRowAction = function(cell) {
        let fmBtnDelete = "";        
        let fmBtnEdit = "";        
        fmBtnDelete = "<button class='btn btn-danger btn-xs open_form' type='button' title='delete'><i class='fa fa-trash' title='delete'></i></button>";
        fmBtnEdit = "<button class='btn btn-warning btn-xs open_form' type='button' title='edit'><i class='fa fa-edit' title='edit'></i></button>";
        return fmBtnEdit + " " + fmBtnDelete;
    };

    let dtList = new Tabulator("#dt-list", {
        columns: [
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
                            window.location.replace(baseUrl + "/master-data/operator/delete/" + data_row.id);
                        }
                    }else if(e.target.title === 'edit'){
                        inpData.val(data_row.id)
                        inpNamaOperator.val(data_row.nama_operator)
                        inpAlamat.val(data_row.alamat)
                        inpNoHP.val(data_row.no_hp)
                        inpHarga.val(data_row.harga)
                        inpTglBergabung.val(data_row.tgl_bergabung)

                        isModal.modal("show");
                    }   
                }
            },
            {
                title: "Nama Operator", field: "nama_operator", headerSort: false,
                width: "20%"
            },
            {
                title: "No HP", field: "no_hp", headerSort: false,
                width: "20%"
            },
            {
                title: "Alamat", field: "alamat", formatter: "html", headerSort: false,
                
            },
            {
                title: "Tgl Bergabung", field: "tgl_bergabung", headerSort: false,
                width: "20%", cssClass : 'text-center'
            },
            {
                title: "Harga", field: "harga", headerSort: false,
                width: "20%", cssClass : 'text-center',formatter: "money",formatterParams: {
                    decimal: ",",
                    thousand: ".",
                    symbol: "Rp",  // Simbol mata uang Rupiah
                    precision: 0,   // Tidak ada desimal
                }, hozAlign:"right"
            },
        ],
        locale: 'id',    
        layout: 'fitColumns',
        ajaxURL: "/master-data/operator/list",
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

    $("#btn-add").on("click", function(){
        inpData.val("")
        inpNamaOperator.val("")
        inpAlamat.val("")
        inpNoHP.val("")
        inpHarga.val("")
        inpTglBergabung.val("")

        isModal.modal("show");
    });

    $("#btn-save").on("click", function(e){
        e.preventDefault()
        simpanData()
    });

    inpHarga.on("input", function(e){
        let value = e.target.value.replace(/[^,\d]/g, '').toString();

        // Pisahkan angka menjadi ribuan
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/g);

        // Tambahkan titik jika ada ribuan
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // Gabungkan dengan bagian desimal, jika ada
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        e.target.value = rupiah ? 'Rp ' + rupiah : '';
    })

    inpNoHP.on('input', function (e) {
        let value = e.target.value;

        // Jika pengguna mencoba menghapus "+62", tambahkan kembali
        if (!value.startsWith('+62')) {
            e.target.value = '+62' + value.replace(/\D/g, ''); // Pastikan hanya angka setelah "+62"
        } else {
            // Batasi input hanya angka setelah "+62"
            e.target.value = value.replace(/[^0-9\+]/g, '').replace(/^62\+/, '+62');
        }
    });

    // Mencegah pengguna memindahkan cursor ke prefix
    inpNoHP.on('keydown', function (e) {
        if (inpNoHP.selectionStart < 3) {
            e.preventDefault();
            inpNoHP.setSelectionRange(inpNoHP.value.length, inpNoHP.value.length);
        }
    });

    
    function simpanData() {
        
        let validation = true
        if(inpNamaOperator.val().length == 0) validation = false
        if(inpNoHP.val().length == 0) validation = false
        if(inpHarga.val().length == 0) validation = false
        if(inpAlamat.val().length == 0) validation = false
    
        if(validation){
            $.ajax({
                type: 'POST',
                url: '/master-data/operator/simpan',
                data: {
                    dataId : inpData.val(),
                    nama_operator   : inpNamaOperator.val(),
                    alamat : inpAlamat.val(),
                    harga  : inpHarga.val(),
                    tgl_bergabung  : inpTglBergabung.val(),
                    no_hp  : inpNoHP.val(),
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

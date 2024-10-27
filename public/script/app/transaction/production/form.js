
$(document).ready(function () {

    let statusProses = $("#filter_status")
    let tglTransaksi = $("#tgl_prod")
    let operator = $("#filter_operator")
    const prosesMap = {
        1: "#proses_1",
        2: "#proses_2",
        3: "#proses_3",
        4: "#proses_4",
        5: "#proses_5",
        6: "#proses_6",
        7: "#proses_7",
    };
    
    // conf function 
    let cellMoney = function(cell, formatterParams){
        let classN = "text-right tabulator-cell text-end";
        cell.getElement().className = classN;
    
        let isVal = number_format(cell.getValue(), 2, ',', '.'); 
        return isVal; //return the contents of the cell;
    }

    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function calculateTotal(row) {
        if(row){
          
            let qty = row.qty || 0;
            let harga = row.harga || 0;
            return qty * harga;
        }
    }

    // table detail 
    let dtListDetail = new Tabulator("#dt-detail", {
        columns: [
                {
                    title: "Colour", field: "colordasar",  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
                    width:"17%"
                },
                {
                    title: "S", field: "s",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },
                {
                    title: "M", field: "m",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },

                {
                    title: "L", field: "l",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },

                {
                    title: "XL", field: "xl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },

                {
                    title: "XXL", field: "xxl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },

                {
                    title: "3XL", field: "xxxl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", 
                },

                {
                    title: "All", field: "all",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%", bottomCalc:"sum", 
                },

                {
                    title: "QTY", field: "qty",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%", bottomCalc:"sum", 
                },
                {
                    title: "QTY<br>PRODUKSI", field: "qty_prod",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%", bottomCalc:"sum", 
                }
            ],
            locale: 'id',
            placeholder: "Tidak ada data",
            pagination: false,
            paginationSize: 99,
            paginationButtonCount: 2,
            paginationDataSent: {
                sorters: "order",
            },
            selectable: false
	});

    let detail_data = $("#data-details").val().replace(/&quot;/ig,'"');

    if(detail_data.length > 0){
        setTimeout(() => {
            try {
                let isdata = JSON.parse(detail_data);
                
                // Set data ke Tabulator
                dtListDetail.setData(isdata);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        }, 1000);
    } 

    let buttonRowAction = function(cell) {
        let fmBtnDelete = ""
        var data = cell.getRow().getData(); // Ambil data row
        if (data.flag != 1){
            fmBtnDelete = `<button type="button" class="btn btn-sm btn-danger" title='delete'><i class="fa fa-trash" title='delete'></i></button>`;
        }
        return fmBtnDelete;
    };

    let dtListProd = new Tabulator("#dt-list-prod", {
        pagination: true, 
        paginationSize: 10,
        paginationButtonCount: 5,
        columns:[
            {title:"ID", field:"id", visible:false},
            {field:"id_walkorder_proses_ukuran", visible:false},
            {field:"id_operator", visible:false},
            {field:"tgl_transaksi", visible:false},
            {field:"id_ukuran", visible:false},
            {field:"id_warna", visible:false},
            {field:"flag", visible:false},
            {
                headerSort: false,  
                title: '#', 
                formatter: buttonRowAction,
                width: '5%', align: "center", cssClass: "text-center",
                cellClick: function(e, cell) {
                    let row = cell.getRow();
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
                                row.delete(); 
                            }
                        })
                    }
                }
            },
            {title:"Date", field:"date", width:"10%"},
            {title:"Colour", field:"kode_warna", hozAlign:"left",width:"15%"},
            {title:"Process", field:"process", hozAlign:"left",width:"10%"},
            {title:"Operator", field:"operator", hozAlign:"left",width:"15%"},
            {title:"Size", field:"kode_ukuran", hozAlign:"left",width:"5%"},
            {title:"QTY", field:"qty", hozAlign:"center",width:"10%",editor: "number",cellEdited: updateTotal},
            {title:"Price", field:"harga", hozAlign:"right",width:"15%",formatter: "money",formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right"},
            {title:"Total", width:"15%", field:"harga_total",formatter: "money", formatterParams: {
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

    let listProd = $("#data-prods").val().replace(/&quot;/ig,'"');

    if(listProd.length > 0){
        setTimeout(() => {
            try {
                let isdata = JSON.parse(listProd);
                
                // Set data ke Tabulator
                dtListProd.setData(isdata);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        }, 1000);
    } 

    

    // Table Penguji
    let dtListUkuran = new Tabulator("#dt-list-ukuran", {
        columns: [
        {title:"ID", field:"id", visible:false},
        {field:"id_ukuran", visible:false},
        {field:"id_warna", visible:false},
        {field:"id_walkorder_proses", visible:false},
        {
            title: 'Colour', field: 'kode_warna', headerSort:true, formatter: "html", sorter: 'string',
            width: '30%'
        }, 
  
        {
            title: 'Size', field: 'kode_ukuran', headerSort:false, formatter: "html", sorter: 'string',
            width: '30%'
        }, 
  
        {
            title: 'QTY', field: 'qty', headerSort:false, formatter: "html", sorter: 'string', visible:false,
            width: '15%'
        }, 
  
        {
            title: 'Amount', field: 'harga_satuan', headerSort:false, formatter: "html",
            width: '40%',formatter: "money", formatterParams: {
                decimal: ",",
                thousand: ".",
                symbol: "Rp",  // Simbol mata uang Rupiah
                precision: 0,   // Tidak ada desimal
            }, hozAlign:"right"
        }, 
        ],
        ajaxURL: "trans/production/list_ukuran",
        ajaxConfig: "POST",
        sortMode: "remote",
        filterMode: "remote",
        dataTree:true,
        dataTreeStartExpanded:true,
        ajaxRequesting: function (url, params) {
            params.start = params.size * (params.page - 1);
            params.length = params.size;
            params.tipe_id = $("#tipe_id").val()
            params.ref_id = $("#ref_id").val()
            params.id_proses = statusProses.val()
        },
        ajaxResponse: function (url, params, response) {
            let pageSize = dtListUkuran.getPageSize();
            let pageNo = dtListUkuran.getPage();
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
        paginationSize: 10,
        paginationButtonCount: 10,
        dataSendParams: {
            sorters: "order"
        },
        selectableRows: true,
    });
  
    dtListUkuran.on("rowClick", function(e, row){
        let data =  row.getData()

        if (statusProses.val().length == 0){
            return Swal.fire({
                text: "Status harus dipilih",
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }
        if (operator.val().length == 0){
            return Swal.fire({
                text: "Operator harus dipilih",
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }
        if (tglTransaksi.val().length == 0){
            return Swal.fire({
                text: "Tanggal harus diisi",
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }

        // if (dtListProd.getData().some(x => x.id_ukuran == data.id_ukuran && x.id_walkorder_proses_ukuran == data.id_walkorder_proses_ukuran)){
        //     return Swal.fire({
        //         text: "Data sudah dipilih, silahkan pilih data yang lain",
        //         icon: 'error',
        //         showConfirmButton: false,
        //         timer: 2000
        //     });
        // }

        if(!data.harga_satuan){
            return Swal.fire({
                text: "Data ukuran, tidak terdapat dalam sample",
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }
     
        // Mengecek kondisi berdasarkan nilai statusProses
        if (prosesMap[statusProses.val()] && $(prosesMap[statusProses.val()]).val() <= 0) {
            return Swal.fire({
                text: `Tidak bisa memilih status ${$("#filter_status option:selected").text()} , stok tidak tersedia`,
                icon: 'error',
                showConfirmButton: false,
                timer: 2000
            });
        }

        console.log(data.id_walkorder_proses_ukuran)

        dtListProd.addRow({
            id:data.id,
            kode_warna:data.kode_warna,
            kode_ukuran:data.kode_ukuran,
            id_ukuran:data.id_ukuran,
            id_warna:data.id_warna,
            harga:data.harga_satuan,
            qty:1,
            harga_total:data.harga_satuan,
            flag:0,
            id_walkorder_proses_ukuran:data.id_walkorder_proses,
            id_proses:statusProses.val(),
            id_operator:operator.val(),
            operator:$('#filter_operator option:selected').text(),
            process:$('#filter_status option:selected').text(),
            date:formatLocaleDate(tglTransaksi.val())
            
        });
      
        $("#modal-list-wo").modal("hide");
    });
  
    let searchThread2 = null;
    let elSearch2 = $("#tb-search2");
    if (elSearch2 != null) {
        elSearch2.change(function (e) {
            if ($(this).val().length < 3 && e.keyCode > 13) {
                return;
            }
            clearTimeout(searchThread2);
            searchThread2 = setTimeout(function () {
                dtListUkuran.setFilter("", "like", elSearch2.val());
            }, 600);
        });
    }


    function updateTotal(cell) {
        let row = cell.getRow();
        if (row) { 
            const selectedProses = prosesMap[statusProses.val()];
            if (selectedProses && row.getData().qty >= $(selectedProses).val()) {
                cell.restoreOldValue();
                Swal.fire({
                    text: "Quantity tidak boleh melebihi stok.",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
            let newTotal = calculateTotal(row.getData());
            row.update({ harga_total: newTotal });
        } 
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

    

    $("#btn-add-detail").click(function () {
            // dtListUkuran.setData()
            $("#modal-list-wo").modal("show");
            dtListUkuran.deselectRow();
    });

    $("#btn-save-ukuran").on("click", function(e){
        e.preventDefault()
        if(dtListProd.getData().filter(x => x.flag == 0).length > 0){
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
                    simpanDataDetail()
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

    function simpanDataDetail() {
        $.ajax({
            type: 'POST',
            url: '/trans/production/save',
            data: {
                idProduksi:$("#id_produksi").val(),
                idWorkOrder:$("#id_walkorder").val(),
                data:dtListProd.getData().filter(x => x.flag == 0),
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
                    location.reload();
                  
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
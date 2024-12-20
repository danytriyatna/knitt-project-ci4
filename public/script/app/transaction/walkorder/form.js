
$(document).ready(function () {


    // conf function 
    let cellMoney = function(cell, formatterParams){
        const isEditable = cell.getElement().className.indexOf('tabulator-editable') >= 0
        let classN = `text-right tabulator-cell text-end${isEditable ? ' tabulator-editable' : ''}`;
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
                    width:"10%", bottomCalc:"sum", visible: false
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
            selectableRows: false
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


    let detailp = $("#data-psaved").val().replace(/&quot;/ig,'"');
    if(detailp.length > 0){
        setTimeout(() => {
            try {
                let isdatap = JSON.parse(detailp);
                
                for (const item of isdatap) {
                    let idw = 'proses_' + item.id_proses;
                    $('#' + idw).attr("checked", true);
                }
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        }, 1000);
    }

    // end config ukuran size 


    // start detail 
    let btnSaveWarna = $("#btn-save-warna");
    let textTitleWarna = $("#text-title-warna")
    let textQtyWarna = $("#text-qty-warna")
    let mdDetail = $("#modal-form-wo");
    let textDetId = $("#detail_id");
    let fmEditDetail = function(value, data, cell, row, options) {
		let row_data = value._cell.row.data;
		let fmBtnEdit = "<button class='btn btn-xs btn-warning' type='button' title='edit'><i class='fa fa-edit' title='edit'></i></button>";
		
		let btnRes = fmBtnEdit;
		return btnRes; //+ "&nbsp;" + fmBtnDelete;
	};

    let dtList_detail1 = new Tabulator("#dt-list-warna", {
        columns: [
            {
                title: " ", field: "aksi", headerSort: false, formatter: fmEditDetail,
                width: 100,
                cellClick: function(e, cell) {
                    if (e.target.title === 'edit') {
                        let rowData = cell.getRow().getData();
                        textDetId.val(rowData.id);
                        textTitleWarna.html(rowData.wdasar);
                        textQtyWarna.html(rowData.qty);
                        inpDetailLoss.val(rowData.loss);
                        
                        dtListDetailWarna.setData(rowData.details)
                        mdDetail.modal("show");
                    }
                }
            },
            
			{
				title: 'Colour', field: 'wdasar', headerSort:false, sorter: 'string',
				formatter : "html"
			}, 
				
			{
				title: 'Qty', field: 'qty', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney
			}, 
				
			{
				title: 'Gram', field: 'gram', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			}, 

            {
				title: 'Needs', field: 'gram_nd', formatter : "html", align: "center", cssClass: "text-center", headerSort:false,
                width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			} ,

            {
				title: 'KG', field: 'kg', formatter : "html", align: "center", cssClass: "text-center", headerSort:false,
                width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			},

            {
				title: 'Loss (KG)', field: 'kg_loss', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			},

            {
				title: 'NFP (KG)', field: 'total', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			},
            
            {
				title: 'Stock', field: 'kuota', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			},

            {
				title: 'Margin', field: 'kuota_tambah', headerSort:false, sorter: 'string',
				width: 140, bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney 
			},
				
        ],
        layout: 'fitColumns',
        ajaxURL: "/trans/work-order/list_warna",
        placeholder: "Tidak ada data",
        ajaxConfig: "POST",
        ajaxSorting: true,
        ajaxFiltering: false,
        sortMode: "remote",
        filterMode: "remote",
        minHeight: 300,
        ajaxRequesting: function (url, params) {
            params.start = params.size * (params.page - 1);
            params.length = params.size;
            params.woid = $("#dataid").val();
        },
        ajaxResponse: function (url, params, response) {
            let pageSize = dtList_detail1.getPageSize();
            let pageNo = dtList_detail1.getPage();
            let startRow = (pageSize * (pageNo - 1)) + 1;
            let endRow = response.data.length + startRow - 1;
            if (response.data.length === 0) {
                startRow = 0; endRow = 0;
            }
            let recordsFiltered = parseInt(response.recordsFiltered);
            let recordsTotal = parseInt(response.recordsTotal);

            $("#table-footer-det .tabulator-startrow").text(startRow);
            $("#table-footer-det .tabulator-endrow").text(endRow);
            $("#table-footer-det .tabulator-totalrow").text(recordsFiltered);

            let elTotalFilteredRow = $("#table-footer-det .tabulator-totalfilteredrow");
            elTotalFilteredRow.text("");
            if (recordsTotal > recordsFiltered) {
                elTotalFilteredRow.text(" (disaring dari " + recordsTotal
                    + " entri keseluruhan)");
            }
            return response;
        },
        footerElement: '<div id="table-footer-det" class="pull-left tabulator-info">'
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
    


    // start table detail warna 
    let inpDetailLoss = $("#loss_perc");
    let dtListDetailWarna = new Tabulator("#dt-warna", {
        columns: [
                {
                    title: "Colour", field: "kode_warna",  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
                    width:"15%"
                },
                {
                    title: "%", field: "persen",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"11%"
                },
                {
                    title: "GRAM", field: "gram",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end tabulator-editable",
                    width:"11%", editor: "number", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                    cellEdited: function (cell) {

                        let qty = textQtyWarna.html()
                        // Dapatkan baris data yang telah diedit
                        let rowData = cell.getRow().getData();
                        let tableColumn = cell._cell.column.cells;
                        let total_gram = 0;
                        if(tableColumn.length > 0){
                            let index_total = tableColumn.length - 1;
                            total_gram = tableColumn[index_total].value
                        }
                        updateRow(rowData, total_gram)
                        let val_gram = rowData.gram ? rowData.gram : 0;
                        // let val_persen = total_gram > 0 ? (rowData.gram/total_gram) * 100 : 0;
                        //     val_persen = val_persen > 0 ? val_persen.toFixed(2) : 0;
                        let val_gram_nd = val_gram * qty;
                        let val_kg = val_gram_nd / 1000;
                            // val_kg = val_kg > 0 ? val_kg.toFixed(2) : 0;
                        let val_kg_loss = inpDetailLoss.val().length > 0 ? (val_kg * inpDetailLoss.val())/ 100 : 0
                            // val_kg_loss = val_kg_loss > 0 ? val_kg_loss.toFixed(2) : 0;

                        let val_total = parseFloat(val_kg) + parseFloat(val_kg_loss);
                            // val_total = val_total > 0 ? val_total.toFixed(2) : 0
                        let val_kuota = 0;
                            // val_kuota    = val_kuota    > 0 ? val_kuota   .toFixed(2) : 0
                        let val_kuota_tambah =  val_kuota - val_total
            
                        // Set nilai total di baris yang sama
                        cell.getRow().update({ 
                            // persen: val_persen,
                            gram_nd: val_gram_nd,
                            kg: val_kg,
                            kg_loss: val_kg_loss,
                            total: val_total,
                            kuota: val_kuota,
                            kuota_tambah: val_kuota_tambah,
                         });
                    },
                },
                {
                    title: "NEEDS<br>(GRAM)", field: "gram_nd",  sorter: "string", headerSort:false,  align: "center", cssClass: "text-end",
                    width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                },

                {
                    title: "IN KG", field: "kg",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                },

                {
                    title: "LOSS<br>(KG)", field: "kg_loss",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                },

                {
                    title: "NFP (KG)", field: "total",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                },

                {
                    title: "QTY<br>ON HAND", field: "kuota",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"12%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
                },

                {
                    title: " (+/-) ", field: "kuota_tambah",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
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
            selectableRows: false
	});


    function updateRow(data, total){
        let rows = dtListDetailWarna.getRows();
        rows.forEach(row => {
            let rowData = row.getData();
            let val_persen = total > 0 ? (rowData.gram/total) * 100 : 0;
                             val_persen = val_persen > 0 ? val_persen.toFixed(2) : 0;
            row.update({ persen: val_persen });
        });
    }   

    inpDetailLoss.on("change", function(){
        let val = $(this).val()
        let rows = dtListDetailWarna.getRows();
        rows.forEach(row => {
            let rowData = row.getData();
            let val_kg = rowData.kg;

            let val_kg_loss = val.length > 0 ? (val_kg * val) / 100 : 0
                val_kg_loss = val_kg_loss > 0 ? val_kg_loss.toFixed(2) : 0;

            let val_total = parseFloat(val_kg) + parseFloat(val_kg_loss);
                val_total = val_total > 0 ? val_total.toFixed(2) : 0

            let val_kuota = 0;//parseFloat(val_kg) - parseFloat(val_kg_loss);
                val_kuota    = val_kuota    > 0 ? val_kuota   .toFixed(2) : 0

            let val_kuota_tambah = val_kuota - val_total;

            row.update({
                kg_loss: val_kg_loss,
                total: val_total,
                kuota: val_kuota,
                kuota_tambah: val_kuota_tambah,
            });
        });
    });

    function save_warna(){
        let inpQty = textQtyWarna.html();
        let inLoss = inpDetailLoss.val();
        let inDetailID = textDetId.val();
        let inData = dtListDetailWarna.getData().length > 0 ? JSON.stringify(dtListDetailWarna.getData()) : "[]";

        let form_data = new FormData();
        form_data.append('detail_qty', inpQty);
        form_data.append('detail_loss', inLoss);
        form_data.append('detail', inDetailID);
        form_data.append('warna_data', inData);
        
        $.ajax({
            url: "/trans/work-order/save-warna", // point to server-side controller method
            dataType: "json", // what to expect back from the server
            data: form_data,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
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
            success: function (res) {
                Swal.close();

                if(res.status){
                    Swal.fire({
                        text: res.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2500
                    }).then((result) => {
                        dtList_detail1.setData();
                        mdDetail.modal("hide");
                    });
                }else{
                    Swal.fire({
                        text: res.message,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });

                }
                
            },
            error: function (res) {
                Swal.close();
                Swal.fire({
                    text: "Gagal simpan data",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    
                });
                
            },
        });
    }

    $("#btn-save-warna").on("click", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Apakah anda ingin menyimpan data ?",
            icon: 'question',
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#198754',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6C757D'
        }).then((result) => {
            if (result.isConfirmed) {
                save_warna();
            }
        })
    });



    $("#btn-save").on("click", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Apakah anda ingin menyimpan Work Order ?",
            icon: 'question',
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#198754',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6C757D'
        }).then((result) => {
            if (result.isConfirmed) {
                saved(0)
            }
        })
    });

    $("#btn-send").on("click", function(e) {
        e.preventDefault();
        

        Swal.fire({
            title: "Apakah anda ingin mensubmit Work Order dan meneruskan ke Produksi ?",
            icon: 'question',
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#198754',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6C757D'
        }).then((result) => {
            if (result.isConfirmed) {
                saved(1)
            }
        })
    });



    function saved(isstataus){
        let dataJenis = $('input[name="jenis_proses"]');
        let dataid = $("#dataid").val();
        let listJenis = [];
        for (const inpel of dataJenis) {
            let inp = $("#" + inpel.id)
            if(inp.is(":checked")){
                listJenis.push(inp.val());
            }
        }

        let ukuran_data = dtListDetail.getData();
        let ukuran_calc = dtListDetail.getCalcResults();

        let form_data = new FormData();
        form_data.append('dataid', dataid);
        form_data.append('listproses', JSON.stringify(listJenis));
        form_data.append('status_data', isstataus);
        form_data.append('data_ukuran_warna', JSON.stringify(ukuran_data));
        form_data.append('data_ukuran', JSON.stringify(ukuran_calc));
        
        $.ajax({
            url: "/trans/work-order/save-data", // point to server-side controller method
            dataType: "json", // what to expect back from the server
            data: form_data,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
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
            success: function (res) {
                Swal.close();

                if(res.status){
                    Swal.fire({
                        text: res.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2500
                    }).then((result) => {
                        // similar behavior as clicking on a link
                        window.location.href = "/trans/work-order";
                    });
                }else{
                    Swal.fire({
                        text: res.message,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });

                }
                
            },
            error: function (res) {
                Swal.close();
                Swal.fire({
                    text: "Gagal simpan data",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    
                });
                
            },
        });
    }

});
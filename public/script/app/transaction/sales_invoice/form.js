
$(document).ready(function () {


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

    let fmView = function(value, data, cell, row, options) {
		let row_data = value._cell.row.data;
		let fmBtnEdit = "<button class='btn btn-sm btn-info' type='button' title='view'><i class='fa fa-info-circle' title='view'></i></button>";
		
		let btnRes = fmBtnEdit;
		return btnRes; //+ "&nbsp;" + fmBtnDelete;
	};

    // detail pop pup 
    let detModal = $("#modal-view-detail-do");
    let detRefKode = $("#det_ref_so");
    let detRefTgl = $("#det_ref_tgl");
    let detRefKonsumen = $("#det_konsumen");
    let detStyle = $("#det_style");
    let detAlamat = $("#alamat_buyer");

    let dtList_detail1 = new Tabulator("#dt-list-delivery", {
        columns: [
            
			{
				title: 'No.', formatter: "rownum", headerSort:false, sorter: 'string',
			}, 
				
			{
				title: 'DO NO.', field: 'delivery_kode', headerSort:false, sorter: 'string',
				width: 140,			}, 
				
			{
				title: 'COLOUR', field: 'kode_warna	', headerSort:false, sorter: 'string',
				width: 140,
			}, 

            {
				title: 'S', field: 's', formatter : "html", align: "center", cssClass: "text-center", headerSort:false,
                width: 140,
			} ,

            {
				title: 'M', field: 'm', formatter : "html", align: "center", cssClass: "text-center", headerSort:false,
                width: 140,
			},

            {
				title: 'L', field: 'l', headerSort:false, sorter: 'string',
				width: 140,
			},

            {
				title: 'XL', field: 'xl', headerSort:false, sorter: 'string',
				width: 140,
			},
            
            {
				title: '2XL', field: 'xxl', headerSort:false, sorter: 'string',
				width: 140,
			},

            {
				title: '3XL', field: 'xxxl', headerSort:false, sorter: 'string',
				width: 140,
			},

            {
				title: 'ALL', field: 'all_', headerSort:false, sorter: 'string',
				width: 140,
			},

            {
				title: 'DO QTY', field: 'qty', headerSort:false, sorter: 'string',
				width: 140,
			},

            {
				title: 'AMOUNT', field: 'total_harga', headerSort:false, sorter: 'string',
				width: 140,
			},
				
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

    // table detail 
    let dtListDetail = new Tabulator("#dt-detail", {
        columns: [
                {
                    title: "Aksi.", formatter: fmView,  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
                    width:"7%",
                    cellClick: function(e, cell) {
                        if (e.target.title === 'view') {
                            let rowData = cell.getRow().getData();

                            detRefKode.val(rowData.ref_kode);
                            detRefTgl.val(rowData.tgl_transaksi);
                            detRefKonsumen.val(rowData.konsumen_nama);
                            detStyle.val(rowData.keterangan_style);
                            detAlamat.val("");

                            dtList_detail1.setData(rowData.detail_data);
                            setTimeout(() => {
                                dtList_detail1.redraw(true)
                            }, 500);
                            detModal.modal("show");
                        }
                    }
                },
                {
                    title: "No.", formatter: "rownum",  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
                    width:"5%"
                },
                {
                    title: "Ref No.", field: "ref_kode",  sorter: "string", headerSort:false, align: "center", cssClass: "text-start",
                    width:"20%", 
                },
                {
                    title: "Ref Tgl", field: "tgl_transaksi",  sorter: "string", headerSort:false, align: "center", cssClass: "text-start",
                    width:"7%", 
                },

                {
                    title: "Style", field: "keterangan_style",  sorter: "string ", headerSort:false, align: "center", cssClass: "text-start",
                    width:"13%", 
                },

                {
                    title: "Ref Qty", field: "ref_qty",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"12%", //bottomCalc:"sum", 
                },

                {
                    title: "Amount", field: "ref_total",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"12%", //bottomCalc:"sum", 
                },

                {
                    title: "DP", field: "ref_dp",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"12%", //bottomCalc:"sum", 
                },

                {
                    title: "INV. TOTAL", field: "totals",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"12%", //bottomCalc:"sum", 
                },
                
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

    // let detail_data = $("#data-details").val().replace(/&quot;/ig,'"');

    // if(detail_data.length > 0){
    //     setTimeout(() => {
    //         try {
    //             let isdata = JSON.parse(detail_data);
                
    //             // Set data ke Tabulator
    //             dtListDetail.setData(isdata);
    //         } catch (e) {
    //             console.error("Error parsing JSON:", e);
    //         }
    //     }, 1000);
    // }

    let isBuyer = $("#select_buyer");

    if(isBuyer.attr('value').length > 0){
        isBuyer.val(isBuyer.attr('value')).trigger("change");
    }
    
    isBuyer.on("change", function(){
        let val = $(this).val();
        get_wokonsumen(val);
    })

    function get_wokonsumen(id){
        $.ajax({
            url: "/trans/sales-invoice/get_order", // point to server-side controller method
            dataType: "json", // what to expect back from the server
            data: { konsumen_id : id },
            type: "post",
            // cache: false,
            // contentType: false,
            // processData: false,
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
                        dtListDetail.setData(res.data)
                    });
                }else{
                    Swal.fire({
                        text: res.message,
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2000
                    });

                }
                
            },
            error: function (res) {
                Swal.close();
                Swal.fire({
                    text: "Gagal memuat data",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                }).then((result) => {
                    
                });
                
            },
        });
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

    

    // let fmEditDetail = function(value, data, cell, row, options) {
	// 	let row_data = value._cell.row.data;
	// 	let fmBtnEdit = "<button class='btn btn-xs btn-warning' type='button' title='edit'><i class='fa fa-edit' title='edit'></i></button>";
		
	// 	let btnRes = fmBtnEdit;
	// 	return btnRes; //+ "&nbsp;" + fmBtnDelete;
	// };

    
    


    // start table detail warna 
    // let inpDetailLoss = $("#loss_perc");
    // let dtListDetailWarna = new Tabulator("#dt-warna", {
    //     columns: [
    //             {
    //                 title: "Colour", field: "kode_warna",  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
    //                 width:"15%"
    //             },
    //             {
    //                 title: "%", field: "persen",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"11%"
    //             },
              
    //             {
    //                 title: "NEEDS<br>(GRAM)", field: "gram_nd",  sorter: "string", headerSort:false,  align: "center", cssClass: "text-end",
    //                 width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             },

    //             {
    //                 title: "IN KG", field: "kg",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             },

    //             {
    //                 title: "LOSS<br>(KG)", field: "kg_loss",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             },

    //             {
    //                 title: "NFP (KG)", field: "total",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"11%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             },

    //             {
    //                 title: "QTY<br>ON HAND", field: "kuota",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"12%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             },

    //             {
    //                 title: " (+/-) ", field: "kuota_tambah",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
    //                 width:"9%", bottomCalc:"sum", bottomCalcFormatter: cellMoney, formatter: cellMoney,
    //             }
    //         ],
    //         locale: 'id',
    //         placeholder: "Tidak ada data",
    //         pagination: false,
    //         paginationSize: 99,
    //         paginationButtonCount: 2,
    //         paginationDataSent: {
    //             sorters: "order",
    //         },
    //         selectableRows: false
	// });


    // function updateRow(data, total){
    //     let rows = dtListDetailWarna.getRows();
    //     rows.forEach(row => {
    //         let rowData = row.getData();
    //         let val_persen = total > 0 ? (rowData.gram/total) * 100 : 0;
    //                          val_persen = val_persen > 0 ? val_persen.toFixed(2) : 0;
    //         row.update({ persen: val_persen });
    //     });
    // }   

    // inpDetailLoss.on("change", function(){
    //     let val = $(this).val()
    //     let rows = dtListDetailWarna.getRows();
    //     rows.forEach(row => {
    //         let rowData = row.getData();
    //         let val_kg = rowData.kg;

    //         let val_kg_loss = val.length > 0 ? (val_kg * val) / 100 : 0
    //             val_kg_loss = val_kg_loss > 0 ? val_kg_loss.toFixed(2) : 0;

    //         let val_total = parseFloat(val_kg) + parseFloat(val_kg_loss);
    //             val_total = val_total > 0 ? val_total.toFixed(2) : 0

    //         let val_kuota = 0;//parseFloat(val_kg) - parseFloat(val_kg_loss);
    //             val_kuota    = val_kuota    > 0 ? val_kuota   .toFixed(2) : 0

    //         let val_kuota_tambah = val_kuota - val_total;

    //         row.update({
    //             kg_loss: val_kg_loss,
    //             total: val_total,
    //             kuota: val_kuota,
    //             kuota_tambah: val_kuota_tambah,
    //         });
    //     });
    // });

    // function save_warna(){
    //     let inpQty = textQtyWarna.html();
    //     let inLoss = inpDetailLoss.val();
    //     let inDetailID = textDetId.val();
    //     let inData = dtListDetailWarna.getData().length > 0 ? JSON.stringify(dtListDetailWarna.getData()) : "[]";

    //     let form_data = new FormData();
    //     form_data.append('detail_qty', inpQty);
    //     form_data.append('detail_loss', inLoss);
    //     form_data.append('detail', inDetailID);
    //     form_data.append('warna_data', inData);
        
    //     $.ajax({
    //         url: "/trans/work-order/save-warna", // point to server-side controller method
    //         dataType: "json", // what to expect back from the server
    //         data: form_data,
    //         type: "post",
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         beforeSend: function () {
    //             Swal.fire({
    //                 title: 'Loading...',
    //                 allowOutsideClick: false,
    //                 showConfirmButton: false,
    //                 onBeforeOpen: () => {
    //                     Swal.showLoading();
    //                 }
    //             });
    //         },
    //         success: function (res) {
    //             Swal.close();

    //             if(res.status){
    //                 Swal.fire({
    //                     text: res.message,
    //                     icon: 'success',
    //                     showConfirmButton: false,
    //                     timer: 2500
    //                 }).then((result) => {
    //                     dtList_detail1.setData();
    //                     mdDetail.modal("hide");
    //                 });
    //             }else{
    //                 Swal.fire({
    //                     text: res.message,
    //                     icon: 'error',
    //                     showConfirmButton: false,
    //                     timer: 2000
    //                 });

    //             }
                
    //         },
    //         error: function (res) {
    //             Swal.close();
    //             Swal.fire({
    //                 text: "Gagal simpan data",
    //                 icon: 'error',
    //                 showConfirmButton: false,
    //                 timer: 2000
    //             }).then((result) => {
                    
    //             });
                
    //         },
    //     });
    // }

    // $("#btn-save-warna").on("click", function(e) {
    //     e.preventDefault();

    //     Swal.fire({
    //         title: "Apakah anda ingin menyimpan data ?",
    //         icon: 'question',
    //         confirmButtonText: 'Simpan',
    //         confirmButtonColor: '#198754',
    //         showCancelButton: true,
    //         cancelButtonText: 'Batal',
    //         cancelButtonColor: '#6C757D'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             save_warna();
    //         }
    //     })
    // });


    


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
$(document).ready(function () {
    let dtList = new Tabulator("#dt-list", {
        columns: [
            {
				title: 'Nomor Akun', field: 'coa_kode', headerSort:false, sorter: 'string',
				width: "25%", formatter : "html", visible : false
			}, 
			{
				title: 'Akun', field: 'coa_nama', headerSort:false, sorter: 'string',
				width: "35%", formatter : "html"
			}, 
			{
				title: 'Januari', field: 'bln1', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Februari', field: 'bln2', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Maret', field: 'bln3', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'April', field: 'bln4', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Mei', field: 'bln5', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Juni', field: 'bln6', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Juli', field: 'bln7', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Agustus', field: 'bln8', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'September', field: 'bln9', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Oktober', field: 'bln10', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'November', field: 'bln11', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},
            {
				title: 'Desember', field: 'bln12', headerSort:false, sorter: 'string',
				width: "15%", formatter : "money", bottomCalc:"sum", bottomCalcFormatter:"money", align: "right", cssClass: "text-end"
			},

           
        ],
        layout: 'fitColumns',
        ajaxURL: "/keuangan/laporan_mutasi/list",
        placeholder: "Tidak ada data",
        ajaxConfig: "POST",
        ajaxSorting: true,
        ajaxFiltering: true,
        ajaxRequesting: function (url, params) {
            params.start = params.size * (params.page - 1);
            params.length = params.size;
            params.tahun = $("#slc_tahun").val();
        },
        ajaxResponse: function (url, params, response) {
            return response.data;
        },
        
        dataTree: true,
        dataTreeChildField: "children",
        dataTreeStartExpanded : true,
        dataTreeChildIndent: 15,
        
        selectableRows: false,
    });

    let btnCari = $("#btn_cari");
    btnCari.on("click", function(){
        dtList.setData();
    });

    $("#slc_tahun").select2({
		allowClear: false,
		placeholder: "- Pilih Periode -",
	});

    let btnExcel = $("#btn_excel");
    btnExcel.on("click", function(){
        let periode = $("#slc_tahun").val();

        if(periode != ""){
            let url = "/keuangan/laporan_mutasi/getExcel/" + periode;
            window.open(url, '_blank');
        }else{
            alert("Pilih periode terlebih dahulu !");
        }
    });

    // let searchThread = null;
    // let elSearch = $("#tb-search");
    // if (elSearch != null) {
    //     elSearch.keyup(function (e) {
    //         if ($(this).val().length < 3 && e.keyCode > 13) {
    //             return;
    //         }
    //         clearTimeout(searchThread);
    //         searchThread = setTimeout(function () {
    //             dtList.setFilter("", "like", elSearch.val());
    //         }, 600);
    //     });
    // }

});
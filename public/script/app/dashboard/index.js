$(document).ready(function () {

    // table tracking order 
    let dtListTracking = new Tabulator("#tbl-tracking", {
        columns: [
            {
                title: "NO. TRANSAKSI", field: "btnOrder", headerSort: false, formatter: "html",
                width: 130, hozAlign: 'center', cssClass: 'text-center'
            },

            {
                title: "TIPE", field: "tipe", headerSort: false, formatter: "html",
                width: 120, 
            },

            
			{
				title: 'TGL TRANSAKSI', field: 'tgl_transaksi', headerSort:false, sorter: 'string',
				width: 130, formatter : "html", hozAlign: 'center', cssClass: 'text-center'
			}, 
				
			{
				title: 'BUYER', field: 'nama', headerSort:false, sorter: 'string',
				width: 250
			}, 

            {
				title: 'STYLE', field: 'keterangan', headerSort:false, sorter: 'string',
				formatter : "html"
			},

            {
				title: 'TGL DEADLINE', field: 'tgl_deadline', headerSort:false, sorter: 'string',
				width: 120, formatter : "html", hozAlign: 'center', cssClass: 'text-center'
			}, 
				

            {
				title: 'QTY', field: 'qty', headerSort:false, sorter: 'string',
				width: 100, formatter : "html", hozAlign: 'right', cssClass: 'text-end'
			}, 

            {
                title: "NO. PRODUKSI", field: "btnProd", headerSort: false, formatter: "html",
                width: 120, hozAlign: 'center', cssClass: 'text-center'
            },

            {
				title: 'QTY<br>PRODUKSI', field: 'qty_prod', headerSort:false, sorter: 'string',
				width: 100, hozAlign: 'right', cssClass: 'text-end'
			}, 

            {
                title: "NO. PENGIRIMAN", field: "btnDev", headerSort: false, formatter: "html",
                width: 150, hozAlign: 'center', cssClass: 'text-center'
            },

            {
				title: 'QTY BELUM<br>PRODUKSI', field: 'qty_sisa', headerSort:false, sorter: 'string',
				width: 100, hozAlign: 'right', cssClass: 'text-end'
			}, 

            {
				title: 'QTY<br>PENGIRIMAN', field: 'qty_kirim', headerSort:false, sorter: 'string',
				width: 110, hozAlign: 'right', cssClass: 'text-end'
			}, 

            {
				title: 'QTY BELUM<br>DIKIRIM ', field: 'qty_sisa_kirim', headerSort:false, sorter: 'string',
				width: 100, hozAlign: 'right', cssClass: 'text-end'
			}, 

            
        ],
        layout: 'fitColumns',
        ajaxURL: "/dashboard/list_order",
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
        },
        ajaxResponse: function (url, params, response) {
            let pageSize = dtListTracking.getPageSize();
            let pageNo = dtListTracking.getPage();
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
        selectableRows: false,
    });

    let searchThread = null;
    let elSearch = $("#inp-tracking");
    if (elSearch != null) {
        elSearch.keyup(function (e) {
            if ($(this).val().length < 3 && e.keyCode > 13) {
                return;
            }
            clearTimeout(searchThread);
            searchThread = setTimeout(function () {
                dtListTracking.setFilter("", "like", elSearch.val());
            }, 600);
        });
    }

    // end table tracking order 
});
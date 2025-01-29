$(document).ready(function () {
    let dtList = new Tabulator("#dt-list", {
        columns: [
           
            {
				title: 'Nomor', field: 'kode', headerSort:false, sorter: 'string',
				width: "25%", formatter : "html"
			}, 
			{
				title: 'Nama', field: 'nama', headerSort:false, sorter: 'string',
				// width: "48%"
			}, 
			{
				title: 'Level', field: 'level', headerSort:false, sorter: 'string',
				width: "15%", visible : false
			},
            {
                title: " ", field: "aksi", headerSort: false, formatter: "html",
                width: "10%"
            },
        ],
        layout: 'fitColumns',
        ajaxURL: "/keuangan/daftar_akun/list",
        placeholder: "Tidak ada data",
        ajaxConfig: "POST",
        ajaxSorting: true,
        ajaxFiltering: true,
        minHeight: 300,
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
        dataTree: true,
        dataTreeChildField: "children",
        dataTreeStartExpanded : true,
        dataTreeChildIndent: 15,
        paginationSize: 9999999999,
        paginationButtonCount: 10,
        dataSendParams: {
            sorters: "order"
        },
        selectableRows: false,
    });

    let searchThread = null;
    let elSearch = $("#tb-search");
    if (elSearch != null) {
        elSearch.keyup(function (e) {
            if ($(this).val().length < 3 && e.keyCode > 13) {
                return;
            }
            clearTimeout(searchThread);
            searchThread = setTimeout(function () {
                dtList.setFilter("", "like", elSearch.val());
            }, 600);
        });
    }

});
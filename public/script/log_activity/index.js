$(document).ready(function () {
    let dtList = new Tabulator("#dt-list", {
        columns: [
            {
                title: "Tanggal Aktivitas", field: "log_date", sorter: "string",
                width: 185
            },
            {
                title: "IP Address", field: "ip_address", sorter: "string",
                width: 150
            },
            {
                title: "Nama Komputer", field: "comp_name", sorter: "string",
                width: "20%"
            },
            {
                title: "Username", field: "username", sorter: "string",
                width: "20%"
            },
            {
                title: "Aktivitas", field: "activity", sorter: "string",
                width: "40%"
            },
            {
                title: "Modules Alias", field: "module_alias", sorter: "string",
                width: "20%"
            },
            {
                title: "Trans Id", field: "trans_id", sorter: "string",
                width: "12%"
            },
            {
                title: "Deskripsi", field: "description", sorter: "string",
                width: "40%"
            },
            {
                title: "Http Agent", field: "http_agent", sorter: "string",
                width: "20%"
            },
            {
                title: "Http Host", field: "http_host", sorter: "string",
                width: "20%"
            },
        ],
        ajaxURL: window.location.origin + "/utilitas/log-activity/lists",
        ajaxConfig: "POST",
        sortMode: "remote",
        filterMode: "remote",
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
        paginationSize: 10,
        paginationButtonCount: 10,
        dataSendParams: {
            sorters: "sort"
        },
        selectableRows: false
    });

    let searchThread = null;
    let elSearch = $("#tb-search");
    if (elSearch != null) {
        elSearch.change(function (e) {
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

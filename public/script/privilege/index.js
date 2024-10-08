$(document).ready(function () {
    var tbl_det_priv = $('#dt-listpriv').DataTable({
        responsive: true,
        ordering: false,
        info: false,
        searching: false,
        'bPaginate': false,
        sDom: 't',
        scrollX: true,
        columns: [
            { "width": "40%" },
            { "width": "5%", "class": "align-center" },
            { "width": "5%", "class": "align-center" },
            { "width": "5%", "class": "align-center" },
            { "width": "5%", "class": "align-center" },
            { "width": "5%", "class": "align-center" },
            { "width": "5%", "class": "align-center" }
        ],
        ajax: window.location.origin + '/utilitas/privileges/getprivby/0'
    });

    $('#role_id').select2().on("change", function (e) {
        iLoader.start();
        var $this = $(this);
        var newUrlPriv = window.location.origin + '/utilitas/privileges/getprivby/'
            + $this.val();
        $('#dt-listpriv').DataTable().ajax.url(newUrlPriv).load(() => { iLoader.stop(); });
    });
});

function unSelectAllChk(obName) {
    var checkboxes = document.getElementsByName(obName);
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = false; //source.checked;
    }
}
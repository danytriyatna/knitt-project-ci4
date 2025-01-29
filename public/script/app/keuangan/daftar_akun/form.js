$(document).ready(function () {
    $("[data-politespace]").politespace();
    $("#alert-success").hide();

	let kodeAkun = $("#kode");
	let kodeAkunOld = kodeAkun.val();

    kodeAkun.on("change", function(){
        let val = $(this).val();
        if(val.length > 4){
            alert("Pengisian kode hanya boleg 4 digit !");
            kodeAkun.val(kodeAkunOld);
        }
    });

	let fmPosisi = $("#position");
	fmPosisi.select2({
		allowClear: false,
		placeholder: "- Pilih Company -",
	});
	fmPosisi.val(fmPosisi.attr("value")).trigger("change");


	let fmCoaParentID = $("#parent_id");
    build_jenis_risiko();   
    function build_jenis_risiko() {
        fmCoaParentID.html('');
        fmCoaParentID.val(fmCoaParentID.attr('value'));

        let idx = 0;
        if($("input[name='id']").val() != undefined){
            if($("input[name='id']").val() != ''){
                idx = $("input[name='id']").val();
            }
        }
        $.get("/keuangan/daftar_akun/get_org/" + idx, {}, function (data) {
            fmCoaParentID.html('');
            fmCoaParentID.select2ToTree({
                treeData: {
                    dataArr: data,
                    valFld: "id",
                    labelFld: "unit_name",
                    incFld: "children",
                    dftVal: null
                },
                allowClear: false,
                placeholder: '- Pilih -',
                multiple: false,
                width: '100%'
            });
            fmCoaParentID.val(fmCoaParentID.attr('value')).trigger('change');
        }, "json");
    }

	
});



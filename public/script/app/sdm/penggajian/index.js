$(document).ready(function () {

    //Create Date Editor
    var dateEditor = function(cell, onRendered, success, cancel){
        //cell - the cell component for the editable cell
        //onRendered - function to call when the editor has been rendered
        //success - function to call to pass thesuccessfully updated value to Tabulator
        //cancel - function to call to abort the edit and return to a normal cell

        //create and style input
        var cellValue = luxon.DateTime.fromFormat(cell.getValue(), "dd/MM/yyyy").toFormat("yyyy-MM-dd"),
        input = document.createElement("input");

        input.setAttribute("type", "date");

        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        input.value = cellValue;

        onRendered(function(){
            input.focus();
            input.style.height = "100%";
        });

        function onChange(){
            if(input.value != cellValue){
                success(luxon.DateTime.fromFormat(input.value, "yyyy-MM-dd").toFormat("dd/MM/yyyy"));
            }else{
                cancel();
            }
        }

        //submit new value on blur or change
        input.addEventListener("blur", onChange);

        //submit new value on enter
        input.addEventListener("keydown", function(e){
            if(e.keyCode == 13){
                onChange();
            }

            if(e.keyCode == 27){
                cancel();
            }
        });

        return input;
    };

    //Create Time Editor
    var timeEditor = function(cell, onRendered, success, cancel){
        //cell - the cell component for the editable cell
        //onRendered - function to call when the editor has been rendered
        //success - function to call to pass the successfully updated value to Tabulator
        //cancel - function to call to abort the edit and return to a normal cell

        //create and style input
        var cellValue = cell.getValue(); // assumes cellValue is in "HH:mm" format
        var input = document.createElement("input");

        input.setAttribute("type", "time");

        input.style.padding = "4px";
        input.style.width = "100%";
        input.style.boxSizing = "border-box";

        // Set the initial value of the input to the cell's value
        input.value = cellValue;

        onRendered(function(){
            input.focus();
            input.style.height = "100%";
        });

        function onChange(){
            if(input.value != cellValue){
                // Pass the updated value back in "HH:mm" format
                success(input.value);
            }else{
                cancel();
            }
        }

        //submit new value on blur or change
        input.addEventListener("blur", onChange);

        //submit new value on enter
        input.addEventListener("keydown", function(e){
            if(e.keyCode == 13){ // Enter key
                onChange();
            }

            if(e.keyCode == 27){ // Escape key
                cancel();
            }
        });

        return input;
    };

    let inpTglA = $("#filter_tgl_from");
    let inpTglS = $("#filter_tgl_to");
    let dtList = new Tabulator("#dt-penggajian", {
        columns: [
            
			{
				title: 'NIK', field: 'nip', headerSort:false, sorter: 'string',
				width: 160
			}, 
				
			{
				title: 'Nama', field: 'full_name', headerSort:false, sorter: 'string',
				width: 240
			}, 

            {
				title: 'Posisi', field: 'posisi', headerSort:false, sorter: 'string',
				formatter : "html", width: 150,
			},

            {
				title: 'Hadir', field: 'hadir', headerSort:false, sorter: 'string',
				width: 100, cssClass:'text-center',
			},

            {
				title: 'Izin', field: 'izin', headerSort:false, sorter: 'string',
				width: 100, cssClass:'text-center',
			},

            {
				title: 'Sakit', field: 'sakit', headerSort:false, sorter: 'string',
				width: 100, cssClass:'text-center',
			},

            {
				title: 'Tanpa<br>Keterangan', field: 'alpha', headerSort:false, sorter: 'string',
				width: 120, cssClass:'text-center',
			},

            {
				title: 'Gaji/Upah', field: 'gaji_harian', headerSort:false, sorter: 'string', align: "center",
                width: 220, formatter:"money", cssClass:"text-end"
			} ,

            {
				title: 'Lembur HK', field: 'lembur', headerSort:false, sorter: 'string',
				width: 100, cssClass:'text-center',
			},

            {
				title: 'Lembur HL', field: 'lembur_we', headerSort:false, sorter: 'string',
				width: 100, cssClass:'text-center',
			},

            {
				title: 'Lembur', field: 'uang_lembur', headerSort:false, sorter: 'string', align: "center",
                width: 220, formatter:"money", cssClass:"text-end"
			} ,

            {
				title: 'Gaji/Upah', field: 'total', headerSort:false, sorter: 'string', align: "center",
                width: 220, formatter:"money", cssClass:"text-end"
			} ,
				
        ],
        layout: 'fitColumns',
		locale: 'id',
		placeholder: "Tidak ada data",
		selectable: false
    });

    $("#btn-generate").on("click", function(){
        // dtList.setData();
        const tglA = inpTglA.val();
        const tglZ = inpTglS.val();
        $.ajax({
            url: 'sdm/penggajian/get_laporan', // point to server-side controller method
            dataType: 'json', // what to expect back from the server
            data: {tgl_mulai : tglA, tgl_akhir : tglZ},
            type : 'post',
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
				//    console.log(res.msg);
				   dtList.setData(res.data);
			   }else{
				   alert(res.msg)
			   }
            },
            error: function (res) {
                Swal.close();
                // console.log(res);
            }
        });
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

    function formatLocaleDate(localeDate) {
    
        // var months = {
        //     "Januari": "01",
        //     "Februari": "02",
        //     "Maret": "03",
        //     "April": "04",
        //     "Mei": "05",
        //     "Juni": "06",
        //     "Juli": "07",
        //     "Agustus": "08",
        //     "September": "09",
        //     "Oktober": "10",
        //     "November": "11",
        //     "Desember": "12"
        // };

        // var parts = localeDate.split(" ");
        // var day = parts[0].padStart(2, '0'); 
        // var month = months[parts[1]]; 
        // var year = parts[2];

        // return `${year}-${month}-${day}`;
        return localeDate;//`${day}-${month}-${year}`;
    }
});

$(document).ready(function () {
    // table detail 
    let dtListDetail = new Tabulator("#dt-detail", {
        columns: [
                {
                    title: "Colour", field: "colordasar",  sorter: "string", headerSort:false, align: "center", cssClass: "text-left",
                    width:"17%"
                },
                {
                    title: "S", field: "s",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },
                {
                    title: "M", field: "m",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },

                {
                    title: "L", field: "l",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },

                {
                    title: "XL", field: "xl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },

                {
                    title: "XXL", field: "xxl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },

                {
                    title: "3XL", field: "xxxl",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"9%"
                },

                {
                    title: "All", field: "all",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%"
                },

                {
                    title: "QTY", field: "qty",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%"
                },
                {
                    title: "QTY<br>PRODUKSI", field: "qty_prod",  sorter: "string", headerSort:false, align: "center", cssClass: "text-end",
                    width:"10%"
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
                console.log(isdata);
                
                // Set data ke Tabulator
                dtListDetail.setData(isdata);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        }, 1000);
    }
});
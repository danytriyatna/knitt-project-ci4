$(document).ready(function () {

    let slTahun = $("#slc_tahun");
    let slBulan = $("#bulan");



    let btnExcel = $("#btn_excel");
    setTimeout(() => {

      
      $("#btn_cari").on("click", function(){
          location.href = "/keuangan/laporan_laba?tahun=" + slTahun.val() + "&bulan=" + slBulan.val();
      });


      $("#btn_excel").on("click", function () {
        let s_tahun = slTahun.val();
        let s_bulan = slBulan.val();
  
          // if (stDate == "") {
          //   stDate = 0;
          // }
    
          // if (enDate == "") {
          //   enDate = 0;
          // }
    
          // if (konsumen == "") {
          //   konsumen = 0;
          // }
    
          let url =
            "/keuangan/laporan_laba/getExcel/" +
            s_bulan +
            "/" +
            s_tahun;
          window.open(url, "_blank");
  
      });
    }, 1000);
 });
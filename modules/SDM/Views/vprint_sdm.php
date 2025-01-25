<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citraknitt QR Code</title>
  <style>
    /* Global styles */
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }

    .sheet {
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr; /* Membagi menjadi dua kolom */
      grid-template-rows: auto auto; /* Membagi menjadi dua baris */
      gap: 2.5mm; /* Jarak antar elemen */
      box-sizing: border-box;
      padding: 0mm;
    }

    .item {
      border: 1px solid #ccc;
      padding: 8px; /* Ruang di dalam setiap item */
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      text-align: center;
    }

    img {
      display: block;
      margin-bottom: 2px; /* Memberi jarak antara gambar dan teks */
    }

    .details {
      font-size: 12px;
      text-align: center;
      line-height: 1.5; /* Jarak antar baris teks */
    }

    .details b {
      font-size: 16px;
      margin-bottom: 5px; /* Jarak bawah nama sample */
    }

    .details em {
      font-size: 14px;
    }

    /* Print-specific styles */
    @media print {
      @page {
        size: A4 portrait; /* Mengatur mode potrait */
        margin: 6mm; /* Margin halaman */
      }

      body {
        margin: 0;
        padding: 0;
      }

      .sheet {
        page-break-after: always; /* Pisahkan halaman untuk setiap kertas penuh */
      }
    }
  </style>
</head>
<body>
  <div class="sheet">
    <?php 
      foreach ($detail as $r) { 
    ?>
      <div class="item">
        <h4>SLIP GAJI PERIODE</h4>
        <?= $row->periode_awal ?> S/D <?= $row->periode_akhir ?>
        <hr>
        <table>
          <tr>
            <th>Nama</th>
            <th>:</th>
            <td style="text-align:left;"><?= $r->full_name ?></td>
          </tr>
          <tr>
            <th>Posisi</th>
            <th>:</th>
            <td style="text-align:left;"><?= $r->posisi ?></td>
          </tr>
        </table>
        <hr>
        <table>
          <tr>
            <th>Gaji/Upah</th>
            <th>:</th>
            <td style="text-align:left;"><?= ($r->gaji_harian) ? format_angka($r->gaji_harian) : 0 ?></td>
          </tr>
          <tr>
            <th>Lembur</th>
            <th>:</th>
            <td style="text-align:left;"><?= ($r->uang_lembur) ? format_angka($r->uang_lembur) : 0 ?></td>
          </tr>
          <tr>
            <th>Total</th>
            <th>:</th>
            <td style="text-align:left;"><?= ($r->gaji) ? format_angka($r->gaji) : 0 ?></td>
          </tr>
        </table>
      </div>
    <?php 
    }
    ?>
  </div>

  <script>
    window.print();
  </script>
</body>
</html>

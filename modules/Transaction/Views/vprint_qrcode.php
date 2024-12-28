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
      gap: 10mm; /* Jarak antar elemen */
      box-sizing: border-box;
      padding: 10mm;
    }

    .item {
      border: 1px solid #ccc;
      padding: 15px; /* Ruang di dalam setiap item */
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      text-align: center;
    }

    img {
      display: block;
      margin-bottom: 10px; /* Memberi jarak antara gambar dan teks */
    }

    .details {
      font-size: 12px;
      text-align: center;
      line-height: 1.5; /* Jarak antar baris teks */
    }

    .details b {
      font-size: 14px;
      margin-bottom: 5px; /* Jarak bawah nama sample */
    }

    /* Print-specific styles */
    @media print {
      @page {
        size: A4 portrait; /* Mengatur mode potrait */
        margin: 10mm; /* Margin halaman */
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
    for ($i = 0; $i < $data['qtyp']; $i++) { 
    ?>
      <div class="item">
        <img src="<?= base_url(); ?>/uploads/media/qrcode/<?= $fileName; ?>" alt="QR Code" width="100px" height="100px">
        <div class="details">
          <b><?= $data['noSample'] ?></b><br>
          Ukuran : <em><?= strtoupper($data['ukuran']) ?: '-' ?></em><br>
          Warna  : <em><?= $data['warna'] ?: '-' ?></em><br>
          Jumlah : <em><?= $data['qty'] ?: '-' ?></em>
        </div>
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

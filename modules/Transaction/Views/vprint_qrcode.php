<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JavaRent QR Code</title>
  <style>
    /* @page { margin: 0 }
    body { margin: 0 }
    .sheet {
      margin: 0;
      overflow: hidden;
      position: relative;
      box-sizing: border-box;
      page-break-after: always;
    }

    /** Paper sizes **/
    body.A3               .sheet { width: 297mm; height: 419mm }
    body.A3.landscape     .sheet { width: 420mm; height: 296mm }
    body.A4               .sheet { width: 210mm; height: 296mm }
    body.A4.landscape     .sheet { width: 297mm; height: 209mm }
    body.A5               .sheet { width: 148mm; height: 209mm }
    body.A5.landscape     .sheet { width: 210mm; height: 147mm }
    body.letter           .sheet { width: 216mm; height: 279mm }
    body.letter.landscape .sheet { width: 280mm; height: 215mm }
    body.legal            .sheet { width: 216mm; height: 356mm }
    body.legal.landscape  .sheet { width: 357mm; height: 215mm }
    body.lbl.landscape    .sheet { width:  50mm; height:  20mm }

    /** Padding area **/
    .sheet.padding-10mm { padding: 10mm }
    .sheet.padding-15mm { padding: 15mm }
    .sheet.padding-20mm { padding: 20mm }
    .sheet.padding-25mm { padding: 25mm }

    /** For screen preview **/
    @media screen {
      body { background: #e0e0e0 }
      .sheet {
        background: white;
        box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
        margin: 5mm auto;
      }
    }

    /** Fix for Chrome issue #273306 **/
    @media print {
              body.A3.landscape  { width: 420mm }
      body.A3, body.A4.landscape { width: 297mm }
      body.A4, body.A5.landscape { width: 210mm }
      body.A5                    { width: 148mm }
      body.letter, body.legal    { width: 216mm }
      body.letter.landscape      { width: 280mm }
      body.legal.landscape       { width: 357mm }
      body.lbl.landscape         { width:  50mm; height:  20mm }
    } */
  </style>
</head>
<body class="lbl landscape" style="display:inline-grid;justify-items:center; font-family: sans-serif;">
  <div style="sheet">
    <table style="border:0px solid #000;width:100%;">
      <tbody>
        <?php for ($i=0; $i < $data['qtyp'] ; $i++) { ?>
          <tr>
            <td width="170px" align="center"><img src="<?= base_url(); ?>/uploads/media/qrcode/<?= $fileName; ?>" alt="QR Code" width="100px" height="100px"></td>
            <td >
              <b><?= $data['noSample'] ?></b><br>
              Ukuran : <em><?= strtoupper($data['ukuran']) ?></em><br>
              Warna  : <em><?= $data['warna'] ?></em><br>
              Jumlah : <em><?= $data['qty'] ?></em>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>

<script>
    // var css = '@page { size: landscape; }',
    // head = document.head || document.getElementsByTagName('head')[0],
    // style = document.createElement('style');

    // style.type = 'text/css';
    // style.media = 'print';

    // if (style.styleSheet){
    //   style.styleSheet.cssText = css;
    // } else {
    //   style.appendChild(document.createTextNode(css));
    // }

    // head.appendChild(style);

    window.print();
</script>
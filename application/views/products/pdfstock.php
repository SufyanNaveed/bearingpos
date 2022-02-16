<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Stock</title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 1mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal {
            page-break-inside: avoid;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right: 20pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;
        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border: 1px solid #ddd;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
            font-size: 14pt;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;
        }

        .party {
            border: #ccc 1px solid;

        }

        .top_logo {
            max-height: 180px;
            max-width: 250px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        }
    </style>
</head>
<body dir="<?= LTR ?>">
<div class="invoice-box">
    <h3 id="logo" class="text-center"><br><img style="max-height:100px;" src='<?php echo FCPATH . 'userfiles/company/' . $loc['logo'];
    ?>' alt='Logo'></h3>
    <div style="text-align: center;"><b>Product's Summary</b></div><br><br><br>
    <table style="text-align: center;">
        <?php $fill = true; $count=1; $purchasePrice=$wholesale=$price=$qty=0;
        foreach ($data as $item){
            $count++;
            $purchasePrice += $item['purchasePrice'] * $item['qty'];
            $wholesale += $item['wholesale'] * $item['qty'];
            $price += $item['price'] * $item['qty'];
            $qty += $item['qty'];
        } ?>
    </table>
    <br>
    <br>
    <table class="subtotal" style="text-align:right">
        <tr class="f_summary">
            <td>Total Products:</td>
            <td><?php echo $count -1 ?></td>
        </tr>
        <tr class="f_summary">
            <td>Total Product's Quantity:</td>
            <td><?php echo $qty ?></td>
        </tr>
        <tr class="f_summary">
            <td>Total Purchase Price:</td>
            <td><?php echo amountFormat($purchasePrice) ?></td>
        </tr>
        <tr class="f_summary">
            <td>Total Wholesale Price:</td>
            <td><?php echo amountFormat($wholesale)  ?></td>
        </tr>
        <tr class="f_summary">
            <td>Total Price:</td>
            <td><?php echo amountFormat($price)  ?></td>
        </tr> 
    </table>
    </div>
</div>
</body>
</html>
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
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
            padding: 6pt;
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
            line-height: 14pt;
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
    <table class="plist" cellpadding="0" cellspacing="0">
    <tr>
        <td class="myw">
            <table class="">
                <tr class="item mfill">
                    <td style="width:200px"> &nbsp; <b><?= $general['title'] . ' No: '?></b></td>
                    <td style="width:200px"> &nbsp; <?= $invoice['tid']?></td>
                    <td style="width:200px"> &nbsp; <b><?= ' Tax No: ' ?></b></td>
                    <td style="width:200px"> &nbsp; <?= $loc['taxid']?></td>
                    <td rowspan="4" style="width:200px;text-align: center">
                        <?php if (@$qrc) { ?>
                            <img style="max-height:150px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'>                                
                        <?php } ?>
                    </td>
                </tr>
                <tr class="item mfill">
                    <td> &nbsp; <b><?= $general['title'] . ' ' . $this->lang->line('Date') ?> : </b></td>
                    <td> &nbsp; <?php echo dateformat($invoice['invoicedate']) ?></td>
                    <td><b> &nbsp; <?= 'Customer Name' ?>: </b></td>
                    <td> &nbsp; <?php echo $invoice['name'] ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <br>
    <br>
    <br>
    <tr class="heading">
        <td>
                <?php echo $this->lang->line('Description') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <?php if ($invoice['tax'] > 0) echo '<td>' . $this->lang->line('Tax') . '</td>';
            if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>'; ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>
        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 3;
        foreach ($products as $row) {
            $cols = 4;
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];


            echo '<tr class="item' . $flag . '"> 
                            <td>' . $row['product'] . '</td>
							<td style="width:12%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:12%;" >' . +$row['qty'] . $row['unit'] . '</td>   ';
            if ($invoice['tax'] > 0) {
                $cols++;
                echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>';
            }
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:16%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            echo '<td class="t_center">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
                        </tr>';
            if ($row['product_des']) {
                $cc = $cols++;
                echo '<tr class="item' . $flag . ' descr"> 
                            <td colspan="' . $cc . '">' . $row['product_des'] . '<br>&nbsp;</td>
							
                        </tr>';
            }
            $fill = !$fill;

        }

        if ($invoice['shipping'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['tax'] > 0) {
            $sub_t_col++;
        }
        if ($invoice['discount'] > 0) {
            $sub_t_col++;
        }
        ?>


    </table>
    <br>
    <table class="subtotal">


        <tr>
            <td class="myco2" rowspan="<?php echo $sub_t_col ?>"><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>';
                    if (!$general['t_type']) {
                        echo '<br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        if (@$round_off['other']) {
                            $final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
                            echo '<p>' . $this->lang->line('Round Off') . ' ' . $this->lang->line('Amount') . ': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        }

                        echo $this->lang->line('Paid Amount') . ': ' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']);
                    }

                    if ($general['t_type']) {
                        echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
                    }
                    ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="f_summary">
            <td><?php echo $this->lang->line('SubTotal') ?>:</td>
            <td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
        </tr>
        <?php if ($invoice['tax'] > 0) {
            echo '<tr>
            <td> ' . $this->lang->line('Total Tax') . ' :</td>
            <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
        if ($invoice['discount'] > 0) {
            echo '<tr>
            <td>' . $this->lang->line('Total Discount') . ':</td>
            <td>' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
        if ($invoice['shipping'] > 0) {
            echo '<tr>
            <td>' . $this->lang->line('Shipping') . ':</td>
            <td>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
        ?>
        <tr>
            <td><?php echo $this->lang->line('Balance Due') ?>:</td>
            <td><strong><?php $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;
    }
    if (@$round_off['other']) {
        $rming = round($rming, $round_off['active'], constant($round_off['other']));
    }
    echo amountExchange($rming, $invoice['multi'], $invoice['loc']);
    echo '</strong></td>
		</tr>
		</table><br><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . FCPATH . 'userfiles/employee_sign/' . $employee['sign'] . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div><div class="sign3">' . user_role($employee['roleid']) . '</div> <div class="terms">' . $invoice['notes'] . '<hr><strong>' . $this->lang->line('Terms') . ':</strong><br>';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?>

</div>
</div>
</body>
</html>
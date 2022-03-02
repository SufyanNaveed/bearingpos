<div class="invoice-box">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table class="plist" cellpadding="0" cellspacing="0" >
        <tr>
            <td>
            </td>
            <td class="myw">
                <table style="width:95%" class="">
                    <tr class="item mfill">
                    <td style="width:50px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="width:180px;font-size:25px;border:none; background:none"> &nbsp; </td>
                        <td style="width:180px;font-size:25px;border:none; background:none"> &nbsp; </td>
                        <td style="width:200px;font-size:25px;border:none; background:none"> &nbsp; </td>
                        <td style="width:250px;font-size:25px;border:none; background:none"> &nbsp; </td>
                        <td style="width:80px;font-size:25px;border:none; background:none"> &nbsp; </td>
                        <td style="width:80px;font-size:25px;border:none; background:none"> &nbsp; </td>
                    </tr>
                    <tr class="item mfill">
                        <td style="width:50px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="width:180px;font-size:20px;"> &nbsp; <b><?= $general['title'] . ' No '?></b></td>
                        <td style="width:180px;font-size:20px"> &nbsp; <?= $invoice['tid']?></td>
                        <td style="width:200px;font-size:20px"> &nbsp; <b>VAT No</b></td>
                        <td style="width:250px;font-size:20px"> &nbsp; 302215099300003</td>
                        <td style="width:80px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td rowspan="4" style="width:80px;border:none; background:none">
                            <?php if (@$qrc) { ?>
                                <img style="max-height:150px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'>                                
                            <?php } ?>
                        </td>
                    </tr>
                    <!-- <tr class="item mfill">
                    <td style="width:50px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="font-size:20px;border:none; background:none"><b> &nbsp;  </b></td>
                        <td style="font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="font-size:20px;border:none; background:none"><b> &nbsp; </b></td>
                        <td style="width:350px;font-size:20px;border:none; background:none"> &nbsp;</td>
                        <td style="width:80px;font-size:20px;border:none; background:none"> &nbsp; </td>
                    </tr> -->
                    <tr class="item mfill">
                        <td style="width:50px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="font-size:20px"> &nbsp; <b><?= $general['title'] . ' ' . $this->lang->line('Date') ?>  </b></td>
                        <td style="font-size:20px"> &nbsp; <?php echo dateformat($invoice['invoicedate']) ?></td>
                        <td style="font-size:20px"><b> &nbsp; <?= 'Customer Name' ?> </b></td>
                        <td style="font-size:20px"> &nbsp; <?php echo $invoice['name'] ?></td>
                        <td style="width:80px;font-size:20px;border:none; background:none"> &nbsp; </td>
                    </tr>
                    <tr class="item mfill">
                        <td style="width:50px;font-size:20px;border:none; background:none"> &nbsp; </td>
                        <td style="font-size:20px"> &nbsp; <b><?= 'Phone No' ?>  </b></td>
                        <td style="font-size:20px"> &nbsp; <?php echo $invoice['phone'] ?></td>
                        <td style="font-size:20px"><b> &nbsp; <?= 'Address' ?> </b></td>
                        <td style="font-size:20px"> &nbsp; <?php echo $invoice['address'] ?></td>
                        <td style="width:80px;font-size:20px;border:none; background:none"> &nbsp; </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

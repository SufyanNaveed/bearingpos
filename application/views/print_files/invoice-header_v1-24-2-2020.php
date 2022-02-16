<table class="tbl-img">
    <tbody>
        <tr style="background:url(../../app-assets/images/backgrounds/bg-2.jpg);color:pink">
            <td align="center">
                <strong style="color:green; font-size:20px">
                    <?php 
                        $loc = location($invoice['loc']); 
                       // echo $loc['cname']; 
                        echo "<br>";
                       // echo "<span style='font-size: 14px;color:red'>For Sales Bearing-Oil-Belt</span>";
                    ?>
                </strong>
                <br>
                <?php 
                    //echo "<span style='font-size:12px;'>". $loc["address"] . "<br>" . 
                      //   $loc['region'] . '<br>' . 
                        // "<b>Tel.:" . $loc['phone'] . '4475834</b><br> ' . 
                        // $this->lang->line('Email') . ': ' . 
                         //$loc['email'];
                //if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
                ?>
            </td>
            <td align="center">
            <!--<img src="<?php //echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                     style="max-width:150px;">-->
            </td>
            <td align="center" style="height:150px">
                <strong style="color:green; font-size:20px">
                    <?php 
                       // $loc = location($invoice['loc']); 
                        //$loc['cname']; 
                        //echo "<br>";
                        //echo "<br>";
                    ?>
                </strong>
                <br>
                <?php 
                    //echo "<span style='font-size:12px;'>". $loc["address"] . "<br>" . 
                      //   $loc['region'] . '<br>' . 
                        // "<b>Tel.:" . $loc['phone'] . '4475834</b><br> ' . 
                         //$this->lang->line('Email') . ': ' . 
                         //$loc['email'];
                //if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
                ?>
            </td>
        </tr>
    </tbody>
</table>
<div style="width:100%; margin-top:10px;"> </div>
        <table>
        <tbody>
        <?php if (@$invoice['name_s']) { ?>
        <tr>
            <td>
                <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';
                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . ', ' . $invoice['region_s'] . '<br>' . $invoice['country_s'] . '-' . $invoice['postbox_s'] . '<br> ' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];
                    ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>

    <!-- <tr>
        <td class="myco">
            <img src="<?php //$loc = location($invoice['loc']);
            //echo FCPATH . 'userfiles/company/' . $loc['logo'] ?>"
                 class="top_logo">
        </td>
        <td>
        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" class="t_center"><h2><?= $general['title'] ?></h2><br><br></td>
                </tr>
                <tr>
                    <td><?= $general['title'] ?></td>
                    <td><?= $general['prefix'] . ' ' . $invoice['tid'] ?></td>
                </tr>
                <tr>
                    <td><?= $general['title'] . ' ' . $this->lang->line('Date') ?></td>
                    <td><?php echo dateformat($invoice['invoicedate']) ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Due Date') ?></td>
                    <td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
                </tr>
                <?php if ($invoice['refer']) { ?>
                    <tr>
                        <td><?php echo $this->lang->line('Reference') ?></td>
                        <td><?php echo $invoice['refer'] ?></td>
                    </tr>
                <?php } ?>
            </table>


        </td>
    </tr> -->
</table>
<br>
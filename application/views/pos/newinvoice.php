<form method="post" id="data_form" class="content-body">
    <div class="sidebar-left sidebar-fixed bg-white">
        <div class="sidebar">
            <div class="sidebar-content ">
                <div class="card-body chat-fixed-search">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="ft-search"></i></span>
                        </div>
                        <input type="text" class="form-control" id="pos-customer-box"
                               placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?>"
                               aria-describedby="button-addon2">
                        <div class="input-group-append" id="button-addon2">
                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                    data-target="#Pos_addCustomer"> <?php echo $this->lang->line('Add') ?></button>
                        </div>
                    </div>
                    <div id="customer-box-result" class="col-md-12"></div>
                    <div id="customer" class="col-md-12 ml-3">
                        <div class="clientinfo">

                            <input type="hidden" name="customer_id" id="customer_id" value="1">
                            <div id="customer_name"><?php echo $this->lang->line('Default'); ?>: <strong>Walk
                                    In </strong></div>
                        </div>


                    </div>

                </div>
                <div>
                    <div class="users-list-padding media-list">

<br>   <div class="row bg-gradient-directional-purple white m-0 pt-1 pb-1">
							    <div class="col-6 ">
                                   <i class="fa fa-briefcase"></i>
                                                <?php echo $this->lang->line('Products') ?></th>
							    </div>
							    <div class="col-3">
							     <i class="fa fa-money"></i><?php echo $this->lang->line('Price') ?>
							    </div>
							    <div class="col-3">
							   <i
                                                        class="fa fa-shopping-bag"></i> <?php echo $this->lang->line('Total') ?>
							    </div>
							  </div>
                        <div id="saman-pos2">
                            <div  id="pos_items"></div></div>
<input type="hidden" name="total" class="form-control"
                                                                         id="invoiceyoghtml" readonly="">
<hr class="mt-1"><div class="row m-2">
							    <div class="col-3">
							      <strong > <?php echo $this->lang->line('Shipping') ?></strong>
							    </div>
							    <div class="col-3">
							    <input type="text" class="form-control form-control-sm shipVal"
                                                                         onkeypress="return isNumber(event)"
                                                                         placeholder="Value"
                                                                         name="shipping" autocomplete="off"
                                                                         onkeyup="billUpyog()">
							    </div>
							    <div class="col-3">
							          ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                                <span id="ship_final">0</span> )
							    </div>
							  </div>

                        <div class="row m-2">
                              <div class="col-3">
							      <strong > <?php echo $this->lang->line('Total Tax') ?></strong>
							    </div>  <div class="col-3"><?php echo currency($this->aauth->get_user()->loc);
         ?>
							    <span id="taxr" class="mr-1">0</span>
							    </div>
                        </div>
                           <div class="row m-2">
                              <div class="col-3">
							      <strong > <?php echo $this->lang->line('Total Discount') ?></strong>
							    </div>  <div class="col-9"><?php echo currency($this->aauth->get_user()->loc);
         ?>
							  <span id="discs"
                                                      class="lightMode mr-1">0</span>
							    </div>
                        </div>
                                     <div class="row m-2">
                              <div class="col-3">
							      <strong > <?php echo $this->lang->line('Grand Total') ?></strong>
							    </div>  <div class="col-9"><?php echo currency($this->aauth->get_user()->loc);
         ?>
							  <span class=""
      id="bigtotal">0.00</span>
							    </div>
                        </div>












                                    <hr>

<div class="m-1">

						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="btn btn-outline-primary  mr-1 mb-1" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="false"><i
                                                        class="fa fa-trophy"></i>
                                                <?php echo $this->lang->line('Coupon') ?></a>
							</li>
							<li class="nav-item">
								<a class="btn btn-outline-secondary mr-1 mb-1" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i class="icon-handbag"></i>
        <?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Settings') ?></a>
							</li>
							<li class="nav-item">
								<a class="btn btn-outline-danger  mr-1 mb-1" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab" aria-selected="false"><i class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?>(s)</a>
							</li>
						<li class="nav-item">
								<a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
        <?php echo $this->lang->line('Invoice Properties') ?></a>
							</li>
						</ul>
						<div class="tab-content px-1 pt-1">
							<div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
								 <div class="input-group">

                                                        <input type="text" class="form-control"
                                                               id="coupon" name="coupon"><input type="hidden"
                                                                                                name="coupon_amount"
                                                                                                id="coupon_amount"
                                                                                                value="0"><span
                                                                class="input-group-addon round"> <button
                                                                    class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


                                                    </div><input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                                                           value="">
                                                    <span class="text-primary text-bold-600" id="r_coupon"></span>
							</div>
							<div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                <div class="row">
								<div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
                                                        <select
                                                                id="v2_warehouses"
                                                                class="selectpicker form-control round teal">
                                                            <?php echo $this->common->default_warehouse();
                                                            echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                            } ?>

                                                        </select></div>
                                                    <div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Tax') ?>
                                                        <select class="form-control round"
                                                                onchange="changeTaxFormat(this.value)"
                                                                id="taxformat">
                                                            <?php echo $taxlist; ?>
                                                        </select></div>
                                                    <div class="col-4 blue text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                                                        <select class="form-control round teal"
                                                                onchange="changeDiscountFormat(this.value)"
                                                                id="discountFormat">

                                                            <?php echo $this->common->disclist() ?>
                                                        </select></div>
							</div></div>
							<div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
								<?php foreach ($draft_list as $rowd) {
                                                    echo '<li class="indigo p-1"><a href="' . base_url() . 'pos_invoices/draft?id=' . $rowd['id'] . '"> #' . $rowd['tid'] . ' (' . $rowd['invoicedate'] . ')</a></li>';
                                                } ?>
							</div>
                            		<div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
								      <div class="form-group row">
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Invoice #"
                                                               name="invocieno" id="invocieno"
                                                               value="<?php echo $lastinvoice + 1 ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                               placeholder="Reference #"
                                                               name="refer">
                                                    </div>
                                                </div>


                                                <div class="col-sm-3"><label for="invociedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required"
                                                               placeholder="Billing Date" name="invoicedate"
                                                               data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieduedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required" id="tsn_due"
                                                               name="invocieduedate"
                                                               placeholder="Due Date" data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <?php echo $this->lang->line('Payment Terms') ?> <select
                                                            name="pterms"
                                                            class="selectpicker form-control"><?php foreach ($terms as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                        } ?>

                                                    </select>
                                                    <?php if ($exchange['active'] == 1) {
                                                        echo $this->lang->line('Payment Currency client') ?>
                                                    <?php } ?>
                                                    <?php if ($exchange['active'] == 1) {
                                                        ?>
                                                        <select name="mcurrency"
                                                                class="selectpicker form-control">
                                                        <option value="0">Default</option>
                                                        <?php foreach ($currency as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                        } ?>

                                                        </select><?php } ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="toAddInfo"
                                                           class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                                    <textarea class="form-control" name="notes" rows="2"></textarea>
                                                </div>
                                            </div>





							</div>
						</div>
					</div>








                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="content-right">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="chat-app-window">
                         <div class="row ">


                                <div class="col-sm-9">


                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control text-center round mousetrap"
                                               name="product_barcode"
                                               placeholder="Enter Product name, code or scan barcode" id="v2_search_bar"
                                               autocomplete="off" autofocus="autofocus">
                                        <div class="form-control-position">
                                            <i class="icon-barcode2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3  grey text-xs-center"><select
                                            id="v2_categories"
                                            class="selectpicker form-control round teal">
                                        <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                                        foreach ($cat as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select></div>


                            </div>
                            <hr class="white">


                            <div class="row m-0">
                                <div class="col-md-12 pt-0 " id="pos_item">
                                    <!-- pos items -->
                                </div>
                            </div>
                </section>
                <section class="chat-app-form">
                    <div class="form-group text-center">
                                    <!-- Button Group with Icons in different sizes -->
                                    <div class="btn-group btn-group-lg" role="group">
                                        <button type="button" class="possubmit btn btn-warning"><i class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?> </button>
                                        <button type="button" class="btn btn-success possubmit3"  data-type="6" data-toggle="modal"
                                                   data-target="#basicPay"><i class="fa fa-money"></i> <?php echo $this->lang->line('Payment') ?></button> <?php

                                                if ($enable_card['url']) { ?>
                                        <button type="button" class="btn btn-primary possubmit2" data-type="4" data-toggle="modal" data-target="#cardPay"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('Card') ?></button>     <?php } ?>

                                    </div>
                                </div>




                </section>
            </div>
        </div>
    </div>
      <input type="hidden" value="pos_invoices/action" id="action-url">
            <input type="hidden" value="search" id="billtype">
            <input type="hidden" value="0" name="counter" id="ganak">
            <input type="hidden" value="0" id="custom_discount">
            <input type="hidden" value="<?php echo currency($this->aauth->get_user()->loc); ?>" name="currency">
            <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">

            <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
            <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">

            <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>" name="discountFormat"
                   id="discount_format">
            <input type="hidden" value="<?= $this->common->disc_status()['ship_rate']; ?>" name="shipRate"
                   id="ship_rate">
            <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                   id="ship_taxtype">
            <input type="hidden" value="0" name="ship_tax" id="ship_tax">
</form>
   <audio id="beep" src="<?= base_url() ?>assets/js/beep.wav" autoplay="false"></audio>
    <?php /*
 <div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">

            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div id="thermal_a" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" style="overflow-x: hidden;" id="data_form">

                    <div class="row pContainer">

                        <div class="col-md-5 p-0 pLeft">
                            <div class="input-group">
										<span class="input-group-addon round"> <a href='#'
                                                                                  class="btn btn-primary btn-sm round inline"
                                                                                  data-toggle="modal"
                                                                                  data-target="#Pos_addCustomer">
                                        <i class="icon icon-plus-circle"></i> <?php echo $this->lang->line('Add') ?>
                                    </a></span>
                                <input type="text" class="col-md-6 form-control round mousetrap" name="cst"
                                       id="pos-customer-box"
                                       placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?> "
                                       autocomplete="off"/>

                            </div>

                            <div class="row ml-3">


                                <div id="customer-box-result" class="col-md-12"></div>
                                <div id="customer" class="col-md-12 ml-3">
                                    <div class="clientinfo">

                                        <input type="hidden" name="customer_id" id="customer_id" value="1">
                                        <div id="customer_name"><?php echo $this->lang->line('Default'); ?>: <strong>Walk
                                                In </strong></div>
                                    </div>


                                </div>
                            </div>

                            <div id="saman-row-pos" class="rqw mt-1">
                                <div class="col-md-12 p-0">
                                    <table id="pos_list" class="table-responsive v2_td_pad v2_pos_stripe">
                                        <thead>
                                        <tr class="item_header bg-gradient-directional-deep-purple white">

                                            <th width="10%"
                                                class="text-center p-1">
                                                <i class="icon-briefcase4"></i>
                                                <?php echo $this->lang->line('Products') ?></th>


                                            <th width="10%" class="text-center">
                                                <i class="icon-money"></i><?php echo $this->lang->line('Price') ?>
                                            </th>
                                            <th width="5%"
                                                class="text-center"><i
                                                        class="icon-moneybag"></i> <?php echo $this->lang->line('Total') ?>
                                            </th>
                                        </tr>

                                        </thead>
                                        <tbody id="pos_items">

                                        </tbody>
                                    </table>
                                    <br>
                                    <hr>

                                    <div class="row mt-1">


                                        <div class="col-sm-6">
                                            <div class="col-xs-6">
                                                <strong><?php echo $this->lang->line('Shipping') ?></strong></div>
                                            <div class="col-xs-6"><input type="text" class="form-control shipVal"
                                                                         onkeypress="return isNumber(event)"
                                                                         placeholder="Value"
                                                                         name="shipping" autocomplete="off"
                                                                         onkeyup="billUpyog()">
                                                ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                                <span id="ship_final">0</span> )
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-xs-6">
                                            </div>
                                            <div class="col-xs-6"><input type="hidden" name="total" class="form-control"
                                                                         id="invoiceyoghtml" readonly=""></div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row mt-2">

                                        <div class="col-xs-2">

                                        </div>
                                        <div class="col-xs-8">


                                        </div>


                                    </div>


                                    <hr>


                                    <div id="accordionWrapa1" class="pageover border-top border-lighten-2 border-grey">

                                        <div id="coupon4" class="card-header ">
                                            <div class="btn-group btn-group-lg float-xs-left " role="group"
                                                 aria-label="Draft">
                                                <a href="#"
                                                   class="possubmit bg-grey mr-2 font-large-1 white p-1 rounded"
                                                   data-type="6"
                                                ><i class="icon icon-drag"></i> <?php echo $this->lang->line('Draft') ?>
                                                    &nbsp;</a>

                                                <a href="#"
                                                   class="possubmit3  bg-green mr-2 font-large-1 white p-1 rounded"
                                                   data-type="6" data-toggle="modal"
                                                   data-target="#basicPay"><i
                                                            class="icon icon-cash"></i> <?php echo $this->lang->line('Payment') ?>
                                                </a> <?php

                                                if ($enable_card['url']) { ?>
                                                    <a href="#"
                                                       class="possubmit2  bg-light-blue mr-2 font-large-1 white p-1 rounded"
                                                       data-type="4" data-toggle="modal"
                                                       data-target="#cardPay"><i
                                                                class="icon icon-cc"></i> <?php echo $this->lang->line('Card') ?>
                                                    </a>
                                                <?php } ?>
                                            </div>


                                            <div class="float-xs-right">
    <span class="display-inline-block mr-3"
    ><?php echo $this->lang->line('Total Tax') ?> : <?php echo currency($this->aauth->get_user()->loc); ?>
        <span id="taxr" class="mr-1">0</span><br><?php echo $this->lang->line('Total Discount') ?> : <span
                class="currenty lightMode"><?php echo currency($this->aauth->get_user()->loc);
            if (isset($_GET['project'])) {
                echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
            } ?></span>
                                                <span id="discs"
                                                      class="lightMode mr-1">0</span> <strong><?php echo $this->lang->line('Grand Total') ?>
            (<span
                    class="currenty lightMode"><?php echo currency($this->aauth->get_user()->loc); ?></span>)</strong>
<span class="pl-1 pr-1 bg-light-green mr-1 font-large-1 white rounded display-inline-block"
      id="bigtotal">0.00</span>
<span class="display-inline-block">
                                            <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion1a"
                                               aria-expanded="false"
                                               class="card-title font-size-small collapsed red"><i
                                                        class="icon icon-plus-circle"></i>
                                                <?php echo $this->lang->line('Coupon') ?></a> &nbsp; <a
            data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion2b"
            aria-expanded="false" aria-controls="accordion2b"
            class="card-title font-size-small  collapsed grey"><i class="icon icon-plus-circle"></i>
        <?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Settings') ?></a>  &nbsp; <br> <a
            data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion3c"
            aria-expanded="false" aria-controls="accordion3c"
            class="card-title font-size-small  collapsed light-blue"><i class="icon icon-plus-circle"></i>
                                                Drafts</a> &nbsp;  &nbsp;  &nbsp;<a data-toggle="collapse"
                                                                                    data-parent="#accordionWrapa1"
                                                                                    href="#accordion4d"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="accordion4d"
                                                                                    class="card-title font-size-small  collapsed indigo"><i
                class="icon icon-plus-circle"></i> <?php echo $this->lang->line('Invoice Properties') ?>
                                            </a></span></div>
                                        </div>
                                        <div id="accordion1a"
                                             class="card-collapse collapse bg-red bg-lighten-5 round">
                                            <div class="row p-1">
                                                <div class="col-xs-6">
                                                    <h6><?php echo $this->lang->line('Coupon') ?></h6>
                                                    <div class="input-group">

                                                        <input type="text" class="form-control"
                                                               id="coupon" name="coupon"><input type="hidden"
                                                                                                name="coupon_amount"
                                                                                                id="coupon_amount"
                                                                                                value="0"><span
                                                                class="input-group-addon round"> <button
                                                                    class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


                                                    </div>
                                                </div>
                                                <div class="col-xs-12">

                                                    <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                                                           value="">
                                                    <span class="text-primary text-bold-600" id="r_coupon"></span></div>
                                            </div>
                                        </div>


                                        <div id="accordion2b"
                                             class="card-collapse collapse bg-light-blue round bg-lighten-5">
                                            <div class="row p-1">
                                                <div class="col-xs-12">
                                                    <h6><?php echo $this->lang->line('Settings') ?></h6>
                                                    <div class="col-md-4 blue text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
                                                        <select
                                                                id="v2_warehouses"
                                                                class="selectpicker form-control round teal">
                                                            <?php echo $this->common->default_warehouse();
                                                            echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                            } ?>

                                                        </select></div>
                                                    <div class="col-md-4 blue text-xs-center"><?php echo $this->lang->line('Tax') ?>
                                                        <select class="form-control round"
                                                                onchange="changeTaxFormat(this.value)"
                                                                id="taxformat">
                                                            <?php echo $taxlist; ?>
                                                        </select></div>
                                                    <div class="col-md-4 blue text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                                                        <select class="form-control round teal"
                                                                onchange="changeDiscountFormat(this.value)"
                                                                id="discountFormat">

                                                            <?php echo $this->common->disclist() ?>
                                                        </select></div>
                                                </div>
                                                <div class="col-xs-12 mb-1">

                                                </div>
                                            </div>
                                        </div>


                                        <div id="accordion4d"
                                             class="card-collapse collapse round ">
                                            <input type="hidden" value="0" id="subttlform"
                                                   name="subtotal">
                                            <h6><?php echo $this->lang->line('Invoice Properties') ?></h6>

                                            <div class="form-group row">
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Invoice #"
                                                               name="invocieno" id="invocieno"
                                                               value="<?php echo $lastinvoice + 1 ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                               placeholder="Reference #"
                                                               name="refer">
                                                    </div>
                                                </div>


                                                <div class="col-sm-3"><label for="invociedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required"
                                                               placeholder="Billing Date" name="invoicedate"
                                                               data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieduedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required" id="tsn_due"
                                                               name="invocieduedate"
                                                               placeholder="Due Date" data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <?php echo $this->lang->line('Payment Terms') ?> <select
                                                            name="pterms"
                                                            class="selectpicker form-control"><?php foreach ($terms as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                        } ?>

                                                    </select>
                                                    <?php if ($exchange['active'] == 1) {
                                                        echo $this->lang->line('Payment Currency client') ?>
                                                    <?php } ?>
                                                    <?php if ($exchange['active'] == 1) {
                                                        ?>
                                                        <select name="mcurrency"
                                                                class="selectpicker form-control">
                                                        <option value="0">Default</option>
                                                        <?php foreach ($currency as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                        } ?>

                                                        </select><?php } ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="toAddInfo"
                                                           class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                                    <textarea class="form-control" name="notes" rows="2"></textarea>
                                                </div>
                                            </div>


                                        </div>


                                        <div id="accordion3c" role="tabpanel"
                                             class="card-collapse collapse bg-blue round bg-lighten-5">


                                            <ul><h6>Drafts</h6>
                                                <?php foreach ($draft_list as $rowd) {
                                                    echo '<li class="indigo p-1"><a href="' . base_url() . 'pos_invoices/draft?id=' . $rowd['id'] . '"> #' . $rowd['tid'] . ' (' . $rowd['invoicedate'] . ')</a></li>';
                                                } ?></ul>


                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>
                        <div class="col-md-7 pRight border-amber bg-lighten-1 bg-faded round pt-1">


                            <div class="row ">


                                <div class="col-sm-9">


                                    <div class="position-relative has-icon-left">
                                        <input type="text" class="form-control text-center round mousetrap"
                                               name="product_barcode"
                                               placeholder="Enter Product name, code or scan barcode" id="v2_search_bar"
                                               autocomplete="off" autofocus="autofocus">
                                        <div class="form-control-position">
                                            <i class="icon-barcode2"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3  grey text-xs-center"><select
                                            id="v2_categories"
                                            class="selectpicker form-control round teal">
                                        <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                                        foreach ($cat as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select></div>


                            </div>
                            <hr class="white">


                            <div class="row m-0">
                                <div class="col-md-12 pt-0 " id="pos_item">
                                    <!-- pos items -->
                                </div>
                            </div>
                        </div>


                    </div>
                    <br>


            </div>

            <input type="hidden" value="pos_invoices/action" id="action-url">
            <input type="hidden" value="search" id="billtype">
            <input type="hidden" value="0" name="counter" id="ganak">
            <input type="hidden" value="0" id="custom_discount">
            <input type="hidden" value="<?php echo currency($this->aauth->get_user()->loc); ?>" name="currency">
            <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">

            <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
            <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">

            <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>" name="discountFormat"
                   id="discount_format">
            <input type="hidden" value="<?= $this->common->disc_status()['ship_rate']; ?>" name="shipRate"
                   id="ship_rate">
            <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
                   id="ship_taxtype">
            <input type="hidden" value="0" name="ship_tax" id="ship_tax">


            </form>
            <audio id="beep" src="<?= base_url() ?>/assets/js/beep.wav" autoplay="false"></audio>
        </div>

    </div>
</div>
</div>
 */
    ?>

    <div class="modal fade" id="Pos_addCustomer" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content ">
                <form method="post" id="product_action" class="form-horizontal">
                    <!-- Modal Header -->
                    <div class="modal-header bg-gradient-directional-blue white">
                        <i  class="icon-user-plus"></i> <?php echo $this->lang->line('Add Customer') ?></h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Name') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Name"
                                               class="form-control margin-bottom" id="mcustomer_name" name="name"
                                               required>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Phone"
                                               class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="email"><?php echo $this->lang->line('Email') ?></label>

                                    <div class="col-sm-10">
                                        <input type="email" placeholder="Email"
                                               class="form-control margin-bottom" name="email"
                                               id="mcustomer_email">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('Address') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Address"
                                               class="form-control margin-bottom " name="address"
                                               id="mcustomer_address1">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                    <div class="col-sm-10">
                                        <select name="customergroup" class="form-control">
                                            <?php
                                            foreach ($customergrouplist as $row) {
                                                $cid = $row['id'];
                                                $title = $row['title'];
                                                echo "<option value='$cid'>$title</option>";
                                            }
                                            ?>
                                        </select>


                                    </div>
                                </div>




                            </div>


                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/ >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--card-->
    <div class="modal fade" id="cardPay" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4><button type="button" class="close" data-dismiss="modal" aria-label="Close">    <span aria-hidden="true">&times;</span>
                            <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>

                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body ">
                        <p id="statusMsg"></p>
                        <form role="form" id="card_data">

                                    <div class="row">
                                        <div class="col-6">
                                                <label for="cardNumber"><?php echo $this->lang->line('Payment Gateways') ?></label>
                                                <select class="form-control" name="gateway"><?php
                                                    $surcharge_t = false;
                                                    foreach ($gateway as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['name'];
                                                        if ($row['surcharge'] > 0) {
                                                            $surcharge_t = true;
                                                            $fee = '(<span class="gate_total"></span>+' . amountFormat_s($row['surcharge']) . ' %)';
                                                        } else {
                                                            $fee = '';
                                                        }
                                                        echo "<option value='$cid'>$title $fee</option>";
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                        <div class="col-4"><br><img class="img-responsive pull-right"
                                                                       src="<?php echo base_url('assets/images/accepted_c22e0.png') ?>">
                                        </div>
                                    </div>



                            <div class="row mt-1">
                                <div class="col">
                                    <button class="btn btn-success btn-lg"
                                            type="submit"
                                            id="pos_card_pay"
                                            data-type="2"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('Paynow') ?></button>
                                </div>
                            </div>
                            <div class="form-group">

                                <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>

                            <input type="hidden" value="pos_invoices/action" id="pos_action-url">
                        </form>

                        <!-- shipping -->


                    </div>
                    <!-- Modal Footer -->


            </div>
        </div>
    </div>
    <div class="modal fade" id="basicPay" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content ">
                <form method="post" id="basicpay_data" class="form-horizontal">
                    <!-- Modal Header -->
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4> <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p id="statusMsg"></p>

<div class="text-center"><h1 id="b_total"></h1></div>
                            <div class="row">



                                        <div class="col-6">
                                            <div class="card-title">
                                                <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                                <div class="input-group">
                                                    <input
                                                            type="number"
                                                            class="form-control  text-bold-600 blue-grey"
                                                            name="p_amount"
                                                            placeholder="Amount"
                                                            id="p_amount" onkeyup="update_pay_pos()"
                                                    />
                                                    <span class="input-group-addon"><i
                                                                class="icon icon-cash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card-title">
                                                <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
                                                <select class="form-control" name="p_method" id="p_method">
                                                    <option value='Cash'><?php echo $this->lang->line('Cash') ?></option>
                                                    <option value='Card Swipe'><?php echo $this->lang->line('Card Swipe') ?></option>
                                                    <option value='Bank'><?php echo $this->lang->line('Bank') ?></option>

                                                </select></div>
                                        </div>




                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group  text-bold-600 red">
                                        <label for="amount"><?php echo $this->lang->line('Balance Due') ?>
                                        </label>
                                        <input type="number" class="form-control red" name="amount" id="balance1"
                                               value="0.00"
                                               required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-bold-600 text-g">
                                        <label for="b_change"><?php echo $this->lang->line('Change') ?></label>
                                        <input
                                                type="number"
                                                class="form-control green"
                                                name="b_change" id="change_p" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-lg btn-block mb-1"
                                            type="submit"
                                            id="pos_basic_pay" data-type="4"><i
                                                class="fa fa-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?>
                                    </button>
                                    <button class="btn btn-info btn-lg btn-block"
                                            type="submit"
                                            id="pos_basic_print" data-type="4"><i
                                                class="fa fa-print"></i> <?php echo $this->lang->line('Paynow') ?>
                                        + <?php echo $this->lang->line('Print') ?></button>
                                </div>
                            </div>

                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>




                        <!-- shipping -->


                    </div>
                    <!-- Modal Footer -->

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="register" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Your Register') ?></h4> <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>

                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="text-center m-1"><?php echo $this->lang->line('Active') ?> - <span id="r_date"></span></div>


                    <div class="row">
                        <div class="col-6">
                            <div class="form-group  text-bold-600 green">
                                <label for="amount"><?php echo $this->lang->line('Cash') ?> (<?= $this->config->item('currency'); ?>)
                                </label>
                                <input type="number" class="form-control green" id="r_cash"
                                       value="0.00"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-5 col-md-5 pull-right">
                            <div class="form-group text-bold-600 blue">
                                <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                                <input
                                        type="number"
                                        class="form-control blue"
                                        id="r_card" value="0" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group  text-bold-600 indigo">
                                <label for="amount"><?php echo $this->lang->line('Bank') ?>
                                </label>
                                <input type="number" class="form-control indigo" id="r_bank"
                                       value="0.00"
                                       readonly>
                            </div>
                        </div>
                        <div class="col-5 col-md-5 pull-right">
                            <div class="form-group text-bold-600 red">
                                <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>
                                <input
                                        type="number"
                                        class="form-control red"
                                        id="r_change" value="0" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>


                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->


            </div>
        </div>
    </div>
    <div class="modal fade" id="close_register" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Close') ?><?php echo $this->lang->line('Your Register') ?></h4> <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="<?= base_url() ?>/register/close" class="btn btn-danger btn-lg btn-block"
                               type="submit"
                            ><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Yes') ?></a>
                        </div>
                        <div class="col-4"></div>
                    </div>

                </div>
                <!-- Modal Footer -->


            </div>
        </div>
    </div>
    <div class="modal fade" id="stock_alert" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Stock Alert') ?> !</h4>  <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="row p-1">
                        <div class="alert alert-danger mb-2" role="alert">
                            <strong>Oh snap!</strong> <?php echo $this->lang->line('order or edit the stock') ?>
                        </div>
                    </div>

                </div>
                <!-- Modal Footer -->


            </div>
        </div>
    </div>
    <div id="shortkeyboard" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">ShortCuts</h4> <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>Alt+X</td>
                            <td>Focus to products search</td>
                        </tr>
                        <tr>
                            <td>Alt+C</td>
                            <td>Focus to customer search</td>
                        </tr>

                        <tr>
                            <td>Alt+S (twice)</td>
                            <td>PayNow + Thermal Print</td>
                        </tr>
                        <tr>
                            <td>Alt+Z</td>
                            <td>Make Card Payment</td>
                        </tr>
                        <tr>
                            <td>Alt+Q</td>
                            <td>Select First product</td>
                        </tr>
                        <tr>
                            <td>Alt+N</td>
                            <td>Create New Invoice</td>
                        </tr>


                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $.ajax({
            url: baseurl + 'search_products/v2_pos_search',
            dataType: 'html',
            method: 'POST',
            data: 'cid=' + $('#v2_categories').val() + '&wid=' + $('#v2_warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash,
            success: function (data) {
                $('#pos_item').html(data);
            }
        });

        function update_register() {
            $.ajax({
                url: baseurl + 'register/status',
                dataType: 'json',
                data: crsf_token + '=' + crsf_hash,
                success: function (data) {
                    $('#r_cash').val(data.cash);
                    $('#r_card').val(data.card);
                    $('#r_bank').val(data.bank);
                    $('#r_change').val(data.change);
                    $('#r_date').text(data.date);
                }
            });
        }

        update_register();
        $(".possubmit").on("click", function (e) {
            e.preventDefault();
            var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
            var action_url = $('#action-url').val();
            addObject(o_data, action_url);
        });

        $(".possubmit2").on("click", function (e) {
            e.preventDefault();
            $('#card_total').val($('#invoiceyoghtml').val());
        });

        $(".possubmit3").on("click", function (e) {
            e.preventDefault();
            var roundoff = $('#invoiceyoghtml').val();
            <?php
            $round_off = $this->custom->api_config(4);
            if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
                echo ' roundoff=Math.ceil(roundoff);';
            } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
                echo ' roundoff=Math.floor(roundoff);';
            }
            ?>
            $('#b_total').html(' <?= $this->config->item('currency'); ?> ' + roundoff);
            $('#p_amount').val(roundoff);

        });

        function update_pay_pos() {
            var am_pos = $('#p_amount').val();
            var ttl_pos = $('#invoiceyoghtml').val();

            <?php
            $round_off = $this->custom->api_config(4);
            if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
                echo ' ttl_pos=Math.ceil(ttl_pos);';
            } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
                echo ' ttl_pos=Math.floor(ttl_pos);';
            }
            ?>

            var due = parseFloat(ttl_pos - am_pos).toFixed(2);

            if (due >= 0) {
                $('#balance1').val(due);
                $('#change_p').val(0);
            } else {
                due = due * (-1)
                $('#balance1').val(0);
                $('#change_p').val(due);
            }

        }

        $('#pos_card_pay').on("click", function (e) {
            e.preventDefault();
            $('#cardPay').modal('toggle');
            $("#notify .message").html("<strong>Processing</strong>: .....");
            $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
            $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
            var o_data = $("#data_form").serialize() + '&' + $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
            var action_url = $('#action-url').val();
            addObject(o_data, action_url);
            update_register();
        });
        $('#pos_basic_pay').on("click", function (e) {
            e.preventDefault();
            $('#basicPay').modal('toggle');
            $("#notify .message").html("<strong>Processing</strong>: .....");
            $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
            $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
            var o_data = $("#data_form").serialize() + '&p_amount=' + $("#p_amount").val() + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type');
            var action_url = $('#action-url').val();
            addObject(o_data, action_url);
            setTimeout(
                function () {
                    update_register();
                }, 3000);
        });

        $('#pos_basic_print').on("click", function (e) {
            e.preventDefault();
            $('#basicPay').modal('toggle');
            $("#notify .message").html("<strong>Processing</strong>: .....");
            $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
            $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
            var o_data = $("#data_form").serialize() + '&p_amount=' + $("#p_amount").val() + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&printnow=1';
            var action_url = $('#action-url').val();
            addObject(o_data, action_url);

            setTimeout(
                function () {
                    update_register();
                }, 3000);


        });
    </script>

    <!-- Vendor libraries -->
    <script type="text/javascript">
        var $form = $('#payment-form');
        $form.on('submit', payWithCard);

        /* If you're using Stripe for payments */
        function payWithCard(e) {
            e.preventDefault();

            /* Visual feedback */
            $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
                .prop('disabled', true);

            jQuery.ajax({

                url: '<?php echo base_url('billing/process_card') ?>',
                type: 'POST',
                data: $('#payment-form').serialize() + '&' + crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function (data) {

                    $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

                },
                error: function () {
                    $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                    /* Show Stripe errors on the form */
                    $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                    $form.find('.payment-errors').closest('.row').show();
                    $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                        .prop('disabled', true);
                    $("#notify .message").html("<strong>Error</strong>: Please try again!");


                }

            });


        }


        $('#v2_categories').change(function () {
            var whr = $('#v2_warehouses option:selected').val();
            var cat = $('#v2_categories option:selected').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/v2_pos_search',
                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                beforeSend: function () {
                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {

                    $("#pos_item").html(data);

                }
            });
        });
        $('#v2_warehouses').change(function () {
            var whr = $('#v2_warehouses option:selected').val();
            var cat = $('#v2_categories option:selected').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/v2_pos_search',
                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                beforeSend: function () {
                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {

                    $("#pos_item").html(data);

                }
            });
        })
    $(document).ready(function () {
        Mousetrap.bind('alt+x', function () {
            $('#v2_search_bar').focus();
        });
        Mousetrap.bind('alt+c', function () {
            $('#pos-customer-box').focus();
        });

        Mousetrap.bind('alt+z', function () {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function () {
            window.location.href = "<?=base_url('pos_invoices/create') ?>";
        });
        Mousetrap.bind('alt+q', function () {
            $('#posp0').click();
        });
        Mousetrap.bind('alt+s', function () {
            if ($('#basicPay').hasClass('show')) {
                $('#pos_basic_print').click();
            } else {
                $('.possubmit3').click();
            }

        });
        $('#v2_search_bar').keypress(function (event) {
            if (event.keyCode == 13) {
                $('#posp0').click();
            }
        });
    });
    </script>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Manage POS Invoices') ?> <a
                        href="<?php echo base_url('pos_invoices/create') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-2"><?php echo $this->lang->line('Invoice Date') ?></div>
                    <div class="col-md-2">
                        <input type="text" name="start_date" id="start_date"
                               class="date30 form-control form-control-sm" autocomplete="off"/>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                               data-toggle="datepicker" autocomplete="off"/>
                    </div>
                          <div class="col-md-2">
                        <input placeholder="Search by customer name" type="text" name="customer" id="customer" class="form-control form-control-sm"
                              autocomplete="off"/>
                    </div>
                          <div class="col-md-2">
                        <input placeholder="Search by status" type="text" name="status" id="status" class="form-control form-control-sm"
                                autocomplete="off"/>
                    </div>
                    <div class="col-md-1" style="margin-right: -10px;">
                        <input type="button" name="search" id="search" value="Search" class="btn btn-info btn-sm"/>
                    </div>

                    <div class="col-md-1" style="padding-left: 0px; color: white;">
                        <a class="btn btn-success btn-sm pdf-link-export" href="<?php echo base_url('pos_invoices/ajax_list_pdf') ?>">PDF Download</a>
                    </div>
                </div>
                <hr>
                <table id="invoices" class="table table-striped table-bordered  dataex-res-constructor">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th> #</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th> #</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>

                        <th><?php echo $this->lang->line('Amount') ?><span id="amountt"></span></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="pos_invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        draw_data(); 
        
        function draw_data(start_date = '', end_date = '',customer = '',status = '') {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                 responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('pos_invoices/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        start_date: start_date,
                        end_date: end_date,
                        customer: customer,
                        status: status
                    }                   
          
                },

                
            
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
            });
        }

        function draw_dataa(start_date = '', end_date = '',customer = '',status = '') {
          $.ajax({
              url:  "<?php echo site_url('pos_invoices/ajax_listt')?>",
             'type': 'POST',
             'data': {
                '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                start_date: start_date,
                        end_date: end_date,
                        customer: customer,
                        status: status},
              
              success: function(data){
                $('#amountt').html(' SAR '+data);
                var link = 'pos_invoices/ajax_list_pdf/'+start_date+ '/'+ end_date;
                $('.pdf-link-export').attr('href', link);
                
              }
});
        }


        $('#search').click(function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var customer = $('#customer').val();
            var status = $('#status').val();
            if (start_date != '' && end_date != '') {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date,customer,status);
                draw_dataa(start_date, end_date,customer,status);
            }else if(status != '')
            {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date,customer,status,);
                draw_dataa(start_date, end_date,customer,status,);

            }
            else if(customer != '')
            {
                $('#invoices').DataTable().destroy();
                draw_data(start_date, end_date,customer,status);
                draw_dataa(start_date, end_date,customer,status);

            }

            else {
                alert("Date range is Required");
            }
        });
    });
</script>
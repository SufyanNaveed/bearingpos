<div class="content-body">
    <div class="card">
        <div class="card-header">
             <h5><?php echo $this->lang->line('BalanceSheet') ?></h5>
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



            <table class="table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Account') ?></th>
                    <th><?php echo $this->lang->line('Balance') ?></th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                $gross = 0;
                foreach ($accounts as $row) {
                    $aid = $row['id'];
                    $acn = $row['acn'];
                    $holder = $row['holder'];

                    $balance = $row['lastbal'];
                    $qty = $row['adate'];
                    echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountFormat($balance) . "</td>
                    </tr>";
                    $i++;
                    $gross += $balance;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>

                    <th></th>

                    <th><h3 class="text-xl-left"><?php echo amountFormat($gross); ?></h3></th>
                </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({responsive: true});

    });
</script>
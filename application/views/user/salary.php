<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') . ' : ' . $this->aauth->get_user()->username ?>
            </h5>
            <table id="semptable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th><?php echo $this->lang->line('Note') ?></th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;

                foreach ($employee_salary as $row) {

                    echo '<tr> <td>' . $i . '</td>
                  
                    <td>' . dateformat($row['date']) . '</td>
                      <td>' . amountExchange($row['debit'], 0, $employee['loc']) . '</td>
                   
                     <td>' . $row['note'] . '</td>
                    </tr>';
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th><?php echo $this->lang->line('Note') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#semptable').DataTable({responsive: true});


    });


</script>
<?php include 'db_connect.php';
      include 'functions.php';  

      
?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-sm-4 ">
                            <label for="field1" class="form-label">Priority </label>
                            <select name="priority" id="field1" required class="form-control-sm select2">
                            <option ></option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                           
                        </div>
                        
                       
                        <div class="col-sm-4 ">
                            <label for="field5" class="form-label">Type of Request</label>
                            <div class="form-group">
                                <select name="field5" id="field5" required class="form-control-sm select2">
                                    <option></option>
                                    <?php 
                                        $query = $conn->query("SELECT * FROM  type_of_request ");
                                        while($row= $query->fetch_assoc()):
                                        ?>
                                    <option value="<?php echo ucwords($row['type_of_request'] );?>">
                                        <?php echo ucwords($row['type_of_request']); ?></option>
                                    <?php endwhile; ?>


                                </select>
                            </div>

                        </div>
                        <div class="col-sm-4  ">
                       
                                    <label for="">Status</label>
                                    <select name="status" id="field8" required class="form-control-sm select2">
                                        <option></option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Ordered" >Ordered</option>
                                        <option value="Waiting on processor">Waiting on processor</option>
                                        <option value="Completed" >Completed</option>
                                    </select>
                               
                            
                        </div>
                    </div>
                    <div class="row">

                        
                        
                        <div class="col-sm-4  ">
                            <label for="searchBtn" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-sm form-control"
                                id="searchBtn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Loan#, Branch, Lp, Lc</th>
                        <th>Borrower</th>
                        <th>Request Type</th>
                        <th>Date Time Ordered</th>
                        <th>Last Update</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
                    $branch_id = $_SESSION['login_branch'];
                    $query_result = "SELECT days FROM over_due WHERE branch = '$branch_id'";
                    $result_days = $conn->query($query_result);
                    if ($result_days->num_rows > 0) {
                        $row = $result_days->fetch_assoc();
                        $interval_days = $row['days'];
                    }
                    
                    $currentDate = date('Y-m-d');
                    
                    $query = "SELECT *,
                                DATEDIFF('$currentDate', order_outs.due_date) as days_passed
                            FROM scrub
                            LEFT JOIN loan_no ON scrub.loan_no_id = loan_no.id
                            LEFT JOIN order_outs ON scrub.id = order_outs.scrub_id
                            WHERE order_outs.due_date < DATE_SUB('$currentDate', INTERVAL $interval_days DAY)
                                AND order_outs.date_time_completed = ''
                                AND status != 'Completed'
                                AND JSON_CONTAINS(loan_no.coordinator, '\"{$_SESSION['login_id']}\"') "; 
                    $result = $conn->query($query);


if ($result->num_rows > 0) {
    // Due date has passed, show the data
    while($row = $result->fetch_assoc()) :
        // Get the number of days passed for this row
        $days_passed = $row['days_passed'];
                        
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php if($row['priority']=='high'){echo '<span class="badge badge-danger">'.ucwords($row['priority']).'</span>';}
                                     if($row['priority']=='medium'){echo '<span class="badge badge-info">'.ucwords($row['priority']).'</span>';}
                                     if($row['priority']=='low'){echo '<span class="badge badge-warning">'.ucwords($row['priority']).'</span>';}
                            ?></b></td>
                        <td><b><?php 
                                    echo date("m/d/Y", strtotime($row['due_date'])).'<br>';
                                    echo '<span style="color:red">' . $days_passed . ' Days Passed' . '</span>';

                        ?></b></td>


                        </b></td>
                        <td><b><?php $find_loan_id = find_loan_id_orderOuts($row['loan_no_id'], $conn);
                                     $loan_detail = get_loan_detail($find_loan_id, $conn);
                                     echo $loan_detail['loan_no']; ?><br>
                                <?php echo $loan_detail['branch'];?><br>
                                <strong>LP:</strong>
                                <?php echo $loan_detail['processor_name'];?><br>
                                <strong>LC:</strong>
                                <?php echo implode("<br>", $loan_detail['coordinator_names']);?><br>
                            </b></td>
                        <td><b><?php  echo implode("<br>", $loan_detail['borrowers']) ;?></b></td>
                        <td><b><?php $qry3 = $conn->query('SELECT * FROM type_of_request where id = "'.$row['type_of_request'].'"');$row3= $qry3->fetch_assoc();echo $row3['type_of_request'];?></b>
                        </td>
                        <td><b><?php echo date("m/d/Y", strtotime($row['date_time_ordered']))?></b>
                        </td>
                        <td><b><?php echo date("m/d/y g:i A", strtotime($row['updated_at'])); ?></b></td>
                        </td>
                        <td><b><?php 
                                     if($row['status']=='On Going'){echo '<span class="badge badge-danger">'.$row['status'].'</span>';}
                                     if($row['status']=='Completed'){echo '<span class="badge badge-success">'.$row['status'].'</span>';}
                                     if($row['status']=='Cancelled'){echo '<span class="badge badge-danger">'.$row['status'].'</span>';}
                                     if($row['status']=='Ordered'){echo '<span class="badge badge-warning">'.$row['status'].'</span>';}
                                     if($row['status']=='Waiting on processor'){echo '<span class="badge badge-info">'.$row['status'].'</span>';}
                        ?></b></td>
                        <td><b><?php echo $row['remarks']; ?></b></td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item"
                                    href="./index.php?page=view_order&id=<?php echo $row['scrub_id'] ?>">View Full
                                    Details</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#list').dataTable();

    $('#list tbody').on('click', '.delete_scrub', function() {
        _conf("Deleting this Loan Scrub details will also delete Order Outs associated with this record! Are you sure to continue?",
            "delete_scrub", [$(this).attr('data-id')])
    });
    var table = $('#list').DataTable();
    $('#searchBtn').on('click', function() {
        var field1 = $('#field1').val();
       
        var field5 = $('#field5').val();
       
        var field8 = $('#field8').val();
       
        table.columns(1).search(field1).draw();
        
        table.columns(5).search(field5).draw();
        
        table.columns(8).search(field8).draw();
        
    });
});

function delete_scrub($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_scrub',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully deleted", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}


</script>
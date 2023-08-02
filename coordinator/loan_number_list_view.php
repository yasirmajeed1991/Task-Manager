<?php include 'db_connect.php';
      include 'functions.php' ; 
?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
       
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field1" class="form-label">ID </label>
                            <input type="text" class="form-control form-control-sm" id="field1">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field2" class="form-label">
                                <th>Loan#/Branch/Processor/Coordinator</th>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="field2">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field3" class="form-label">Borrower</label>
                            <input type="text" class="form-control form-control-sm" id="field3">
                        </div>
                        <div class="col-sm-3 mb-2">


                            <label for="field10" class="control-label">Scrub Status</label>
                            
                            <select name="status_of_scrub" id="field10" 
                                class="form-control-sm select2">
                                <option></option>
                                <option value="On Going" >
                                On Going</option>
                                <option value="Cancelled" >
                                    Cancelled
                                </option>
                                <option value="Withdrawn" >
                                Withdrawn
                                </option>
                                
                                <option value="Completed" >
                                    Completed</option>
                            </select>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                        <label for="">Status of Title Request</label>
                                    <select name="status_of_title_request"  id="field9"
                                        class="form-control-sm select2">
                                        <option></option>
                                        <option value="Pending"
                                            >Pending
                                        </option>
                                        <option value="Received"
                                            >Received
                                        </option>
                                        <option value="Withdrawn"
                                            >
                                            Withdrawn
                                        </option>
                                        <option value="Completed"
                                            >
                                            Completed
                                        </option>
                                    </select>
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="searchBtn" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-sm form-control"
                                id="searchBtn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        
                        <th>Loan#<br> Branch<br> Processor<br> Coordinator</th>
                        <th>Borrower</th>
                        <th>Request Date</th>
                        <th>Date Time Started</th>
                        <th>Date Time Completed</th>
                        <th>Time Elapsed</th>
                        <th>Title Request</th>
                        <th>Status of Title Request</th>
                        <th>Scrub Status</th>
                        <th>Last Update</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					
					$qry = $conn->query("SELECT * FROM scrub ");
					while($row= $qry->fetch_assoc()):

						
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                       
                        <td>
                            <b>
                                <?php 
                                        $loan_detail = get_loan_detail($row['loan_no_id'], $conn);
                                        echo  $loan_detail['loan_no'] . "<br>";
                                        echo  $loan_detail['branch'] . "<br>";
                                        echo "<strong>Processor:</strong><br>" . $loan_detail['processor_name'] . "<br>";
                                        echo "<strong>Coordinator:</strong><br>" . implode("<br> ", $loan_detail['coordinator_names']) . "<br>";
                                        
                                ?>
                            </b>
                        </td>
                        <td><b>
                                <?php  
                                echo implode("<br>", $loan_detail['borrowers']) . "<br>";
                                ?>
                            </b></td>
                        <td><b><?php if($row['request_date_time']){$request_date_time = date("m/d/y", strtotime($row['request_date_time']));echo $request_date_time;}?></b>
                        </td>
                        <td><b><?php if($row['date_time_started']){$date_time_started = date("m/d/y g:i A", strtotime($row['date_time_started']));echo $date_time_started;} ?></b>
                        </td>
                        <td><b><?php if($row['date_time_completed']){$date_time_completed = date("m/d/y g:i A", strtotime($row['date_time_completed']));echo $date_time_completed;}  ?></b>
                        </td>
                        <td><b><?php 
						
						if (!empty($row['date_time_started']) && !empty($row['date_time_completed'])) {
                            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_started']);
                            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_completed']);
                            $difference = date_diff($date1, $date2);
                            echo "<span style='font: weight 200px;color:red;'>" . $difference->format("%a days, %h hr, %i min, %s sec") . "</span><br>";
                            $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                            if ($hours_passed >= 6) {
                                echo '<span class="badge badge-danger">6 Hours Exceeded</span>';
                            }
                        }
                        if (!empty($row['date_time_started']) && empty($row['date_time_completed'])) {
                            $date = new DateTime();
                            $date2 = $date->format('Y-m-d H:i:s');
                            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_started']);
                            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2);
                            $difference = date_diff($date1, $date2);
                            echo "<span style='font: weight 200px;color:red;'>" . $difference->format("%a days, %h hr, %i min, %s sec") . "</span><br>";
                            $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                            if ($hours_passed >= 6) {
                                echo '<span style="font: weight 200px;" class="badge badge-danger">6 Hours Exceeded</span>';
                            }
                        }
                        
						?>
                            </b></td>

                        <td><b><?php if($row['title_request']){$title_request = date("m/d/y g:i A", strtotime($row['title_request']));echo $title_request;} ?></b>
                        </td>


                        <td><b class="<?php if($row['status_of_title_request']=='Completed'){echo "badge badge-success";}
											if($row['status_of_title_request']=='Pending'){echo "badge badge-danger";}
											if($row['status_of_title_request']=='Received'){echo "badge badge-info";}
                                            if($row['status_of_title_request']=='Withdrawn'){echo "badge badge-dark";}
						?>"><?php echo $row['status_of_title_request'] ?></b></td>




                        <td><b>
                                <?php if(empty($row['status_of_scrub'])){

                                        if(empty($row['date_time_completed'])){
                                            echo '<span class="badge badge-danger">On Going</span>';
                                        }
                                        else{
                                            echo '<span class="badge badge-success">Completed</span>';
                                        }
                                }
                                else{
                                    if($row['status_of_scrub']=='On Going'){echo '<span class="badge badge-danger">'.$row['status_of_scrub'].'</span>';}
                                    if($row['status_of_scrub']=='Completed'){echo '<span class="badge badge-success">'.$row['status_of_scrub'].'</span>';}
                                    if($row['status_of_scrub']=='Cancelled'){echo '<span class="badge badge-danger">'.$row['status_of_scrub'].'</span>';}
                                    if($row['status_of_scrub']=='Withdrawn'){echo '<span class="badge badge-warning">'.$row['status_of_scrub'].'</span>';}
                                   
                                }
                                
                                
                                
                               
										                         ?>


                            </b></td>


                        <td><b><?php  // First, get the `updated_at` time for the given `id` in `order_outs`
                            $qry1 = $conn->query("SELECT updated_at FROM scrub WHERE id = '".$row['id']."'");
                            $row1 = $qry1->fetch_assoc();
                            $max_updated = strtotime($row1['updated_at']);

                            // Next, get the most recent `follow_up_date` from `follow_up` for the given `order_out_id`
                            $qry2 = $conn->query("SELECT MAX(followup_date) AS max_followup FROM scrub_followup WHERE scrub_id = '".$row['id']."'");
                            $row2 = $qry2->fetch_assoc();

                            // If there are no follow_up_date for the given `order_out_id`, use the `updated_at` time
                            if ($row2['max_followup'] === null) {
                                $most_recent = $max_updated;
                            } 
                            // Otherwise, compare the `updated_at` time with the most recent `follow_up_date` for the given `order_out_id`
                            else {
                                $max_followup = strtotime($row2['max_followup']);
                                $most_recent = $max_updated > $max_followup ? $max_updated : $max_followup;
                            }

                            // Finally, display the most recent time
                            echo date("m/d/y g:i A", $most_recent); ?></b></td>

                        <td><b><?php echo $row['remarks_notes'] ?></b></td>

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">

                               
                                <a class="dropdown-item scrub_followup_view" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>">View Follow Up Details</a>

                                <div class="dropdown-divider"></div>
                                

                                <a class="dropdown-item"
                                    href="./index.php?page=view_order_outs&id=<?php echo $row['id'] ?>">View Order Outs
                                    Details</a>
                              
                                

                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
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

    $('#list tbody').on('click', '.scrub_followup', function() {
        uni_modal("Add Follow Up Details:", "scrub_followup.php?&id=" + $(this)
            .attr('data-id'), "mid-large")
    })
    $('#list tbody').on('click', '.scrub_followup_view', function() {
        uni_modal("Follow Up Details", "scrub_followup_view.php?id=" + $(this).attr('data-id'),
            "mid-large")
    })
    var table = $('#list').DataTable();

$('#searchBtn').on('click', function() {
    var field1 = $('#field1').val();
    var field2 = $('#field2').val();
    var field3 = $('#field3').val();
    var field10 = $('#field10').val();
    var field9 = $('#field9').val();

    table.columns(1).search(field1).draw();
    table.columns(2).search(field2).draw();
    table.columns(3).search(field3).draw();
    table.columns(10).search(field10).draw();
    table.columns(9).search(field9).draw();
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
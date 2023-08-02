<?php include 'db_connect.php';
      include 'functions.php';
    
?>




<?php if($_GET['add_follow_up']==1 || $_GET['follow_up_edit']==1){?>
<?php 	if($_GET['follow_up_edit']==1){
	$qry = $conn->query("SELECT * FROM follow_up where id = ".$_GET['fid'])->fetch_array();
    foreach($qry as $k => $v){
	    $$k = $v;
    }
}
?>
<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="card card-outline card-primary">
    <div class="card-body">
        <form action="" id="manage-loan">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="order_out_id" value="<?php echo $_GET['oid']?>">
            
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id']?>">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="" class="control-label">Remarks Notes</label>
                        <textarea name="remarks_notes" id="remarks" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($remarks_notes) ? $remarks_notes : '' ?>
					</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer border-top border-info">
        <div class="d-flex w-100 justify-content-center align-items-center">
            <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
            <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                onclick="location.href='index.php?page=view_order&id=<?php echo $_GET['id'];?>'">Cancel</button>
        </div>
    </div>
</div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_followup',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully saved', "success");
                setTimeout(function() {
                    location.href =
                        'index.php?page=view_order&id=<?php echo $_GET['id']; ?>&oid=<?php echo $_GET['oid']; ?>&follow_up=1'
                }, 2000)

            }
        }
    })
})
</script>

<?php }?>







<?php if($_GET['follow_up']==1 ){?>



<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">

            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=view_order&id=<?php echo $_GET['id'] ?>&oid=<?php echo $_GET['oid'] ?>&add_follow_up=1"><i
                        class="fa fa-plus"></i>
                    Add New Follow Up</a>
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=view_order&id=<?php echo $_GET['id'] ?>"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>

        </div>
        <div class="card-body">


            <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Follow Up Date</th>
                        <th>Follow Up Made By</th>

                        <th>Remarks Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					$user_valid = 0;
					$login_admin=0;
			
					$qry = $conn->query("SELECT * FROM follow_up where order_out_id = ".$_GET['oid']." ORDER BY id DESC ");
					while($row= $qry->fetch_assoc()):

						
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>

                        <td><b><?php if($row['follow_up_date']){$followup_date = date("m/d/y g:i A", strtotime($row['follow_up_date']));echo $followup_date;}?></b>
                        </td>
                        <td><b><?php $qry1 = $conn->query('SELECT * FROM users where id = "'.$row['user_id'].'"');$row1= $qry1->fetch_assoc();echo $row1['firstname'].' '.$row1['lastname'];?>
                            </b></td>

                        <td><b><?php echo $row['remarks_notes']; ?></b></td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">


                                <a class="dropdown-item"
                                    href="./index.php?page=view_order&id=<?php echo $_GET['id']?>&oid=<?php echo $_GET['oid']?>&fid=<?php echo $row['id']?>&follow_up_edit=1">Edit</a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_scrub" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>">Delete</a>

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
    $('#list').dataTable()

    $('.delete_scrub').click(function() {
        _conf("Are you sure to delete this record?", "delete_scrub", [$(this).attr('data-id')])
    })
})

function delete_scrub($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_followup',
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





<?php }?>










<?php if(empty($_GET['follow_up'])){?>


<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">

            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-success btn-flat border-primary" id="start_order_out"
                    href="javascript:void(0)" data-id="<?php echo $_GET['id'] ?>"><i class="fa fa-plus"></i> Start New
                    Order Out</a>

                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=scrub_list"><i class="fa fa-arrow-left"></i>
                    Scrub List</a>
            </div>



        </div>
        <div class="card-body">

            <?php 
				$qry = $conn->query("SELECT * FROM scrub where id = ".$_GET['id'])->fetch_array();
				foreach($qry as $k => $v){
					$$k = $v;
				}
                $loan_detail = get_loan_detail($loan_no_id, $conn);
				?>
            <p>
                <style>
                .table12 td {
                    font-size: 14px;
                }

                .table12 {
                    width: 300px;
                }
                </style>
            <table class="table12 table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <td style="background-color: #f2f2f2;">Loan No#:</td>
                        <td style="background-color: #f2f2f2; color: red;"><?php echo $loan_detail['loan_no'];?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #f2f2f2;">Branch:</td>
                        <td style="background-color: #f2f2f2; color: red;"> <?php echo $loan_detail['branch'];?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #f2f2f2;">Borrower Name:</td>
                        <td style="background-color: #f2f2f2; color: #28150a;">
                            <?php  echo implode("<br>", $loan_detail['borrowers']) ;?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #f2f2f2;">Processor:</td>
                        <td style="background-color: #f2f2f2; color: blue;"><?php echo $loan_detail['processor_name'];?>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f2f2f2;">Coordinator:</td>
                        <td style="background-color: #f2f2f2; color: green;">
                            <?php echo implode("<br>", $loan_detail['coordinator_names']);?></td>
                    </tr>
                </tbody>
            </table>

            </p>
            <table class="table table-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>ID</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Created By</th>
                        <th>Type of Request</th>
                        <th>Last Update</th>
                        <th>Date/Time Ordered</th>
                        <th>2036 Screen Updated</th>
                        <th>Date/Time Completed</th>
                        <th>Time Elapsed</th>
                        <th>Status</th>
                        <th>Remarks/Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					
					$qry = $conn->query("SELECT * FROM order_outs where scrub_id = ".$_GET['id']." ");
					while($row= $qry->fetch_assoc()):

					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['id']; ?></b></td>
                        <td><b><?php if($row['priority']=='high'){echo '<span class="badge badge-danger">'.ucwords($row['priority']).'</span>';}
                                     if($row['priority']=='medium'){echo '<span class="badge badge-info">'.ucwords($row['priority']).'</span>';}
                                     if($row['priority']=='low'){echo '<span class="badge badge-warning">'.ucwords($row['priority']).'</span>';}
                        ?></b></td>
                        <td><b><?php echo '<span style="color:red">'.date("m/d/y", strtotime($row['due_date'])).'</span>';
                        ?></b></td>
                        <td><b><?php $qry25 = $conn->query('SELECT * FROM users where id = "'.$row['created_by'].'"');$row25= $qry25->fetch_assoc();echo $row25['firstname'].' '.$row25['lastname'] ;?><br>
                            </b></td>

                        <td><b><?php $qry3 = $conn->query('SELECT * FROM type_of_request where id = "'.$row['type_of_request'].'"');$row3= $qry3->fetch_assoc();echo $row3['type_of_request'];?></b>
                        </td>

                        <td><b><?php 
                      // First, get the `updated_at` time for the given `id` in `order_outs`
                            $qry1 = $conn->query("SELECT updated_at FROM order_outs WHERE id = '".$row['id']."'");
                            $row1 = $qry1->fetch_assoc();
                            $max_updated = strtotime($row1['updated_at']);

                            // Next, get the most recent `follow_up_date` from `follow_up` for the given `order_out_id`
                            $qry2 = $conn->query("SELECT MAX(follow_up_date) AS max_followup FROM follow_up WHERE order_out_id = '".$row['id']."'");
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
                            echo date("m/d/y g:i A", $most_recent);

                        
                        
                         ?></b></td>

                        </td>
                        <td><b><?php if($row['date_time_ordered']){$date_time_ordered = date("m/d/y g:i A", strtotime($row['date_time_ordered']));echo $date_time_ordered;}  ?></b>
                        </td>
                        <td><b><?php echo $row['screen_updated']; ?></b></td>
                        <td><b><?php if($row['date_time_completed']){$date_time_completed = date("m/d/y g:i A", strtotime($row['date_time_completed']));echo $date_time_completed;}  ?></b>
                        <td style="color: #df0049;
                            font-weight: 500;">
                            <?php 
                            if (!empty($row['date_time_ordered']) && !empty($row['date_time_completed'])) {
                                $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_ordered']);
                                $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_completed']);
                                $difference = date_diff($date1, $date2);
                                echo "<p >" . $difference->format("%a days, %h hr, %i min, %s sec") . "</p><br>";
                                $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                                if ($hours_passed >= 6) {
                                    echo '<p class="badge badge-danger">6 Hours Exceeded</p>';
                                }
                            }
                            if (!empty($row['date_time_ordered']) && empty($row['date_time_completed'])) {
                                $date = new DateTime();
                                $date2 = $date->format('Y-m-d H:i:s');
                                $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_ordered']);
                                $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2);
                                $difference = date_diff($date1, $date2);
                                echo "<p >" . $difference->format("%a days, %h hr, %i min, %s sec") . "</p><br>";
                                $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                                if ($hours_passed >= 6) {
                                    echo '<p  class="badge badge-danger">6 Hours Exceeded</p>';
                                }
                            }
                        ?>
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






                                <a class="dropdown-item order_outs_followup" href="javascript:void(0)"
                                    data-scrubid="<?php echo $_GET['id']?>" data-id="<?php echo $row['id']?>">Add Follow
                                    Up Details</a>


                                <div class=" dropdown-divider">
                                </div>
                                <a class="dropdown-item order_outs_followup_view" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>">View Follow Up Details</a>

                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item"
                                    href="./index.php?page=view_order&id=<?php echo $_GET['id']?>&oid=<?php echo $row['id']?>&follow_up=1 ">Edit
                                    Follow Up Details</a>

                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item"
                                    href="./index.php?page=edit_order_outs&id=<?php echo $_GET['id']?>&rid=<?php echo $row['id']?>">Edit</a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_scrub" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>">Delete</a>

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
$('#add_followup').click(function() {
    var record_id = $(this).data('id');
    uni_modal("New Follow Up",
        "manage_followup.php?pid=" + record_id, "mid-large")
})


$(document).ready(function() {
    $("#start_order_out").on("click", function() {
        uni_modal("Type of Request", "start_order_outs.php?id=" + $(this).attr("data-id"), "small");
    });
    $('#list').dataTable()
    $('#list tbody').on('click', '.order_outs_followup_view', function() {
        uni_modal("Follow Up Details", "order_outs_followup_view.php?id=" + $(this).attr('data-id') +
            "&scrubid=" + $(this).attr('data-scrubid'), "mid-large")
    })

    $('#list tbody').on('click', '.order_outs_followup', function() {
        uni_modal("Follow Up Details", "order_outs_followup.php?id=" + $(this).attr('data-id'),
            "mid-small")
    })
    $('.delete_scrub').click(function() {
        _conf("Deleting this record will also delete follow up record! are you sure to continue?",
            "delete_scrub", [$(this).attr('data-id')])
    })
})

function delete_scrub($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_order',
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
<?php }?>
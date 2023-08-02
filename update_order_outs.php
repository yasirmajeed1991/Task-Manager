<?php include 'functions.php';?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">

                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="row">
                            <div class="col-md-6" <?php echo $display?>>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="status" required class="form-control-sm select2">
                                        <option></option>
                                        <option value="On Going" <?php if($status=='On Going'){echo 'selected';}?>>
                                        On Going
                                        </option>
                                        <option value="Cancelled" <?php if($status=='Cancelled'){echo 'selected';}?>>
                                            Cancelled
                                        </option>
                                        <option value="Ordered" <?php if($status=='Ordered'){echo 'selected';}?>>Ordered
                                        </option>
                                        <option value="Waiting on processor"
                                            <?php if($status=='Waiting on processor'){echo 'selected';}?>>Waiting on
                                            processor
                                        </option>
                                        <option value="Completed" <?php if($status=='Completed'){echo 'selected';}?>>
                                            Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" <?php echo $display?>>
                                <div class="form-group">
                                    <label for="">2036 Screen Updated</label>
                                    <select name="screen_updated" id="screen_updated" required
                                        class="form-control-sm select2">
                                        <option></option>
                                        <option value="No" <?php if($screen_updated=='No'){echo 'selected';}?>>No
                                        </option>
                                        <option value="Yes" <?php if($screen_updated=='Yes'){echo 'selected';}?>>Yes
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" <?php echo $display?>>
                        <?php     
                            $find_loan_id = find_loan_id($scrub_id, $conn);
                            $loan_detail = get_loan_detail($find_loan_id, $conn);
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
                                    <td style="background-color: #f2f2f2;">Priority:</td>
                                    <td style="background-color: #f2f2f2; color: red;">
                                    <strong><?php echo ucwords($priority);?></strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Due Date:</td>
                                    <td style="background-color: #f2f2f2; color: red;"><strong>
                                        <?php echo date("m/d/y", strtotime($due_date));?></strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Loan No#:</td>
                                    <td style="background-color: #f2f2f2; color: red;">
                                        <?php echo $loan_detail['loan_no'];?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Branch:</td>
                                    <td style="background-color: #f2f2f2; color: red;">
                                        <?php echo $loan_detail['branch'];?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Borrower Name:</td>
                                    <td style="background-color: #f2f2f2; color: #28150a;">
                                        <?php  echo implode("<br>", $loan_detail['borrowers']) ;?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Processor:</td>
                                    <td style="background-color: #f2f2f2; color: blue;">
                                        <?php echo $loan_detail['processor_name'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Coordinator:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php echo implode("<br>", $loan_detail['coordinator_names']);?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Type of Request:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php echo type_of_request($type_of_request, $conn);?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Date Time Ordered:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php echo  date("m/d/y g:i A", strtotime($date_time_ordered));
                              echo "<script>const dbTime = new Date('$date_time_ordered');</script>";   ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Time Lapsed:</td>
                                    <td style="background-color: #f2f2f2; color: red;">
                                        <?php 
                                    if(empty($date_time_completed)) {  
                                      echo  "<p id='timer'></p>";
                                    }
                                    else{

                                        if (!empty($date_time_ordered) && !empty($date_time_completed)) {
                                            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date_time_ordered);
                                            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date_time_completed);
                                            $difference = date_diff($date1, $date2);
                                            echo "<span style='font: weight 200px;'>" . $difference->format("%a days, %h hr, %i min, %s sec") . "</span><br>";
                                            $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                                            if ($hours_passed >= 6) {
                                                echo '<span class="badge badge-danger">6 Hours Exceeded</span>';
                                            }
                                        }
                                        if (!empty($date_time_ordered) && empty($date_time_completed)) {
                                            $date = new DateTime();
                                            $date2 = $date->format('Y-m-d H:i:s');
                                            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date_time_ordered);
                                            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2);
                                            $difference = date_diff($date1, $date2);
                                            echo "<span style='font: weight 200px;'>" . $difference->format("%a days, %h hr, %i min, %s sec") . "</span><br>";
                                            $hours_passed = $difference->h + $difference->days * 24; // total number of hours passed
                                            if ($hours_passed >= 6) {
                                                echo '<span style="font: weight 200px;" class="badge badge-danger">6 Hours Exceeded</span>';
                                            }
                                        }
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <?php if(!empty($date_time_completed)) {?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Order Out Completed:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php  echo date("m/d/y g:i A", strtotime($date_time_completed));
                                                                                                 ?>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php ?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Order Out Status:</td>
                                    <?php if($status=='Completed'){$color='green';}else{$color='red';}?>
                                    <td style="background-color: #f2f2f2; "><?php echo '<span style="color:'.$color.'">'.$status.'</span>'?></td>
                                </tr>
                                
                            </tbody>
                        </table>
                        


                        </p><?php if(empty($date_time_completed)) {?>
                        <div class="form-group">
                            <a id="end_order_outs" class="btn toggle-btn btn-danger " href="javascript:void(0)"
                                data-id="<?php echo $_GET['id']; ?>" data-rid="<?php echo $_GET['rid']; ?>"  >End Order Out</a>
                        </div>
                        <?php }?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Remarks</label>
                            <textarea name="remarks" required id="remarks" cols="30" rows="10"
                                class="summernote form-control">
						<?php echo isset($remarks) ? $remarks : '' ?>
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
    $(document).ready(function() {
    $("#end_order_outs").on("click", function() {
        uni_modal("Confirmation", "end_order_outs.php?id=" + $(this).attr("data-id") + "&rid=" + $(
            this).attr("data-rid"), "small");
    });
});
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=update_order_outs',
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
                        'index.php?page=edit_order_outs&id=<?php echo $_GET['id']?>&rid=<?php echo $_GET['rid']?>'
                }, 2000)

            } 
        }
    })
})
// Get the timer element
const timer = document.getElementById('timer');

// Update the timer every second
setInterval(() => {
    // Get the current time
    const currentTime = new Date();

    // Calculate the time difference in seconds
    const timeDiffInSeconds = Math.floor((currentTime - dbTime) / 1000);

    // Convert the time difference to hours, minutes, and seconds
    const hours = Math.floor(timeDiffInSeconds / 3600);
    const minutes = Math.floor((timeDiffInSeconds % 3600) / 60);
    const seconds = timeDiffInSeconds % 60;

    // Display the time difference
    let timeElapsed = "";
    if (hours >= 24) {
        const days = Math.floor(hours / 24);
        const remainingHours = hours % 24;
        timeElapsed = `${days} days, ${remainingHours} hr, ${minutes} min, ${seconds} sec`;
    } else {
        timeElapsed = `${hours} hr, ${minutes} min, ${seconds} sec`;
    }
    timer.innerHTML = `${timeElapsed}`;

}, 1000);
</script>
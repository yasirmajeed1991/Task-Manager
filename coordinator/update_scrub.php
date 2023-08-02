<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

                <div class="row">
                    <div class="col-md-4" <?php echo $display?>>

                       
                        <div class="row">
                            <div class="col-md-8" <?php echo $display?>>
                                <div class="form-group">
                                    <label for="">Title Request</label>
                                    <input type="datetime-local" required class="form-control form-control-sm"
                                        autocomplete="off" name="title_request"
                                        value="<?php echo isset($title_request) ? $title_request : '' ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Status of Title Request</label>
                                    <select name="status_of_title_request" required id="status_of_title_request"
                                        class="form-control-sm select2">
                                        <option></option>
                                        <option value="Pending"
                                            <?php if($status_of_title_request=='Pending'){echo 'selected';}?>>Pending
                                        </option>
                                        <option value="Received"
                                            <?php if($status_of_title_request=='Received'){echo 'selected';}?>>Received
                                        </option>
                                        <option value="Withdrawn"
                                            <?php if($status_of_title_request=='Withdrawn'){echo 'selected';}?>>
                                            Withdrawn
                                        </option>
                                        <option value="Completed"
                                            <?php if($status_of_title_request=='Completed'){echo 'selected';}?>>
                                            Completed
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" <?php echo $display?>>
                        <?php 
                    
                     
                        
                
                        $result = $conn->query("SELECT * from loan_no where id=$loan_no_id");
                        $row = $result->fetch_assoc();
            
                        $result = $conn->query("SELECT * FROM borrower where loan_no_id=$loan_no_id");
                        $borrower = "";
                        while ($row23 = $result->fetch_assoc()) {
                            $borrower .= $row23['borrower'].' <br>';
                        }
                        
                        $loan_no = $row['loan_no'];
                        $qry2 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');
                        $row2 = $qry2->fetch_assoc();
                        $branch = $row2['branch'];
                        
                        $qry2 = $conn->query('SELECT * FROM users where id = "'.$row['processor'].'"');
                        $row2 = $qry2->fetch_assoc();
                        $processor = $row2['firstname'].' '.$row2['lastname'];
                        
                        $userIds = json_decode($row['coordinator']);
                        $idsStr = implode(",", $userIds);
                        $result = $conn->query("SELECT firstname, lastname FROM users WHERE id IN ($idsStr)");
                        $coordinator = "";
                        while ($row23 = $result->fetch_assoc()) {
                            $coordinator .= $row23['firstname'].' '.$row23['lastname'].'<br>';
                        }
                       ?>

                        <style>
                        .table td,
                        .table th {
                            padding: 0.1rem;
                        }

                        .table td {
                            font-size: 14px;
                        }

                        .table {
                            width: 300px;
                        }
                        </style>
                        <table class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Loan No#:</td>
                                    <td style="background-color: #f2f2f2; color: red;"><?php echo $loan_no?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Branch:</td>
                                    <td style="background-color: #f2f2f2; color: red;"><?php echo $branch?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Borrower Name:</td>
                                    <td style="background-color: #f2f2f2; color: #28150a;"><?php echo $borrower?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Processor:</td>
                                    <td style="background-color: #f2f2f2; color: blue;"><?php echo $processor?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Coordinator:</td>
                                    <td style="background-color: #f2f2f2; color: green;"><?php echo $coordinator?></td>
                                </tr>
                                <?php $result = $conn->query("SELECT * from scrub where loan_no_id=$loan_no_id");
                                        $row = $result->fetch_assoc();if(!empty($row['date_time_started'])) {?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Scrub Started:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php $date_time_started_original =$row['date_time_started'];$date_time_started = date("m/d/y g:i A", strtotime($row['date_time_started']));
                                        
                                          
                                    echo $date_time_started; echo "<script>const dbTime = new Date('$date_time_started_original');</script>";   ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Time Lapsed:</td>
                                    <td style="background-color: #f2f2f2; color: red;">
                                        <?php 
                                    if(empty($row['date_time_completed'])) {  
                                      echo  "<p id='timer'></p>";
                                    }
                                    else{

                                        if (!empty($row['date_time_started']) && !empty($row['date_time_completed'])) {
                                            $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_started']);
                                            $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_time_completed']);
                                            $difference = date_diff($date1, $date2);
                                            echo "<span style='font: weight 200px;'>" . $difference->format("%a days, %h hr, %i min, %s sec") . "</span><br>";
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
                                <?php }?>
                                <?php if(!empty($row['date_time_completed'])) {?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Scrub Completed:</td>
                                    <td style="background-color: #f2f2f2; color: green;">
                                        <?php $date_time_completed = date("m/d/y g:i A", strtotime($row['date_time_completed']));
                                                                                                echo $date_time_completed;    ?>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php if(!empty($row['date_time_started']) && !empty($row['date_time_completed'])  ) {?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Scrub Status:</td>
                                    <td style="background-color: #f2f2f2; color: green;"><?php echo 'Completed';?></td>
                                </tr>
                                <?php }?>
                                <?php if(!empty($row['date_time_started']) && empty($row['date_time_completed'])  ) {?>
                                <tr>
                                    <td style="background-color: #f2f2f2;">Scrub Status:</td>
                                    <td style="background-color: #f2f2f2; color: red;"><?php echo 'On Going';?></td>
                                </tr>
                                <?php }?>


                            </tbody>
                        </table>
                        <?php if(empty($row['date_time_completed'])) {?>
                        <div class="form-group">
                            <a id="end_scrub" class="btn toggle-btn btn-danger " href="javascript:void(0)"
                                data-id="<?php echo $_GET['id']; ?>" data-loanid="'.$loan_no_id.'">End Scrub</a>
                        </div>
                        <?php }?>

                    </div>
                </div>




                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Remarks</label>
                            <textarea name="remarks_notes" required id="remarks_notes" cols="30" rows="10"
                                class="summernote form-control">
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
                    onclick="location.href='index.php?page=scrub_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#end_scrub").on("click", function() {
        uni_modal("Confirmation", "end_scrub.php?id=" + $(this).attr("data-id") + "&loan_no_id=" + $(
            this).attr("data-loanid"), "small");
    });
});

$('#manage-loan').submit(function(e) {
    e.preventDefault();
    start_load();
    $.ajax({
        url: 'ajax.php?action=update_scrub',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast(
                    'Data successfully saved.',
                    'success');
                setTimeout(function() {
                    location.href = 'index.php?page=edit_scrub&id=<?php echo $_GET['id']?>';
                }, 1500);
            }
            if (resp == 2) {
                alert_toast(
                    'Unable to save data.',
                    'error');
                setTimeout(function() {
                    location.reload()
                }, 1500);
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            console.log(status);
            console.log(error);
            alert_toast('An error occurred while saving the data.', 'error');
        }
    });
});
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
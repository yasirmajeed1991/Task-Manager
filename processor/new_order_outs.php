<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12"><?php if($_SESSION['login_type']!=1){?><h2>Loan File Number: <?php echo $loan_number;}?></h2>
    <h3><?php if($_SESSION['login_type']!=1){?><h2>Name: <?php echo $name;}?></h3>
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">

                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <input type="hidden" name="scrub_id" value="<?php if($_GET['scrub_id']){echo $scrub_id=$_GET['scrub_id'];}else{echo $scrub_id;} ?>">
                <input type="hidden" name="user_id" value="<?php if($_SESSION['login_id']){echo $user_id=$_SESSION['login_id'];}else{echo $user_id;} ?>">
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Type of Request</label>
                            <select name="type_of_request" id="type_of_request" class="form-control-sm select2">
                                <option></option>
                                <?php 
                                        $query = $conn->query("SELECT * FROM  type_of_request ");
                                        while($row= $query->fetch_assoc()):
                                        ?>
                                                        <option value="<?php echo $row['id'] ?>"
                                    <?php echo isset($type_of_request) && $type_of_request == $row['id'] ? "selected" : '' ?>>
                                    <?php echo ucwords($row['type_of_request'] ) ?></option>
                                <?php endwhile; ?>


                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="status" class="form-control-sm select2">
                                <option></option>
                               
                                <option value="Cancelled" <?php if($status=='Cancelled'){echo 'selected';}?>>Cancelled</option>
                                <option value="Ordered" <?php if($status=='Ordered'){echo 'selected';}?>>Ordered</option>
                                <option value="Waiting on processor" <?php if($status=='Waiting on processor'){echo 'selected';}?>>Waiting on processor</option>
                                <option value="Completed" <?php if($screen_updated=='Completed'){echo 'selected';}?>>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>

                 
                <div class="row">



                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Last Touch Date</label>
                            <input type="date" class="form-control form-control-sm" autocomplete="off"
                                name="last_touch_date"
                                value="<?php echo isset($last_touch_date) ? date("Y-m-d",strtotime($last_touch_date)) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date Time Ordered</label>
                            <input type="datetime-local" class="form-control form-control-sm" autocomplete="off"
                                name="date_time_ordered"
                                value="<?php  echo isset($date_time_ordered) ? $date_time_ordered : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">2036 Screen Updated</label>
                            <select name="screen_updated" id="screen_updated" class="form-control-sm select2">
                                <option></option>
                                <option value="No" <?php if($screen_updated=='No'){echo 'selected';}?>>No</option>
                                <option value="Yes" <?php if($screen_updated=='Yes'){echo 'selected';}?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date Time Completed</label>
                            <input type="datetime-local" class="form-control form-control-sm" autocomplete="off"
                                name="date_time_completed"
                                value="<?php  echo isset($date_time_completed) ? $date_time_completed : '' ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="summernote form-control">
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
                    onclick="location.href='index.php?page=view_order&id=<?php echo $_GET['scrub_id'];?>'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_order',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully saved and Intimation has also been made to the Processing Manager, Loan Processong, Loan Coordinating Manager, Loan Coordinator', "success");
                setTimeout(function() {
                    location.href = 'index.php?page=view_order&id=<?php echo $_GET['scrub_id']; ?>'
                }, 1500)

            } else if (resp == 2) {
                $('#msg').html("<div class='alert alert-danger'>Request Type already exist.</div>");
                alert_toast('Request Type already exist.', "danger");
                $('[name="type_of_request"]').addClass("border-danger")
                end_load()
            }
        }
    })
})
</script>
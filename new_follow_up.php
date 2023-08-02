<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12"><?php if($_SESSION['login_type']!=1){?><h2>Loan File Number: <?php echo $loan_number;}?></h2>
    <h3><?php if($_SESSION['login_type']!=1){?><h2>Name: <?php echo $name;}?></h3>
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <input type="hidden" name="order_out_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <div class="form-group">
                    <label for="" class="control-label">Follow Up Date</label>
                    <input type="date" class="form-control form-control-sm" autocomplete="off" id="follow_up_date"
                        name="follow_up_date"
                        value="<?php echo isset($follow_up_date) ? date("Y-m-d",strtotime($follow_up_date)) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">2036 Screen Updated</label>
                    <select name="screen_updated" id="screen_updated" class="form-control form-control-sm select2">
                        <option></option>
                        <option value="No" <?php if($screen_updated=='No'){echo 'selected';}?>>No</option>
                        <option value="Yes" <?php if($screen_updated=='Yes'){echo 'selected';}?>>Yes</option>
                    </select>
                </div>
                <div class="form-group">


                    <label for="" class="control-label">Remarks/Notes</label>
                    <textarea name="remarks_notes" id="remarks_notes" cols="30" rows="10"
                        class="summernote form-control">
						<?php echo isset($remarks_notes) ? $remarks_notes : '' ?>
					</textarea>



                </div>
            </form>


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



<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>

                        <th>Follow Up Date</th>
                        <th>Screen Updated</th>
                        <th>Remarks Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
		$i = 1;
		

		$qry = $conn->query("SELECT * FROM follow_up where order_out_id = ".$_GET['id']." ");
		while($row= $qry->fetch_assoc()):

			

		?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php if($row['follow_up_date']){$follow_up_date = date("m/d/y", strtotime($row['follow_up_date']));echo $follow_up_date;}?></b>
                        </td>
                        <td><b><?php echo $row['screen_updated']; ?></b></td>
                        <td><b><?php echo $row['remarks_notes']; ?></b></td>


                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <!-- <a class="dropdown-item view_loan" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a> -->

                                
                               
                                <a class="dropdown-item"
                                    href="./index.php?page=edit_follow_up&id=<?php echo $row['id']?>&scrub_id=<?php echo $_GET['scrub_id']?> ">Edit</a>
                               
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
                        'index.php?page=new_follow_up&id=<?php echo $_GET['id']; ?>&scrub_id=<?php echo $_GET['scrub_id']; ?>'
                }, 2000)

            }
        }
    })
})
</script>
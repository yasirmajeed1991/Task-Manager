<?php include 'db_connect.php';
      include 'functions.php';  
     
      
?>


<?php if($_GET['new_follow_up_details']==1 || $_GET['edit']==1){
	
	if($_GET['edit']==1){
	$qry = $conn->query("SELECT * FROM scrub_followup where id = ".$_GET['rid'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
	
	?>



<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="container-fluid">
                <form action="" id="manage-loan">
                    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                    <input type="hidden" name="scrub_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id']?>">
                    
                    <div class="form-group">
                        <label for="" class="control-label">Remarks</label>
                        <textarea name="remarks" id="remarks" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($remarks) ? $remarks : '' ?>
					</textarea>
                    </div>

                </form>
            </div>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=scrub_follow_up_details&id=<?php echo $_GET['id']?>'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_scrub_followup',
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
                        'index.php?page=scrub_follow_up_details&id=<?php echo $_GET['id']; ?>'
                }, 1000)

            }
        }
    })
})
</script>

<?php }?>



<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
           
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=scrub_follow_up_details&id=<?php echo $_GET['id'] ?>&new_follow_up_details=1"><i
                        class="fa fa-plus"></i>
                    Add New FollowUp</a>
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
            <div class="card-body">
                <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>ID</th>
                            <th>Follow Up Date</th>
                            <th>Follow Up Made By</th>
                            <th>Remarks</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody style="font-weight: 200;">
                        <?php
					$i=1;
                    $qry = $conn->query("SELECT * FROM scrub_followup where scrub_id='".$_GET['id']."' ");
					while($row= $qry->fetch_assoc()):

						

					?>
                        <tr>
                            <th class="text-center"><?php echo $i++ ?></th>
                            <td><b><?php echo $row['id'] ?></b></td>
                            <td><b><?php if($row['followup_date']){$followup_date = date("m/d/y g:i A", strtotime($row['followup_date']));echo $followup_date;}?></b>
                            </td>
                            <td><b><?php $qry1 = $conn->query('SELECT * FROM users where id = "'.$row['user_id'].'"');$row1= $qry1->fetch_assoc();echo $row1['firstname'].' '.$row1['lastname'];?>
                                </b></td>
                            <td><b><?php echo $row['remarks'] ?></b></td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu" style="">


                                    <a class="dropdown-item"
                                        href="./index.php?page=scrub_follow_up_details&rid=<?php echo $row['id'] ?>&edit=1&id=<?php echo $_GET['id'] ?>">Edit</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_scrub_followup" href="javascript:void(0)"
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
</div>
<script>
$(document).ready(function() {
    $('#list').dataTable();

    $('#list tbody').on('click', '.delete_scrub_followup', function() {
        _conf("Are you sure to delete this record?",
            "delete_scrub_followup", [$(this).attr('data-id')])
    });


});

function delete_scrub_followup($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_scrub_followup',
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
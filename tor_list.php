<?php include'db_connect.php' ?>
<?php if($_GET['add_new_tor']==1 || $_GET['edit_new_tor']==1){
	
	if($_GET['edit_new_tor']==1){
	$qry = $conn->query("SELECT * FROM type_of_request where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
	
	?>



<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">

                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

                <div class="row">
                    <div class="col-md-12" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Detail of Type of Request</label>
                            <input type="text" class="form-control form-control-sm" autocomplete="off"
                                name="type_of_request"
                                value="<?php echo isset($type_of_request) ? $type_of_request : '' ?>">
                        </div>
                    </div>

                </div>



            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=tor_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_tor',
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
                        'index.php?page=tor_list'
                }, 2000)

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

<?php }?>



<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <?php if($_SESSION['login_type']==1){?>
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=tor_list&add_new_tor=1"><i class="fa fa-plus"></i> Add New Request Type
                    Field</a>
            </div>
            <?php }?>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>ID</th>
                        <th>Type of Request</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					
					
					$qry = $conn->query("SELECT * FROM type_of_request ");
					while($row= $qry->fetch_assoc()):

						if($_SESSION['login_type'] ==1){
							$user_valid = 1;
							$login_admin=1;
						}


					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['id'] ?></b></td>
                        <td><b><?php echo $row['type_of_request'] ?></b></td>


                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">



                                <a class="dropdown-item"
                                    href="./index.php?page=tor_list&edit_new_tor=1&id=<?php echo $row['id'] ?>">Edit</a>

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
    $('#list tbody').on('click', '.delete_scrub', function() {
        _conf("Deleting this Loan Scrub details will also delete Order Outs associated with this record! Are you sure to continue?",
            "delete_scrub", [$(this).attr('data-id')])
    });
    
})

function delete_scrub($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_tor',
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
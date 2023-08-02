<?php include'db_connect.php' ?>
<?php if($_GET['add_over_due']==1 || $_GET['edit_over_due']==1){
	
	if($_GET['edit_over_due']==1){
	$qry = $conn->query("SELECT * FROM over_due where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
	// Generate options for days select box
    $options_days = '';
    for ($i = 0; $i <= 30; $i++) {
        $selected = ($i == $days) ? 'selected' : '';
        $options_days .= "<option value='$i' $selected>$i</option>";
    }

    // // Generate options for hours select box
    // $options_hours = '';
    // for ($i = 0; $i <= 24; $i++) {
    //     $selected = ($i == $hours) ? 'selected' : '';
    //     $options_hours .= "<option value='$i' $selected>$i</option>";
    // }
	?>



<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">

                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Select Branch</label>
                            <select name="branch" required id="branch" class="form-control-sm select2">
                                <option></option>
                                <?php 
                                    $managers = $conn->query("SELECT * FROM branch ");
                                    while($row= $managers->fetch_assoc()):
                                    ?>
                                <option value="<?php echo $row['id'] ?>" <?php if (isset($branch) && $branch == $row['id']) {
                                    $branch1 = $row['id'];
                                    echo     "selected";
                                } else {
                                    echo "";
                                    }?>>
                                    <?php echo ucwords($row['branch']) ?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Select Days</label>
                            <?php echo "<select name='days' class='form-control-sm select2'>$options_days</select>  ";?>
                        </div>
                    </div>

                </div>
                <!-- <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                        <label for="">Select Hours</label>
                            <?php echo "<select name='hours' class='form-control-sm select2'>$$options_hours</select>  ";?>
                        </div>
                    </div>

                </div> -->


            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=over_due_interval'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_over_due_interval',
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
                        'index.php?page=over_due_interval'
                }, 1000)

            } else if (resp == 2) {
                alert_toast(
                    'Over due interval for the specified branch already existed. please use another branch to set a interval.',
                    "error");
                setTimeout(function() {
                    location.reload();
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
                    href="./index.php?page=over_due_interval&add_over_due=1"><i class="fa fa-plus"></i> Add
                    New Over Due Interval</a>
            </div>

        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>ID</th>
                        <th>Branch</th>
                        <th>days</th>
                        <!-- <th>hours</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					
					
					$qry = $conn->query("SELECT * FROM over_due ");
					while($row= $qry->fetch_assoc()):

						

					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['id'] ?></b></td>
                        <td><b><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?></b>
                        </td>
                        <td><b><?php echo $row['days'] ?></b></td>
                        <!-- <td><b><?php echo $row['hours'] ?></b></td> -->

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">



                                <a class="dropdown-item"
                                    href="./index.php?page=over_due_interval&edit_over_due=1&id=<?php echo $row['id'] ?>">Edit</a>

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
        _conf("Are you sure to continue?",
            "delete_scrub", [$(this).attr('data-id')])
    });
    
})

function delete_scrub($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_odi',
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
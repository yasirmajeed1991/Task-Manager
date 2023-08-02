<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">

            </div>
        </div>
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                    <div class="col-sm-4 mb-2">
                            <label for="field1" class="form-label">Branch Name</label>
                            <select name="branch" id="field1" class="form-control-sm select2">
                                <option></option>
                                <?php 
                                    $managers = $conn->query("SELECT * FROM branch ");
                                    while($row= $managers->fetch_assoc()):
                                    ?>
                                <option value="<?php echo ucwords($row['branch']); ?>">
                                    <?php echo ucwords($row['branch']); ?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <label for="field2" class="form-label">Assigned Processor </label>
                            <input type="text" class="form-control form-control-sm" id="field2">
                        </div>
                       
                        
                        <div class="col-sm-4 mb-2">
                            <label for="field3" class="form-label">Assigned Coordintaor</label>
                            <input type="text" class="form-control form-control-sm" id="field3">
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-sm-3 mb-2">
                            <label for="searchBtn" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-sm form-control"
                                id="searchBtn">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">Sr#</th>
                        <th>Branch</th>
                        <th>Assigned Processor</th>
                         <th>Assigned Loan Coordinator</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$type = array('',"Admin","Processor","Loan Coordinator");
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type!=1 and type=2 order by concat(firstname,' ',lastname) asc ") ;
					while($row= $qry->fetch_assoc()):
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                       
                        <td><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?>
                        </td>
                        <td><?php echo ucwords($row['firstname'].' '.$row['lastname']) ?></td> 

                        <td><?php $qry1 = $conn->query('SELECT * FROM mapping where user_id = "'.$row['id'].'"');
															while($row1= $qry1->fetch_assoc()){
															
													?>
                                <?php $qry11 = $conn->query('SELECT * FROM users where id = "'.$row1['coordinator'].'"');
							$row11= $qry11->fetch_assoc();
							echo $row11['firstname'].' '.$row11['lastname'];?>

                                <a class="delete_mapping" title="Remove Loan Coordinator" href="javascript:void(0)"
                                    data-id="<?php echo $row1['id'] ?>"><i class="fas fa-times"
                                        style="color:red"></i></a><br>



                                <?php }?>
                        </td>

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item mapping" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>" data-branch="<?php echo $row['branch'] ?>">Assign
                                    Coordinator</a>
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
    $('#list tbody').on('click', '.mapping', function() {
        uni_modal("Update Mapping Details:", "mapping.php?id=" + $(this)
            .attr('data-id') + "&branch=" + $(this).attr('data-branch'), "mid-small")
    })
    $('#list tbody').on('click', '.delete_mapping', function() {
        _conf("Are you sure to remove this data?",
            "delete_mapping", [$(this).attr('data-id')])
    });
    var table = $('#list').DataTable();

$('#searchBtn').on('click', function() {
    var field1 = $('#field1').val();
    var field2 = $('#field2').val();
    var field3 = $('#field3').val();
    var field4 = $('#field4').val();
    

    table.columns(1).search(field1).draw();
    table.columns(2).search(field2).draw();
    table.columns(3).search(field3).draw();
    table.columns(4).search(field4).draw();
    
});

});

function delete_mapping($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_mapping',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Successfully De-Assigned", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1000)

            }
        }
    })
}
</script>
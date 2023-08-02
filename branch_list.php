<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=new_branch"><i class="fa fa-plus"></i> Add New Branch</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field1" class="form-label">Branch ID </label>
                            <input type="text" class="form-control form-control-sm" id="field1">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field2" class="form-label">Branch Name</label>
                            <select name="branch" id="field2" class="form-control-sm select2">
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
                        <div class="col-sm-3 mb-2">
                            <label for="field3" class="form-label">Address</label>
                            <input type="text" class="form-control form-control-sm" id="field3">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field4" class="form-label">Contact</label>
                            <input type="text" class="form-control form-control-sm" id="field4">
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
                        <th>Branch ID</th>
                        <th>Branch Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					
					$qry = $conn->query("SELECT *FROM branch ");
					while($row= $qry->fetch_assoc()):
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo ucwords($row['branch']) ?></td>
                        <td><?php echo $row['address'] ?></td>
                        <td><?php echo $row['contact'] ?></td>

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">

                                <a class="dropdown-item"
                                    href="./index.php?page=edit_branch&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_branch" href="javascript:void(0)"
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

    $('.delete_branch').click(function() {
        _conf("Deleting this Branch will also delete all the data associated with this branch! So be carefully before deleting this.?",
            "delete_branch", [$(this).attr('data-id')])
    })
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
})

function delete_branch($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_branch',
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
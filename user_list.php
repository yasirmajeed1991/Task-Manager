<?php include'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i
                        class="fa fa-plus"></i> Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field1" class="form-label">ID </label>
                            <input type="text" class="form-control form-control-sm" id="field1">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field2" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-sm" id="field2">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field3" class="form-label">Email</label>
                            <input type="text" class="form-control form-control-sm" id="field3">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field4" class="form-label">Branch</label>
                            <select name="branch" id="field4" class="form-control-sm select2">
                                <option></option>
                                <?php 
              	$managers = $conn->query("SELECT * FROM branch ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                <option value="<?php echo ucwords($row['branch']) ?>"
                                    >
                                    <?php echo ucwords($row['branch']) ?></option>
                                <?php endwhile; ?>

                            </select>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field5" class="form-label">Role</label>
                            
                        <select name="type" id="field5" class="form-control-sm select2">
                            <option></option>

                            <option value="Processor">Processor</option>

                            <option value="Loan Coordinator">Loan Cordinator
                            </option>

                        </select>
                            
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="searchBtn" class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-sm form-control"
                                id="searchBtn">Search</button>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">Sr#</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Branch</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$type = array('',"Admin","Processor","Loan Coordinator");
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type!=1 order by concat(firstname,' ',lastname) asc ") ;
					while($row= $qry->fetch_assoc()):
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo ucwords($row['name']) ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?>
                        </td>
                        <td><?php echo $type[$row['type']] ?></td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item view_user" href="javascript:void(0)"
                                    data-id="<?php echo $row['id'] ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_user" href="javascript:void(0)"
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
    $('.view_user').click(function() {
        uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr(
            'data-id'))
    })
    $('#list tbody').on('click', '.delete_user', function() {
        _conf("Are you sure to delete this user?",
            "delete_user", [$(this).attr('data-id')])
    });
    var table = $('#list').DataTable();
    $('#searchBtn').on('click', function() {
        var field1 = $('#field1').val();
        var field2 = $('#field2').val();
        var field3 = $('#field3').val();
        var field4 = $('#field4').val();
        var field5 = $('#field5').val();
        table.columns(1).search(field1).draw();
        table.columns(2).search(field2).draw();
        table.columns(3).search(field3).draw();
        table.columns(4).search(field4).draw();
        table.columns(5).search(field5).draw();
    });
})

function delete_user($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_user',
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
<?php include'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_borrower"><i
                        class="fa fa-plus"></i> Add New loan Borrower</a>
            </div>
           
        </div>
        <div class="card-body"><div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="field1" class="form-label">Borrower </label>
                            <input type="text" class="form-control form-control-sm" id="field1"
                               >
                        </div>
                        <div class="col-md-6">
                            <label for="field2" class="form-label">Loan Number</label>
                            <input type="text" class="form-control form-control-sm" id="field2"
                                >
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
                        <th class="text-center">#</th>
                        <th>Borrower Name</th>
                        <th>Assigned Loan Number / Branch</th>
                       
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					
					$qry = $conn->query("SELECT borrower.* 
                    FROM borrower 
                    INNER JOIN loan_no ON borrower.loan_no_id = loan_no.id 
                    WHERE loan_no.processor = {$_SESSION['login_id']} 
                    ORDER BY borrower.id DESC
                    ");
					while($row= $qry->fetch_assoc()):

						

					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><?php echo $row['borrower']; ?></td>
                        <td><?php $qry1 = $conn->query('SELECT * FROM loan_no where id = "'.$row['loan_no_id'].'"');$row1= $qry1->fetch_assoc();echo $row1['loan_no'].'<br>';?>
                        <?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row1['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?>
                    
                        </td>

                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item"
                                    href="./index.php?page=edit_borrower&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_borrower" href="javascript:void(0)"
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
    $('.view_loan').click(function() {
        uni_modal("<i class='fa fa-id-card'></i> loan Details", "view_loan.php?id=" + $(this).attr(
            'data-id'))
    })
    $('.delete_borrower').click(function() {
        _conf("Are you sure to continue?",
            "delete_borrower", [$(this).attr('data-id')])
    })
    var table = $('#list').DataTable();
    $('#searchBtn').on('click', function() {
        var field1 = $('#field1').val();
        var field2 = $('#field2').val();
        table.columns(1).search(field1).draw();
        table.columns(2).search(field2).draw();
        
    });
})

function delete_borrower($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_borrower',
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
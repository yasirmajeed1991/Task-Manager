<?php include'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <?php if($_SESSION['login_type']==1){?>
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=new_loan_number"><i class="fa fa-plus"></i> Add New loan Number</a>
            </div>
            <?php }?>
        </div>
        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field1" class="form-label">Loan Number </label>
                            <input type="text" class="form-control form-control-sm" id="field1">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field2" class="form-label">Branch Name</label>
                            <input type="text" class="form-control form-control-sm" id="field2">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field3" class="form-label">Borrower</label>
                            <input type="text" class="form-control form-control-sm" id="field3">
                        </div>
                        <div class="col-sm-3 mb-2">
                            <label for="field4" class="form-label">Processor</label>
                            <input type="text" class="form-control form-control-sm" id="field4">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 mb-2">
                            <label for="field5" class="form-label">Coordinators</label>
                            <input type="text" class="form-control form-control-sm" id="field5">
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
                        <th class="text-center">#</th>
                        <th>Loan ID</th>
                        <th>Loan Number</th>
                        <th>Branch</th>
                        <th>Borrower</th>
                        <th>Processor</th>
                        <th>Assigned Coordinators</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM loan_no order by id DESC");
					while($row= $qry->fetch_assoc()):
					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><?php echo ucwords($row['id']) ?></td>
                        <td><?php echo ucwords($row['loan_no']) ?></td>
                        <td><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?>
                        </td>
                        <td><?php 
                                $borrower_result = $conn->query("SELECT * FROM borrower WHERE loan_no_id=".$row['id']." ");
                                if ($borrower_result->num_rows > 0) {
                                    while ($row23 = $borrower_result->fetch_assoc()) {
                                        echo $row23['borrower'].'<br>';
                                    }
                                } else {
                                    echo "<a class='dropdown-item assign_borrower' href='javascript:void(0)' data-id='".$row['id']."' data-branch='".$row['branch']."'><i style='color:red' class='fa fa-plus'></i> <span style='color:red'>Click to Assign a Borrower</span></a>";
                                }
                                ?>
                        </td>
                        <td><?php $qry1 = $conn->query('SELECT * FROM users where id = "'.$row['processor'].'"');$row1= $qry1->fetch_assoc();echo $row1['firstname'].' '.$row1['lastname'];?>
                        </td>
                        <td><?php // Assuming that $db is a mysqli object connected to your database
                             $userIds = json_decode($row['coordinator']);
                             if (is_array($userIds) && !empty($userIds[0])) {
                                $idsStr = implode(",", $userIds);
                                $result = $conn->query("SELECT firstname, lastname FROM users WHERE id IN ($idsStr)");
                                // rest of your code here
                            }
                             // Fetch the results and store them in an array of arrays
                             $userData = [];
                             while ($row23 = $result->fetch_assoc()) {
                                 echo $row23['firstname'].' '.$row23['lastname'].'<br>';
                             }
                                ?>
                        </td>
                        <td><?php // Assuming that $db is a mysqli object connected to your database
                            $check_result = $conn->query("SELECT * FROM scrub WHERE loan_no_id='".$row['id']."'")->fetch_assoc();
                            if ($check_result) {
                                if ($check_result['status_of_scrub'] == 'Completed') {
                                    echo '<span class="badge badge-success">Scrub Completed</span>';
                                    $scrub_result=0;
                                } else {
                                    echo '<span class="badge badge-danger">On Going</span>';
                                    $scrub_result=0;
                                }
                            } else {
                                echo '<span class="badge badge-danger">No Scrub Started Yet!</span>';
                                $scrub_result=1;
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu" style="">
                                <?php if ($scrub_result) {?>
                                <a class="dropdown-item" id="start_scrub" href="javascript:void(0)"
                                    data-id="<?php echo  $row['id']; ?>" data-loanid="<?php echo  $row['id']; ?>">Start
                                    Scrub</a>
                                <div class="dropdown-divider"></div>
                                <?php }else{?>
                                <a class="dropdown-item"
                                    href="./index.php?page=edit_scrub&id=<?php  $edit_scrub = $conn->query("SELECT id FROM scrub WHERE loan_no_id='".$row['id']."'")->fetch_assoc();echo $edit_scrub['id']?>">View
                                    Scrub</a>
                                <div class="dropdown-divider"></div>
                                <?php
                                            $result = $conn->query("SELECT scrub_id FROM  order_outs WHERE scrub_id = '{$edit_scrub['id']}' GROUP BY scrub_id HAVING COUNT(*) > 0");
                                            $view_order = $result->fetch_assoc();
                                            if ($view_order['scrub_id']) {
                                                echo '<a class="dropdown-item"
                                                href="./index.php?page=view_order&id='.$view_order['scrub_id'].'">View Order Outs
                                                Details</a><div class="dropdown-divider"></div>';
                                            } 
                                            ?>
                                <?php }?>
                                <a class="dropdown-item"
                                    href="./index.php?page=edit_loan_number&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_loan_number" href="javascript:void(0)"
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
    $('#list tbody').on('click', '#start_scrub', function() {
        uni_modal("Confirmation", "start_scrub.php?id=" + $(this).attr("data-id") + "&loan_no_id=" + $(
            this).attr("data-loanid"), "small");
    });
    $('#list').dataTable()
    $('#list tbody').on('click', '.assign_borrower', function() {
        uni_modal("Assign Borrower:", "assign_borrower.php?id=" + $(this)
            .attr('data-id') + "&branch=" + $(this).attr('data-branch'), "mid-small")
    })
    $('.view_loan').click(function() {
        uni_modal("<i class='fa fa-id-card'></i> loan Details", "view_loan.php?id=" + $(this).attr(
            'data-id'))
    })
    $('#list tbody').on('click', '.delete_loan_number', function() {
        _conf("Deleting this Loan details will also delete Borrower, Scrubs, Scrub Folowups, Order Outs and Order Outs Followup associated with this record! Are you sure to continue?",
            "delete_loan_number", [$(this).attr('data-id')])
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

function delete_loan_number($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_loan_number',
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
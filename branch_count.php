<?php include'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">

        <div class="card-body">
            <div class="container my-4">
                <h2 class="text-center mb-3">Search</h2>
                <div class="rounded bg-secondary p-3">
                    <div class="row">
                    <div class="col-sm-4 mb-2">
                            <label for="field1" class="form-label">Branch</label>
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
                            <label for="field3" class="form-label">Full Name</label>
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

            <table class="table table-hover table-bordered" id="list" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Branch</th>
                        <th>Role</th>
                        <th>Full Name</th>
                        <th>Loan Assigned</th>
                        <th>Total Scrub</th>
                        <th>Completed Scrub</th>
                        <th>Pending Scrub</th>
                        <th>Scrub Followup</th>
                        <th>Total Order Outs</th>
                        <th>Completed Order Outs</th>
                        <th>Pending Order Outs</th>
                        <th>Order Outs Followup</th>

                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					$qry = $conn->query("SELECT 
                    b.branch,
                    'Loan Coordinator' AS type_name,
                    CONCAT(u.firstname, ' ', u.lastname) AS full_name,
                    COUNT(DISTINCT loan.id) AS loan_assigned,
                    COUNT(DISTINCT scrub.id) AS scrubs,
                    COUNT(DISTINCT CASE WHEN scrub.status_of_scrub = 'Completed' THEN scrub.id ELSE NULL END) AS scrub_completed,
                    COUNT(DISTINCT CASE WHEN scrub.status_of_scrub != 'Completed' THEN scrub.id ELSE NULL END) AS scrub_pending,
                    COUNT(DISTINCT order_outs.id) AS order_outs,
                    COUNT(DISTINCT CASE WHEN order_outs.status = 'Completed' THEN order_outs.id ELSE NULL END) AS order_outs_completed,
                    COUNT(DISTINCT CASE WHEN order_outs.status != 'Completed' THEN order_outs.id ELSE NULL END) AS order_outs_pending,
                    COUNT(DISTINCT follow_up.id) AS follow_ups,
                    COUNT(DISTINCT scrub_followup.id) AS scrub_followups
                  FROM 
                    users u
                    JOIN branch b ON u.branch = b.id
                    LEFT JOIN (
                      SELECT 
                        loan.id, 
                        JSON_EXTRACT(loan.coordinator, '$[0]') AS coordinator
                      FROM 
                        loan_no loan
                    ) loan ON u.id = loan.coordinator
                    LEFT JOIN scrub ON u.id = scrub.updated_by
                    LEFT JOIN scrub_followup ON scrub.id = scrub_followup.scrub_id
                    LEFT JOIN order_outs ON scrub.id = order_outs.scrub_id
                    LEFT JOIN follow_up ON order_outs.id = follow_up.order_out_id
                    LEFT JOIN scrub_followup sf ON u.id = sf.updated_by
                  WHERE 
                    u.type = 3
                  GROUP BY 
                    b.branch, 
                    full_name;
                ");
					while($row= $qry->fetch_assoc()):

						

					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['branch']; ?></b>
                        </td>
                        <td><b><?php echo $row['type_name']; ?></b>
                        </td>
                        <td><b><?php echo $row['full_name']; ?></b></td>
                        <td><b><?php echo $row['loan_assigned']; ?></b></td>

                        <td><b><?php echo $row['scrubs']; ?></b>
                        </td>
                        <td><b><?php echo $row['scrub_completed']; ?></b></td>

                        <td><b><?php echo $row['scrub_pending']; ?></b></td>
                        <td><b><?php echo $row['scrub_followups']; ?></b></td>
                        <td><b><?php echo $row['order_outs']; ?></b></td>

                        <td><b><?php echo $row['order_outs_completed']; ?></b></td>
                        <td><b><?php echo $row['order_outs_pending']; ?></b></td>
                        <td><b><?php echo $row['follow_ups']; ?></b></td>


                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var table = $('#list').DataTable();

    $('#field1, #field3').on('change', function() {
        var field1 = $('#field1').val();
        
        var field3 = $('#field3').val();

        table.columns(1).search(field1).draw();
        
        table.columns(3).search(field3).draw();

    });
});
</script>
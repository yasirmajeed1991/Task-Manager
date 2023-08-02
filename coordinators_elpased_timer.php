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
                            <label for="field2" class="form-label">Full Name</label>
                            <input type="text" class="form-control form-control-sm" id="field2">
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
                        <th>Full Name</th>
                        <th>All Scrub Time Elapsed</th>
                        <th>All Order Outs Time Elapsed</th>
                        
                    </tr>
                </thead>
                <tbody style="font-weight: 200;">
                    <?php
					$i = 1;
					$qry = $conn->query("SELECT 
                    u.id,
                    b.branch,
                    CONCAT(u.firstname, ' ', u.lastname) AS full_name,
                    CONCAT(
                        FLOOR(HOUR(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, s.date_time_started, COALESCE(s.date_time_completed, NOW()))))) / 24), ' days ',
                        MOD(HOUR(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, s.date_time_started, COALESCE(s.date_time_completed, NOW()))))), 24), ' hours ',
                        MINUTE(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, s.date_time_started, COALESCE(s.date_time_completed, NOW()))))), ' minutes ',
                        SECOND(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, s.date_time_started, COALESCE(s.date_time_completed, NOW()))))), ' seconds'
                    ) AS scrub_elapsed_time,
                    CONCAT(
                        FLOOR(HOUR(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, o.date_time_ordered, COALESCE(o.date_time_completed, NOW()))))) / 24), ' days ',
                        MOD(HOUR(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, o.date_time_ordered, COALESCE(o.date_time_completed, NOW()))))), 24), ' hours ',
                        MINUTE(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, o.date_time_ordered, COALESCE(o.date_time_completed, NOW()))))), ' minutes ',
                        SECOND(SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, o.date_time_ordered, COALESCE(o.date_time_completed, NOW()))))), ' seconds'
                    ) AS order_elapsed_time
                FROM 
                    users u
                    LEFT JOIN loan_no ln ON JSON_CONTAINS(ln.coordinator, CONCAT('\"', u.id, '\"'))
                    LEFT JOIN scrub s ON ln.id = s.loan_no_id 
                    LEFT JOIN order_outs o ON s.id = o.scrub_id 
                    LEFT JOIN branch b ON u.branch = b.id
                WHERE 
                    u.type = 3
                GROUP BY 
                    u.id");

					while($row= $qry->fetch_assoc()):

						

					?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['branch']; ?></b>
                        </td>
                        
                        <td><b><?php echo $row['full_name']; ?></b></td>
                        <td style="color:red"><b><?php echo $row['scrub_elapsed_time']; ?></b></td>

                        <td style="color:red"><b><?php echo $row['order_elapsed_time']; ?></b>
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
    var table = $('#list').DataTable();

    $('#field1, #field2').on('change', function() {
        var field1 = $('#field1').val();
        var field2 = $('#field2').val();
        

        table.columns(1).search(field1).draw();
        table.columns(2).search(field2).draw();
       

    });
});
</script>
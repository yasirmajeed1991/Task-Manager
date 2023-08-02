<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            Welcome <?php echo $_SESSION['login_name'] ?>!
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col">
        <a href="./index.php?page=loan_number_list_view">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * FROM scrub ")->num_rows; ?></h3>
                    <p>Search Loan Files</p>
                </div>
                <div class="icon">
                    <i class="fa fa-solid fa-search"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col">
        <a href="./index.php?page=scrub_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php 
echo $conn->query("
SELECT scrub.*
FROM scrub
INNER JOIN loan_no ON scrub.loan_no_id = loan_no.id
WHERE JSON_CONTAINS(loan_no.coordinator, '\"{$_SESSION['login_id']}\"')
")->num_rows; 
?>
</h3>

                    <p>My Scrub Files</p>
                </div>
                <div class="icon">
                    <i class="fa fa-layer-group"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col">
        <a href="./index.php?page=total_order_outs_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT o.*
FROM order_outs o
INNER JOIN scrub s ON o.scrub_id = s.id
INNER JOIN loan_no l ON s.loan_no_id = l.id
WHERE JSON_CONTAINS(l.coordinator, '\"{$_SESSION['login_id']}\"')
")->num_rows;?>

</h3>
                    <p>My Order Outs</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tasks"></i>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-3">
        <a href="./index.php?page=over_due">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php 
                  $i = 1;
                  $branch_id = $_SESSION['login_branch'];
                  $query_result = "SELECT days FROM over_due WHERE branch = '$branch_id'";
                  $result_days = $conn->query($query_result);
                  if ($result_days->num_rows > 0) {
                      $row = $result_days->fetch_assoc();
                      $interval_days = $row['days'];
                  }
                  
                  $currentDate = date('Y-m-d');
                  
                  $query = "SELECT *,
                              DATEDIFF('$currentDate', order_outs.due_date) as days_passed
                          FROM scrub
                          LEFT JOIN loan_no ON scrub.loan_no_id = loan_no.id
                          LEFT JOIN order_outs ON scrub.id = order_outs.scrub_id
                          WHERE order_outs.due_date < DATE_SUB('$currentDate', INTERVAL $interval_days DAY)
                              AND order_outs.date_time_completed = ''
                              AND status != 'Completed'
                              AND JSON_CONTAINS(loan_no.coordinator, '\"{$_SESSION['login_id']}\"') ";
                     $over_rows= $conn->query($query)->num_rows;
                     if($over_rows>0)
                     {
                      echo '<span style="color:red">'.$over_rows.'</span>';
                      $color= 'color:red';
                     }
                     else{
                      echo 0;
                      $color= '';
                     }
                  ?>
              </h3>
              <p>Over Due Order Outs </p>
          </div>
          <div class="icon" style="<?php echo $color;?>">
              <i class="fa fa-exclamation-triangle"></i>
          </div>
            </div>
        </a>
    </div>

</div>


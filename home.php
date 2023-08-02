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
        <a href="./index.php?page=loan_number_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * FROM loan_no ")->num_rows; ?></h3>
                    <p>Loan Files</p>
                </div>
                <div class="icon">
                    <i class="fa fa-solid fa-file"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col">
        <a href="./index.php?page=scrub_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * FROM scrub ")->num_rows; ?></h3>

                    <p>Scrub Files</p>
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
                    <h3><?php echo $conn->query("SELECT * from order_outs")->num_rows; ?></h3>
                    <p>Order Outs</p>
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
                    
                    
                            $currentDate = date('Y-m-d');
                           
                            $query = "SELECT * FROM order_outs WHERE due_date < DATE_SUB('$currentDate', INTERVAL 1 DAY) and date_time_completed ='' and status!='Completed'" ;
                            $result_rows=$conn->query($query)->num_rows;
                            if($result_rows>0){
                                echo '<span style="color:red">'.$result_rows.'</span>';
                            } 
                            else{
                                echo $result_rows;
                            }
                        ?>
                    </h3>
                    <p>Over Due Order Outs for more than 1 Days</p>
                </div>
                <div class="icon" <?php if($result_rows){echo 'style="color:red"';}  ?>>
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
            </div>
        </a>
    </div>

</div>

<div class="row">
<div  class="col-md-3">
        <a href="./index.php?page=branch_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * from branch")->num_rows; ?></h3>
                    <p>Branches</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="./index.php?page=user_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * from users where type!=1")->num_rows; ?></h3>
                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-3">
        <a href="./index.php?page=mapping_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * from users where type=3")->num_rows; ?></h3>
                    <p>Mapping Loan Coordinators</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="./index.php?page=tor_list">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("SELECT * from type_of_request")->num_rows; ?></h3>
                    <p>Custom Type of Request Entries</p>
                </div>
                <div class="icon">
                    <i class="fa fa-info"></i>
                </div>
            </div>
        </a>
    </div>
    
</div>

<div class="row">

<div class="col-md-3">
        <a href="./index.php?page=branch_count">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("select * from users where type=3")->num_rows;
                              
                    ?></h3>
                    <p>Branch Count Search</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calculator"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="./index.php?page=coordinators_elpased_timer">
            <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                    <h3><?php echo $conn->query("select * from users where type=3")->num_rows;
                              
                    ?></h3>
                    <p>Loan Coordinators Elapsed Timer</p>
                </div>
                <div class="icon">
                <i class="fa fa-hourglass-half"></i>
                </div>
            </div>
        </a>
    </div>
</div>

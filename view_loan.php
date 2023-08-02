<?php
include 'db_connect.php';
$stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
$qry = $conn->query("SELECT * FROM loan_file where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}

//giving the authority to user to access some functions of the file

$user_valid = 0;

if(($_SESSION['login_id'] ==1 || $processing_manager || $processor || $loan_coordinating_manager || $assigned_loan_coordinating_manager) && $_SESSION['login_branch'] == $branch) 
{
    $user_valid = 1;

}

?>
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-12">
            <div class="callout callout-info">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <dl>
                                <dt><b class="border-bottom border-primary">Branch</b></dt>
                                <dd><?php $qry1 = $conn->query('SELECT * FROM branch where id = '.$branch.'');$row1= $qry1->fetch_assoc();echo ucwords($row1['branch']);?>
                                </dd>
                                <dt><b class="border-bottom border-primary">Loan Number</b></dt>
                                <dd><?php echo html_entity_decode($loan_number) ?></dd>

                                <dt><b class="border-bottom border-primary">Name</b></dt>
                                <dd><?php echo ucwords($name) ?></dd>
                                <dt><b class="border-bottom border-primary">Milestone</b></dt>
                                <dd><?php $milestone1 = array('',"Initial Review","Submittal","Pre-Processing","Processing","Closed"); echo $milestone1[$milestone]; ?>
                                </dd>
                                <dt><b class="border-bottom border-primary">Lock Expiration Date</b></dt>
                                <dd><?php echo html_entity_decode($lock_expiration_date) ?></dd>
                                <dt><b class="border-bottom border-primary">Scrub Received</b></dt>
                                <dd><?php echo html_entity_decode($scrub_received) ?></dd>
                                <dt><b class="border-bottom border-primary">Scrub Started</b></dt>
                                <dd><?php echo html_entity_decode($scrub_started) ?></dd>
                                <dt><b class="border-bottom border-primary">Scrub Completed</b></dt>
                                <dd><?php echo html_entity_decode($scrub_completed) ?></dd>
                            </dl>
                        </div>
                        <div class="col-sm-4">
                            <dl>
                                <dt><b class="border-bottom border-primary">EOI/HOI/MASTER/POLICY/FLOOD</b></dt>
                                <dd><?php $eoi_hoi_master_policy_flood=json_decode($eoi_hoi_master_policy_flood); echo "<strong>1st: </strong>$eoi_hoi_master_policy_flood[0] <strong> 2nd: </strong> $eoi_hoi_master_policy_flood[1] <strong> 3rd: </strong> $eoi_hoi_master_policy_flood[2]" ?>
                                </dd>
                                <dt><b class="border-bottom border-primary">Mortgage Payoff</b></dt>
                                <dd><?php $mortgage_payoff=json_decode($mortgage_payoff); echo "<strong>1st: </strong>$mortgage_payoff[0] <strong> 2nd: </strong> $mortgage_payoff[1]<strong> 1st: </strong> $mortgage_payoff[2]" ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">Collection Payoff</b></dt>
                                <dd><?php $collection_payoff=json_decode($collection_payoff); echo "<strong>1st: </strong> $collection_payoff[0] <strong> 2nd: </strong> $collection_payoff[1] <strong> 3rd: </strong> $collection_payoff[2]" ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">Credit Supplement</b></dt>
                                <dd><?php $credit_supplement=json_decode($credit_supplement); echo "<strong>1st: </strong> $credit_supplement[0] <strong> 2nd: </strong> $credit_supplement[1] <strong> 3rd: </strong> $credit_supplement[2]" ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">VVOE WVOE</b></dt>
                                <dd><?php $vvoe_wvoe=json_decode($vvoe_wvoe); echo "<strong>1st: </strong> $vvoe_wvoe[0] <strong> 2nd: </strong> $vvoe_wvoe[1] <strong> 3rd: </strong> $vvoe_wvoe[2]" ?>
                                </dd>



                                <dt><b class="border-bottom border-primary">Tax Transcript</b></dt>
                                <dd><?php $tax_transcript=json_decode($tax_transcript); echo "<strong>1st: </strong> $tax_transcript[0] <strong> 2nd: </strong> $tax_transcript[1] <strong> 3rd: </strong> $tax_transcript[2]" ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">Pest Inspection</b></dt>
                                <dd><?php $pest_inspection=json_decode($pest_inspection); echo "<strong>1st: </strong> $pest_inspection[0] <strong> 2nd: </strong> $pest_inspection[1] <strong> 3rd: </strong> $pest_inspection[2]" ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">Payment Vom</b></dt>
                                <dd><?php $payment_vom=json_decode($payment_vom); echo "<strong>1st: </strong> $payment_vom[0] <strong> 2nd: </strong> $payment_vom[1] <strong> 3rd: </strong> $payment_vom[2]" ?>
                                </dd>

                                <dt><b class="border-bottom border-primary">Title Docs</b></dt>
                                <dd><?php $title_docs=json_decode($title_docs); echo "<strong>1st: </strong> $title_docs[0] <strong> 2nd: </strong> $title_docs[1] <strong> 3rd: </strong> $title_docs[2]" ?>
                                </dd>

                            </dl>
                        </div>
                        <div class="col-sm-4">
                            <dl>



                                <dt><b class="border-bottom border-primary">USPS</b></dt>
                                <dd><?php $usps1 = array('',"N/A","In File","Pulled","Not Yet Pulled"); echo $usps1[$usps] ?>
                                </dd>
                                <dt><b class="border-bottom border-primary">Demotech</b></dt>
                                <dd><?php $demotech1 = array('',"N/A","In File","Pulled","Not Yet Pulled"); echo $demotech1[$demotech] ?>
                                </dd>
                                <dt><b class="border-bottom border-primary">Proof of Title Company</b></dt>
                                <dd><?php $proof_of_title_company1 = array('',"N/A","In File","Pulled","Not Yet Pulled"); echo $proof_of_title_company1[$proof_of_title_company] ?>
                                </dd>

                                <dt><b class="border-bottom border-primary">Screen Updated</b></dt>
                                <dd><?php $screen_updated1 = array('',"No","Yes"); echo $screen_updated1[$screen_updated] ?>
                                </dd>



                                <dt><b class="border-bottom border-primary">Scrubbed</b></dt>
                                <dd><?php $scrubbed1 = array('',"No","Yes","In Progress"); echo $scrubbed1[$scrubbed] ?>
                                </dd>


                                <dt><b class="border-bottom border-primary">Remarks</b></dt>
                                <dd><?php echo ucwords($remarks) ?></dd>

                            </dl>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <span><b>Team Member/s:</b></span>
                    <div class="card-tools">



                    </div>
                </div>
                <div class="card-body">
                    <dt><b class="border-bottom border-primary">Processing Manager</b></dt>
                    <dd><?php  $qry1 = $conn->query('SELECT * FROM users where id = '.$processing_manager.'');$row1= $qry1->fetch_assoc();echo $processing_manager = ucwords($row1['firstname'].' '.$row1['lastname']) ;?>
                    </dd>
                    <dt><b class="border-bottom border-primary">Processor</b></dt>
                    <dd><?php  $qry1 = $conn->query('SELECT * FROM users where id = '.$processor.'');$row1= $qry1->fetch_assoc();echo ucwords($row1['firstname'].' '.$row1['lastname']) ;?>
                    </dd>

                    <dt><b class="border-bottom border-primary">Loan Coordinating Manager</b></dt>
                    <dd><?php  $qry1 = $conn->query('SELECT * FROM users where id = '.$loan_coordinating_manager.'');$row1= $qry1->fetch_assoc();echo ucwords($row1['firstname'].' '.$row1['lastname']) ;?>
                    </dd>


                    <dt><b class="border-bottom border-primary">Assigned Loan Coordinating Manager</b></dt>
                    <dd><?php  $qry1 = $conn->query('SELECT * FROM users where id = '.$assigned_loan_coordinating_manager.'');$row1= $qry1->fetch_assoc();echo ucwords($row1['firstname'].' '.$row1['lastname']) ;?>
                    </dd>


                </div>
            </div>
        </div>
        <?php if($user_valid == 1){?>
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <span><b>Task List:</b></span>

                    <div class="card-tools">
                        <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i
                                class="fa fa-plus"></i> New Task</button>
                    </div>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-condensed m-0 table-hover">
                            <colgroup>
                                <col width="5%">
                                <col width="25%">
                                <col width="30%">
                                <col width="15%">
                                <col width="15%">
                            </colgroup>
                            <thead>
                                <th>#</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
							$i = 1;
							$tasks = $conn->query("SELECT * FROM task_list where loan_id = {$id} order by task asc");
							while($row=$tasks->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
								unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
								$desc = strtr(html_entity_decode($row['description']),$trans);
								$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
							?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class=""><b><?php echo ucwords($row['task']) ?></b></td>
                                    <td class="">
                                        <p class="truncate"><?php echo strip_tags($desc) ?></p>
                                    </td>
                                    <td>
                                        <?php 
			                        	if($row['status'] == 1){
									  		echo "<span class='badge badge-secondary'>Pending</span>";
			                        	}elseif($row['status'] == 2){
									  		echo "<span class='badge badge-primary'>On-Progress</span>";
			                        	}elseif($row['status'] == 3){
									  		echo "<span class='badge badge-success'>Done</span>";
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
                                            <a class="dropdown-item view_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['id'] ?>"
                                                data-task="<?php echo $row['task'] ?>">View</a>
                                            <div class="dropdown-divider"></div>
                                            <?php if($_SESSION['login_type'] != 3): ?>
                                            <a class="dropdown-item edit_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['id'] ?>"
                                                data-task="<?php echo $row['task'] ?>">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_task" href="javascript:void(0)"
                                                data-id="<?php echo $row['id'] ?>">Delete</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
							endwhile;
							?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>

    <?php if($user_valid == 1){?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Members Progress/Activity</b>
                    <div class="card-tools">
                        <button class="btn btn-primary bg-gradient-primary btn-sm" type="button"
                            id="new_productivity"><i class="fa fa-plus"></i> New Productivity</button>
                    </div>
                </div>
                <div class="card-body">
                    <?php 
					$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.loan_id = $id order by unix_timestamp(p.date_created) desc ");
					while($row = $progress->fetch_assoc()):
					?>
                    <div class="post">

                        <div class="user-block">
                            <?php if($_SESSION['login_id'] == $row['user_id']): ?>
                            <span class="btn-group dropleft float-right">
                                <span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="cursor: pointer;">
                                    <i class="fa fa-ellipsis-v"></i>
                                </span>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item manage_progress" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>"
                                        data-task="<?php echo $row['task'] ?>">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_progress" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>">Delete</a>
                                </div>
                            </span>
                            <?php endif; ?>
                            <img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>"
                                alt="user image">
                            <span class="username">
                                <a href="#"><?php echo ucwords($row['uname']) ?>[ <?php echo ucwords($row['task']) ?>
                                    ]</a>
                            </span>
                            <span class="description">
                                <span class="fa fa-calendar-day"></span>
                                <span><b><?php echo date('M d, Y',strtotime($row['date'])) ?></b></span>
                                <span class="fa fa-user-clock"></span>
                                <span>Start:
                                    <b><?php echo date('h:i A',strtotime($row['date'].' '.$row['start_time'])) ?></b></span>
                                <span> | </span>
                                <span>End:
                                    <b><?php echo date('h:i A',strtotime($row['date'].' '.$row['end_time'])) ?></b></span>
                            </span>
                        </div>
                        <!-- /.user-block -->
                        <div>
                            <?php echo html_entity_decode($row['comment']) ?>
                        </div>

                        <p>

                    </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
</div>
<style>
.users-list>li img {
    border-radius: 50%;
    height: 67px;
    width: 67px;
    object-fit: cover;
}

.users-list>li {
    width: 33.33% !important
}

.truncate {
    -webkit-line-clamp: 1 !important;
}
</style>
<script>
$('#new_task').click(function() {
    uni_modal("New Task For <?php echo ucwords($processing_manager) ?>",
        "manage_task.php?pid=<?php echo $id ?>", "mid-large")
})
$('.edit_task').click(function() {
    uni_modal("Edit Task: " + $(this).attr('data-task'), "manage_task.php?pid=<?php echo $id ?>&id=" + $(this)
        .attr('data-id'), "mid-large")
})
$('.view_task').click(function() {
    uni_modal("Task Details", "view_task.php?id=" + $(this).attr('data-id'), "mid-large")
})

$('#new_productivity').click(function() {
    uni_modal("<i class='fa fa-plus'></i> New Progress", "manage_progress.php?pid=<?php echo $id ?>", 'large')
})
$('.manage_progress').click(function() {
    uni_modal("<i class='fa fa-edit'></i> Edit Progress", "manage_progress.php?pid=<?php echo $id ?>&id=" + $(
        this).attr('data-id'), 'large')
})
$('.delete_progress').click(function() {
    _conf("Are you sure to delete this progress?", "delete_progress", [$(this).attr('data-id')])
})

$('.delete_task').click(function() {
    _conf("Are you sure to delete this task?", "delete_task", [$(this).attr('data-id')])
})


function delete_progress($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_progress',
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

function delete_task($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_task',
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
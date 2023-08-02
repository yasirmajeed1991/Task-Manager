<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
		<?php if($_SESSION['login_type']==1){ ?>

			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_loan"><i class="fa fa-plus"></i> Add New Loan</a>
			</div>
			<?php }?>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Loan File Number</th>
						<th>Branch</th>
						<th>Name On File</th>
						<th>Task</th>
						<th>Milestone</th>
						<th>Task Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php

						$login_id = $_SESSION['login_id'];
						$login_type = $_SESSION['login_type'];







					$i = 1;
					
					
					$stat = array("","Initial Review","Submittal","Pre-Processing","Processing","Closed");
					$qry = $conn->query("SELECT t.*,p.branch as pbranch,p.loan_number as ploan_number, p.name as pname,p.milestone as pmilestone, p.id as pid FROM task_list t inner join loan_file p on p.id = t.loan_id 
					WHERE p.processing_manager=$login_id OR p.processor=$login_id OR p.loan_coordinating_manager=$login_id OR p.assigned_loan_coordinating_manager=$login_id OR $login_type=1");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
						$tprog = $conn->query("SELECT * FROM task_list where loan_id = {$row['pid']}")->num_rows;
		                $cprog = $conn->query("SELECT * FROM task_list where loan_id = {$row['pid']} and status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
		                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
		                $prod = $conn->query("SELECT * FROM user_productivity where loan_id = {$row['pid']}")->num_rows;
		                 


					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td>
							<p><b><?php echo ucwords($row['ploan_number']) ?></b></p>
						</td>
						<td>
							<p><b><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['pbranch'].'"');$row1= $qry1->fetch_assoc();echo ucwords($row1['branch']);?></b></p>
						</td>
						
						<td>
							<p><b><?php echo ucwords($row['pname']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['task']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo ucwords($stat[$row['pmilestone']]) ?></b></td>
					
						
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
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
			                    <div class="dropdown-menu" style="">
								<a class="dropdown-item" href="./index.php?page=view_loan&id=<?php echo $row['pid'] ?>">View</a>
								  <a class="dropdown-item new_productivity" data-pid = '<?php echo $row['pid'] ?>' data-tid = '<?php echo $row['id'] ?>'  data-task = '<?php echo ucwords($row['task']) ?>'  href="javascript:void(0)">Add Productivity</a>
								
								</div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.new_productivity').click(function(){
		uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"manage_progress.php?pid="+$(this).attr('data-pid')+"&tid="+$(this).attr('data-tid'),'large')
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
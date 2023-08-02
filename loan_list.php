<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<?php if($_SESSION['login_type']==1){?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_loan"><i class="fa fa-plus"></i> Add New loan</a>
			</div>
			<?php }?>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Loan Number</th>
						<th>Name</th>
						<th>Branch</th>
						<th>Processing Manager</th>
						<th>Milestone</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$user_valid = 0;
					$login_admin=0;
					$milestone = array('',"Initial Review","Submittal","Pre-Processing","Processing","Closed");
					$qry = $conn->query("SELECT * FROM loan_file order by id DESC");
					while($row= $qry->fetch_assoc()):

						if($_SESSION['login_type'] ==1){
							$user_valid = 1;
							$login_admin=1;
						}

elseif(($_SESSION['login_id'] == $row['processing_manager'] || $row['processor'] || $row['loan_coordinating_manager'] || $row['assigned_loan_coordinating_manager']) && $_SESSION['login_branch'] == $row['branch']) 
{
    $user_valid = 1;

}

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['loan_number']) ?></b></td>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php $qry1 = $conn->query('SELECT * FROM branch where id = "'.$row['branch'].'"');$row1= $qry1->fetch_assoc();echo $row1['branch'];?></b></td>
						<td><b><?php $qry2 = $conn->query('SELECT * FROM users where id = "'.$row['processing_manager'].'"');$row2= $qry2->fetch_assoc();echo $row2['firstname'].' '.$row2['lastname'] ;?></b></td>
						<td><b><?php echo $milestone[$row['milestone']] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <!-- <a class="dropdown-item view_loan" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a> -->
							  <a class="dropdown-item" href="./index.php?page=view_loan&id=<?php echo $row['id'] ?>">View</a>
								<?php if($user_valid==1){?>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_loan&id=<?php echo $row['id'] ?>">Edit</a>
							  <?php }if($login_admin==1){?>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_loan" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
							  <?php }?>
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
	$(document).ready(function(){
		$('#list').dataTable()
	$('.view_loan').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> loan Details","view_loan.php?id="+$(this).attr('data-id'))
	})
	$('.delete_loan').click(function(){
	_conf("Deleting this Loan details wont recover! Are you sure to delete this loan?","delete_loan",[$(this).attr('data-id')])
	})
	})
	function delete_loan($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_loan',
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
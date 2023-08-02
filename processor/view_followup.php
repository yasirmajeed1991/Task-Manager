<?php 
include 'db_connect.php';

?>
<div class="container-fluid">



<table class="table tabe-hover table-bordered" id="list" style="font-size: 14px;">
	<thead>
		<tr>
			<th class="text-center">#</th>

			<th>Follow Up Date</th>
			<th>Screen Updated</th>
			<th>Remarks Notes</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody style="font-weight: 200;">
		<?php
		$i = 1;
		

		$qry = $conn->query("SELECT * FROM follow_up where order_out_id = ".$_GET['oid']." ");
		while($row= $qry->fetch_assoc()):

			

		?>
		<tr>
			<th class="text-center"><?php echo $i++ ?></th>
			<td><b><?php if($row['follow_up_date']){$follow_up_date = date("m/d/y", strtotime($row['follow_up_date']));echo $follow_up_date;}?></b></td>
			<td><b><?php echo $row['screen_updated']; ?></b></td>
			<td><b><?php echo $row['remarks_notes']; ?></b></td>
			

			<td class="text-center">
				<button type="button"
					class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle"
					data-toggle="dropdown" aria-expanded="true">
					Action
				</button>
				<div class="dropdown-menu" style="">
					<!-- <a class="dropdown-item view_loan" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a> -->

					<?php if($user_valid==1){?>
					<a class="dropdown-item" href="#" data-id="<?php echo $row['id'] ?>"
						id="add_followup">Add Follow Up</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" data-id="<?php echo $row['id'] ?>"
						id="view_followup">View Follow Up</a>
					<div class="dropdown-divider"></div>

					<a class="dropdown-item"
						href="./index.php?page=edit_order&id=<?php echo $row['id']?>&scrub_id=<?php echo $row['scrub_id']?> ">Edit</a>
					<?php }if($login_admin==1){?>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item delete_scrub" href="javascript:void(0)"
						data-id="<?php echo $row['id'] ?>">Delete</a>
					<?php }?>
				</div>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>

</div>

<script>
	$(document).ready(function(){


	$('.summernote').summernote({
        height: 200,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    })
     })
    
    $('#manage-task').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'ajax.php?action=save_followup',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
    	})
    })
</script>
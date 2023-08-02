<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_branch">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">Branch Name</label>
							<input type="text" name="branch" class="form-control form-control-sm" required value="<?php echo isset($branch) ? $branch : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Address Name</label>
							<input type="text" name="address" class="form-control form-control-sm" required value="<?php echo isset($address) ? $address : '' ?>">
						</div>

						<div class="form-group">
							<label for="" class="control-label">Contact</label>
							<input type="number" name="contact" class="form-control form-control-sm" required value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
						
						
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=branch_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	
	$('#manage_branch').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		
		$.ajax({
			url:'ajax.php?action=save_branch',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=branch_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Record Already Exist.</div>");
					alert_toast('Record Already Exist.',"Failed");
					$('[name="branch"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>
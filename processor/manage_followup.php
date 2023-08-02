<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM follow_up where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-task">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="order_out_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		
		<div class="form-group">
                            <label for="">2036 Screen Updated</label>
                            <select name="screen_updated" id="screen_updated" class="form-control form-control-sm select2">
                                <option></option>
                                <option value="No" <?php if($screen_updated=='No'){echo 'selected';}?> >No</option>
                                <option value="Yes" <?php if($screen_updated=='Yes'){echo 'selected';}?>>Yes</option>
                            </select>
                        </div>
		<div class="form-group">
		
		
                            <label for="" class="control-label">Remarks</label>
                            <textarea name="remarks_notes" id="remarks_notes" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($remarks_notes) ? $remarks_notes : '' ?>
					</textarea>
                       
                       
		</div>
	</form>
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
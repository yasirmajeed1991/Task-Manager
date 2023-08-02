<?php 
session_start();
include 'db_connect.php';

?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
        <div class="form-group">
            <label for="">Assign Loan Coordinator</label>
            <select name="coordinator" id="coordinator" required class="form-control form-control-sm select2">
                
                <?php 
				//Getting branch value to only show the same branch processors
				$countValue = 0;
				$branch = $_GET['branch'];
              	$managers = $conn->query("SELECT * FROM users where branch=$branch and  type=3 ");
              	while($row= $managers->fetch_assoc()):
                    $coordinators = $conn->query("SELECT * FROM mapping where user_id='".$_GET['id']."' and  coordinator='".$row['id']."' ")->num_rows;
                    if($coordinators==0)
                    {
                        	
              	?>
                <option value="<?php echo $row['id'] ?>"> <?php echo ucwords($row['firstname'] .' '. $row['lastname'] ) ?></option>
                <?php }endwhile; ?>
            </select>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        var input_val = $('#coordinator').val();
        if (!input_val) {
            alert('There is no coordinator left or the coordinator already assigned cannot be assigned again! Please add new loan coordinator in the users Section.');
            return false;
        }
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_mapping',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Successfully assigned', "success");
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
				if (resp == 2) {
                    alert_toast('Already assigned', "error");
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
            }
        })
    })
})
</script>
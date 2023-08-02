<?php 
session_start();
include 'db_connect.php';

?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="scrub_id" value="<?php echo $_GET['id'] ?>">
        <input type="hidden" name="status" value="On Going">
       

        <div class="form-group">
            <label for="" class="control-label">Select Type of request to Start a New Order Out?</label>
        </div>
        <div class="form-group">
            <select name="type_of_request" id="type_of_request" required class="form-control select2">
                
            <?php 
                                $tor = $conn->query("SELECT * FROM type_of_request ");
                              	while($row= $tor->fetch_assoc()):
              	                ?>

                                    <?php 
                                    $checkLoan = $conn->query("SELECT * FROM order_outs WHERE scrub_id = ".$_GET['id']." AND type_of_request='".$row['id']."'")->num_rows;
                                    if($checkLoan > 0){
                                        // loan exists, do something
                                    } else {?>
                                       
                                        <option value="<?php echo $row['id'] ?>" >
                    <?php echo ucwords($row['type_of_request'] ) ?></option>
                                
                                   

                                        <?php } endwhile; ?>






            </select>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Set Priority</label>
            <select name="priority" id="priority"  required class="form-control select2">

                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Due Date</label>
            <input type="date"  class="form-control form-control-sm" autocomplete="off"
                name="due_date" value="">
        </div>
        
    </form>
</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=start_order_outs',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {

                var response = JSON.parse(resp);

                if (response.status == 1) {
                    alert_toast('Order out has been successfully started', "success");
                    setTimeout(function() {
                        location.href = 'index.php?page=edit_order_outs&rid=' +
                            response
                            .last_id + '&id=<?php echo $_GET['id'] ?>';
                    }, 1500);
                }
                if (response.status == 0) {
                    alert_toast('Order out already existed', "error");
                    setTimeout(function() {
                        location.href = 'index.php?page=view_order&id=<?php echo $_GET['id'] ?>';
                    }, 1500);
                }
            }

        })
    })

})
// Get the current date
var currentDate = new Date().toISOString().substr(0, 10);

// Set the value of the date input field to the current date
document.querySelector('input[name="due_date"]').value = currentDate;

</script>
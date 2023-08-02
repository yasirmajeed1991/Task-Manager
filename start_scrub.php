<?php 
session_start();
include 'db_connect.php';
include 'time_zone.php';
?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="loan_no_id" value="<?php echo $_GET['loan_no_id'] ?>">
        <div class="form-group">
            <input type="hidden" name="status_of_scrub" value="On Going">
            <div class="form-group">

            </div>
            <div class="form-group">
                <label for="">Please select a request date.</label>
                <input type="date" class="form-control form-control-sm" autocomplete="off" name="request_date_time"
                    value="<?php echo $timestamp;?>">
            </div>
            <div class="form-group">
                <label for="">Title Request</label>
                <input type="datetime-local" required class="form-control form-control-sm" autocomplete="off"
                    name="title_request" value="">
            </div>
            <div class="form-group">
                <label for="">Status of Title Request</label>
                <select name="status_of_title_request"  id="status_of_title_request"
                    class="form-control form-control-sm ">
                    
                    <option value="Pending" >Pending </option>
                    
                    <option value="Received" >Received </option>
                   
                    <option value="Withdrawn" > Withdrawn</option>
                       
                    
                    <option value="Completed" >Completed</option>
                        
                    
                </select>
            </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=start_scrub',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                var response = JSON.parse(resp);

                if (response.status == 1) {
                    alert_toast('Scrub has been successfully started', "success");
                    setTimeout(function() {
                        location.href = 'index.php?page=edit_scrub&id=' + response
                            .last_id;
                    }, 1500);
                } else {
                    alert_toast('Failed to save data', "error");
                }
            }

        })
    })
})
// Get the current date
var currentDate = new Date().toISOString().substr(0, 10);

// Set the value of the date input field to the current date
document.querySelector('input[name="request_date_time"]').value = currentDate;
</script>
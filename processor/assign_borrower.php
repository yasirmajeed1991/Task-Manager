<?php 
session_start();
include 'db_connect.php';

?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="loan_no_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
        <div class="form-group">
            <label for="">Borrower Name</label>
            <input type="text" name="borrower" id="borrower" class="form-control form-control-sm ">
                
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_borrower',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Data successfully saved', "success");
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
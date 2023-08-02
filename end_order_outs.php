<?php 
session_start();
include 'db_connect.php';

?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="id" value="<?php echo $_GET['rid'] ?>">
        <div class="form-group">
            <p style="font-size:15px">Ending Orders Outs means you are unable to start or end Order Out later on but you can update the other details so becarefull before ending a Order Out. Save the form before ending a Order Out. Are you still want to continue click on save? if you didnt save the form click on cancel to save the form first.</p>

        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=end_order_outs',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                alert_toast(
                    'Order Out has been successfully ended.',
                    "success");
                setTimeout(function() {
                    location.href = 'index.php?page=edit_order_outs&id=<?php echo $_GET['id']?>&rid=<?php echo $_GET['rid']?>'
                }, 1500)
            }
            }

        })
    })
})
</script>
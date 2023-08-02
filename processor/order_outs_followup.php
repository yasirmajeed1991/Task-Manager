<?php 
session_start();
include 'db_connect.php';

?>
<div class="container-fluid">
    <form action="" id="manage-task">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="order_out_id" value="<?php echo isset($_GET['id']) ? $_GET['id']: '' ?>"> 
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'];?>">
        
           
                <div class="form-group">
                    <label for="" class="control-label">Remarks Notes</label>
                    <textarea name="remarks_notes" id="remarks" cols="30" rows="10" class="summernote form-control"></textarea>
                </div>
        

    </form>

</div>

<script>
$(document).ready(function() {
    $('#manage-task').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_followup',
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
            }
        })
    })
})
</script>
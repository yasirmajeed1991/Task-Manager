<?php if(!isset($conn)){ include 'db_connect.php'; } ?>


<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <input type="hidden" name="created_by" value="<?php echo $_SESSION['login_id'] ?>">
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="row">
                            <div class="col-md-8" <?php echo $display?>>
                                <div class="form-group">
                                    <label for="" class="control-label">Loan Number</label>
                                    <select name="loan_no_id" required id="loan_no_id" class="form-control-sm select2">
                                        <option></option>
                                        <?php 
                                $managers = $conn->query("SELECT * FROM loan_no where processor='".$_SESSION['login_id']."'");
                              	while($row= $managers->fetch_assoc()):
              	                ?>

                                    <?php $checkLoan = $conn->query("SELECT * FROM scrub where loan_no_id=".$row['id'])->num_rows;
                              	            if($checkLoan>0){}else{
                                            ?>
                                   <option value="<?php echo $row['id'] ?>" <?php if (isset($loan_no) && $loan_no == $row['id']) {echo "selected";} else {echo "";}?>><?php echo $row['loan_no']; ?></option>
                                
                                   

                                        <?php } endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <div class="col-md-4" id="populate_data" <?php echo $display?>>
                    </div>
                </div>




               



            </form>
        </div>
        <div class="card-footer border-top border-info">
            
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_scrub',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast(
                    'Data successfully saved and email sent to the concerned.',
                    "success");
                setTimeout(function() {
                    location.href = 'index.php?page=scrub_list'
                }, 1500)

            } else if (resp == 2) {

                alert_toast('Loan Number already exist.', "error");
                $('[name="loan_no"]').addClass("border-danger")
                end_load()
            } else if (resp == 3) {
                alert_toast('Data successfully saved', "success");
                setTimeout(function() {
                    location.href = 'index.php?page=scrub_list'
                }, 1500)
            }

        }
    })
})

$(document).ready(function() {

   

    $("#loan_no_id").on("change", function() {
        var selectedOption = $(this).val();

        $.ajax({
            url: 'ajax.php?action=show_loan_no_detail',
            type: "POST",
            data: {
                option: selectedOption
            },
            dataType: "html",
            success: function(data) {
                $("#populate_data").html(data);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
            }
        });

    });
});

</script>
<?php if(!isset($conn)){ include 'db_connect.php'; } ?>


<div class="col-lg-12">
   
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">

                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="" class="control-label">Borrower Name</label>
                            <input type="text" required class="form-control form-control-sm" name="borrower"
                                value="<?php echo isset($borrower) ? $borrower : '' ?>">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Assign Loan Number</label>
                            <select name="loan_no_id" required id="loan_no_id" class="form-control-sm select2">
                                <option></option>
                                <?php 
              	$managers = $conn->query("SELECT loan_no.id, loan_no.loan_no
                  FROM loan_no
                  WHERE loan_no.processor = {$_SESSION['login_id']}
                  AND loan_no.id IN (
                      SELECT borrower.loan_no_id
                      FROM borrower
                  )
                  ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                <option value="<?php echo $row['id'] ?>" <?php if (isset($loan_no_id) && $loan_no_id == $row['id']) {
                                   
                                    echo     "selected";
                                } else {
                                    echo "";
                                    }?>>
                                    <?php echo $row['loan_no']; ?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=borrower_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
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
                    location.href = 'index.php?page=borrower_list'
                }, 2000)

            } else if (resp == 2) {
                $('#msg').html("<div class='alert alert-danger'>Borrower already exist.</div>");
                alert_toast('Borrower already exist.', "error");
                $('[name="borrower"]').addClass("border-danger")
                end_load()
            }
        }
    })
})
</script>
<?php if(!isset($conn)){ include 'db_connect.php'; } ?>


<div class="col-lg-12">
  
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                
                <div class="row">
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="" class="control-label">Loan Number</label>
                            <input type="text" required class="form-control form-control-sm" name="loan_no"
                                value="<?php echo isset($loan_no) ? $loan_no : '' ?>">
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-6" <?php echo $display?>>
                    <div class="form-group">
                            <label for="">Assigned Loan Coordinator</label>
                            <select name="coordinator[]" id="coordinator" class="form-control-sm select2" multiple>
                                <option></option>
                                
                                <?php 
                               
                                    // Fetch the coordinator values for the logged in user
                                    $mapping_query = $conn->query("SELECT coordinator FROM mapping WHERE user_id=".$_SESSION['login_id']);
                                    
                                    $coordinator_arr = array();
                                    while ($mapping_row = $mapping_query->fetch_assoc()) {
                                        $coordinator_arr = array_merge($coordinator_arr, explode(",", $mapping_row['coordinator']));
                                    }
                                  
                                    // Fetch the full details of the coordinators
                                    $users_query = $conn->query("SELECT * FROM users WHERE id IN (".implode(",", $coordinator_arr).")");
                                    
                                    while ($row = $users_query->fetch_assoc()) {
                                        if(!empty($_GET['id'])){

                                        
                                        $selected = "";
                                        // Fetch the coordinator value for the loan number
                                        $loan_query = $conn->query("SELECT coordinator FROM loan_no WHERE coordinator LIKE '%".$row['id']."%' AND processor ='".$_SESSION['login_id']."'");
                                        if ($loan_query->num_rows > 0) {
                                            $selected = "selected";
                                        }
                                        else{
                                            $selected="";
                                        }
                                    }
                                ?>
                                        <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                          <?php echo ucwords($row['firstname'].' '.$row['lastname']); ?>
                                        </option>
                                <?php 
                                    }
                               
                                
                                
                                  
                            ?>  


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
                    onclick="location.href='index.php?page=loan_number_list'">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        
        url: 'ajax.php?action=save_loan_no',
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
                    location.href = 'index.php?page=loan_number_list'
                }, 500)

            } else if (resp == 2) {
                alert_toast('Loan Number already exist.', "error");
                $('[name="loan_number"]').addClass("border-danger")
                end_load()
            }
        }
    })
})
$(document).ready(function() {
    $('#branch').on('change', function() {
        var branch_id = this.value;

        $.ajax({
            type: "POST",
            url: 'ajax.php?action=populate_branch_processor',
            data: {
                branch_id: branch_id
            },
            dataType: "json",
            success: function(data) {
                $("#processor").empty();
                $("#processor").html("<option value=''></option>");
                $.each(data.officer1, function(key, value) {
                    $("#processor").append("<option value='" + value.id +
                        "'>" + value.firstname + " " + value.lastname +
                        "</option>");
                });


            }
        });

    });
    $('#processor').on('change', function() {
        var processor_id = this.value;

        $.ajax({
            type: "POST",
            url: 'ajax.php?action=populate_branch_coordinator',
            data: {
                processor_id: processor_id
            },
            dataType: "json",
            success: function(data) {
                $("#coordinator").empty();

                $.each(data.officer2, function(key, value) {
                    $("#coordinator").append("<option value='" + value.coordinator +
                        "'>" + value.firstname + " " + value.lastname +
                        "</option>");
                });


            }
        });

    });


});
</script>
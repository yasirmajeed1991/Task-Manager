<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<?php $branch1=0;$display='';if($_SESSION['login_type']!=1){$display= "style='display:none;'";}?>

<div class="col-lg-12"><?php if($_SESSION['login_type']!=1){?><h2>Loan File Number: <?php echo $loan_number;}?></h2>
    <h3><?php if($_SESSION['login_type']!=1){?><h2>Name: <?php echo $name;}?></h3>
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
                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Branch</label>
                            <select name="branch" required id="branch" class="form-control-sm select2">
                                <option></option>
                                <?php 
              	$managers = $conn->query("SELECT * FROM branch ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                <option value="<?php echo $row['id'] ?>" <?php if (isset($branch) && $branch == $row['id']) {
                                    $branch1 = $row['id'];
                                    echo     "selected";
                                } else {
                                    echo "";
                                    }?>>
                                    <?php echo ucwords($row['branch']) ?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Assigned Processor</label>
                            <select name="processor" id="processor" class="form-control-sm select2 ">
                                <option></option>
                                <?php if(!empty($_GET['id'])){
              	$managers = $conn->query("SELECT * FROM users where type=2 ");
              	while($row= $managers->fetch_assoc()):
              	?>
                                <option value="<?php echo $row['id'] ?>" <?php if (isset($processor) && $processor == $row['id']) {
                                    echo "selected";
                                } else {
                                    echo "";
                                    }?>>
                                    <?php echo ucwords($row['firstname'].' '.$row['lastname']) ?></option>
                                <?php endwhile; }?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" <?php echo $display?>>
                        <div class="form-group">
                            <label for="">Assigned Loan Coordinator</label>
                            <select name="coordinator[]" id="coordinator" class="form-control-sm select2" multiple>
                                <option></option>
                                
                                <?php 
                                if(!empty($_GET['id'])){
                                $coordinator_arr = json_decode($coordinator, true);
                                $coordinator_str = implode(",", $coordinator_arr);
                                $users1 = $conn->query("SELECT * FROM users WHERE id IN ($coordinator_str)");
                                    
                                while($row = $users1->fetch_assoc()) {
                                    
                            ?>
                                <option value="<?php echo $row['id']; ?>" selected>
                                    <?php echo ucwords($row['firstname'].' '.$row['lastname']); ?>
                                </option>
                                <?php 
                                }
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
                alert_toast('Data successfully saved and email has been sent to the coordinator', "success");
                setTimeout(function() {
                    location.href = 'index.php?page=loan_number_list'
                }, 500)

            } else if (resp == 2) {
                alert_toast('Loan Number already exist.', "error");
                $('[name="loan_number"]').addClass("border-danger")
                end_load()
            }
            else if (resp == 3) {
                alert_toast('All fields are required! if you havent added coordinators or processor yet please add first before assigning a loan no', "error");
                $('[name="loan_no"]','[name="branch"]','[name="coordinator[]"]','[name="processor"]').addClass("border-danger")
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
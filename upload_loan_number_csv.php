<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Please choose a CSV file</label>
                            <input type="file" id="file-upload" required name="file" />
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
    </div><strong><a style="color:red" href="sample_csv/sample_loan.csv" download>Click Here to Download CSV Sample File</a></strong> <i class="fa fa-file-csv"></i><br><br><br>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault();
    start_load();
    var file_data = $('#file-upload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: 'ajax.php?action=save_loan_number_file',
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully uploaded', "success");
                setTimeout(function() {
                    location.href = 'index.php?page=loan_number_list';
                }, 2000);

            } else if (resp == 3) {
                alert_toast('Only CSV file can be uploaded', "error");
                setTimeout(function() {
                    location.href = 'index.php?page=upload_loan_number_csv';
                }, 2000);

            } else {
                toastr.error('Error uploading data: ' + resp, "", {
                    "timeOut": 10000
                });
                setTimeout(function() {
                    location.href = 'index.php?page=upload_loan_number_csv';
                }, 2000);
            }
        }
    });
});
</script>
<div class="col-lg-12">
    <div class="card card-outline card-success">
       
        <div class="card-footer border-top border-info">
            
        <table class="table table-compact " style="border: 2px solid grey;">
            <tr>
                <th>Fields</th>
                <th>Condition</th>
                <th>Comments</th>
            </tr>
            <tr>
                <td>loan_no</td>
                <td>Mandatory</td>
                <td>Any number <strong>e.g. 1234567890</strong></td>
            </tr>
            <tr>
                <td>borrower</td>
                <td>Mandatory</td>
                <td>Multiple Borrower can be written seprated by comma <strong>e.g. Tom,Dick,Harry</strong>. Single borrower <strong>e.g. Tom</strong> </td>
            </tr>
            <tr>
                <td>branch</td>
                <td>Mandatory</td>
                <td>Create a branch by going to the Branches tab and once the branch created get the ID of that branch <strong>e.g. 1 or 2 or 3 etc.</strong> </td>
            </tr>
            <tr>
                <td>processor</td>
                <td>Mandatory</td>
                <td>Create a <strong>processor</strong> by going to the Users tab and once the processor created for a specific branch get the ID of that User <strong>e.g. 1 or 2 or 3 etc.</strong> </td>
            </tr>
            <tr>
                <td>coordinator</td>
                <td>Mandatory</td>
                <td>Create a <strong>coordinator</strong> by going to the Users tab and once the coordinator created for a specific branch get the ID <strong> e.g. ["1"] or ["2"] or ["3"] or ["1","2","3"] etc.</strong> Keep in 
                mind that there would be sometime one coordinator or more coordinator if there is one coordinator we can add like <strong>["1"]</strong> and if there are multiple coordinator for a single loan we can add them by adding a comma between the different user id <strong>e.g.["1","2","3"]</strong>
            </td>
            </tr>
            <tr>
                <td>request_date_time</td>
                <td>Mandatory</td>
                <td>The date must be in that format <strong> e.g. 2023-02-03</strong> means YYYY-MM-DD
            </td>
            </tr>
            <tr>
                <td>date_time_started</td>
                <td>Mandatory</td>
                <td>The date time must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>date_time_completed</td>
                <td>Optional</td>
                <td>The date time must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>title_request</td>
                <td>Optional</td>
                <td>The date time must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>status_of_title_request</td>
                <td>Mandatory</td>
                <td>This field can be<strong> e.g. Completed or Received or Pending or Withdrawn</strong> 
            </td>
            </tr>
            <tr>
                <td>status_of_scrub</td>
                <td>Mandatory</td>
                <td>This field can be<strong> e.g. On Going or Completed or Cancelled or Withdrawn</strong> 
            </td>
            </tr>
            <tr>
                <td>remarks_notes</td>
                <td>Optional</td>
                <td>This field can contain any Text without any single quotes double quotes or special characters.
            </td>
            </tr>
            <tr>
                <td>created_by</td>
                <td>Mandatory</td>
                <td>This field contains a User ID who created this loan entry its better to use 1 for Admin. That means the upload has been made by the Admin himself.
            </td>
            </tr>
            <tr>
                <td>title_follow_up_date_1</td>
                <td>Optional</td>
                <td>The date time must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>title_follow_up_date_2</td>
                <td>Optional</td>
                <td>The date time must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
        </table>


        </div>
   
</div>
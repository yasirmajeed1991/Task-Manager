<?php if(!isset($conn)){ include 'db_connect.php'; } ?>


<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-loan" enctype="multipart/form-data">



                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="" class="control-label">Please choose a CSV file</label>
                            <input type="file" id="file-upload" name="file" />

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-loan">Save</button>
                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button"
                    onclick="location.href='index.php?page=loan_list'">Cancel</button>
            </div>
        </div>
    </div><strong><a style="color:red" href="sample_csv/sample_order_outs.csv" download>Click Here to Download CSV Sample File</a></strong> <i class="fa fa-file-csv"></i><br><br><br>
</div>
<script>
$('#manage-loan').submit(function(e) {
    e.preventDefault();
    start_load();
    var file_data = $('#file-upload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: 'ajax.php?action=save_order_out_file',
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully uploaded', "success");
                setTimeout(function() {
                    location.href = 'index.php?page=total_order_outs_list';
                }, 2000);

            } else if (resp == 3) {
                alert_toast('Only CSV file can be uploaded', "error");
                setTimeout(function() {
                    location.href = 'index.php?page=upload_order_out_csv_list';
                }, 2000);

            } else {
                toastr.error('Error uploading data: ' + resp, "", {
                    "timeOut": 10000
                });
                setTimeout(function() {
                    location.href = 'index.php?page=upload_order_out_csv_list';
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
                <td>Any number <strong>e.g. 1234567890</strong> that must related to already uploaded Loan number csv</td>
            </tr>
            <tr>
                <td>type_of_request</td>
                <td>Mandatory</td>
                <td>Go to the <strong>Type of Request Fields</strong> Tab add new request Get the ID of the Request Type and Add it <strong>e.g. 1 or 2 or 3 or etc.</strong> </td>
            </tr>
            <tr>
                <td>priority</td>
                <td>Mandatory</td>
                <td>Set priority <strong>e.g. high or meidum or low</strong> </td>
            </tr>
            <tr>
                <td>status</td>
                <td>Mandatory</td>
                <td>Set status to any <strong>Completed or Cancelled or Ordered or On Going or Waiting on processor</strong> </td>
            </tr>
            <tr>
                <td>screen_updated</td>
                <td>Mandatory</td>
                <td>Set field <strong>Yes or No</strong> </td>
            </tr>
            <tr>
                <td>date_time_completed</td>
                <td>Optional</td>
                <td>The field must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>remarks</td>
                <td>Optional</td>
                <td>This field can contain any Text without any single quotes double quotes or special characters.
            </td>
            </tr>
            <tr>
                <td>followup1</td>
                <td>Optional</td>
                <td>The field must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>followup2</td>
                <td>Optional</td>
                <td>The field must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
            <tr>
                <td>followup3</td>
                <td>Optional</td>
                <td>The field must be in that format <strong> e.g. 2023-02-08 13:00:00</strong> means YYYY-MM-DD HH:MM:II
            </td>
            </tr>
              
        </table>


        </div>
   
</div>
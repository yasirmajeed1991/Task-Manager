<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM  follow_up where order_out_id = ".$_GET['id']) ;
	
?>

<style>
.btn-primary {

    display: none;
}
</style>
<div class="card-body">
    <table class="table tabe-hover table-bordered" id="list1" style="font-size: 14px;">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>ID</th>
                <th>Follow Up Date</th>
                <th>Follow Up Made By</th>
                
                <th>Remarks</th>

            </tr>
        </thead>
        <tbody style="font-weight: 200;">
            <?php
					$i=1;
					while($row= $qry->fetch_assoc()):

						

					?>
            <tr>
                <th class="text-center"><?php echo $i++ ?></th>
                <td><b><?php echo $row['id'] ?></b></td>
                <td><b><?php if($row['follow_up_date']){$followup_date = date("m/d/y g:i A", strtotime($row['follow_up_date']));echo $followup_date;}?></b>
                </td>
                <td><b><?php $qry1 = $conn->query('SELECT * FROM users where id = "'.$row['user_id'].'"');$row1= $qry1->fetch_assoc();echo $row1['firstname'].' '.$row1['lastname'];?>
                    </b></td>
                    
                <td><b><?php echo $row['remarks_notes'] ?></b></td>


            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php }?>
<?php
session_start();
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../time_zone.php';
function send_email($recipient_email, $recipient_name, $subject, $body) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;             // Show output (Disable in production)
        $mail->isSMTP();                                   // Activate SMTP sending
        $mail->Host  = 'smtp.titan.email';                  // SMTP Server
        $mail->SMTPAuth  = true;                           // SMTP Identification
        $mail->Username  = 'info@tasker.nightowl.consulting';                // SMTP User
		$mail->Password  = 'B=gsiJHvOQgFw(';	                  		 // SMTP Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port  = 587;
		$mail->setFrom('info@tasker.nightowl.consulting', 'Task Manager');    // Mail sender

        // Add recipient
        $mail->addAddress($recipient_email, $recipient_name);

        // Mail content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body  = $body;

        // Send the email
        if($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle exception
        return false;
    }
}
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."'  ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if($_SESSION['login_type']==1){
				return 1;
			}
			elseif($_SESSION['login_type']==2){
				return 2;
			}
			elseif($_SESSION['login_type']==3)
			{
				return 3;
			}
			else{
				
			}
				
		}else{
			return 4;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../login.php");
	}
	function login2(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '".$student_code."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['rs_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
			
					$recipient_email = $_POST['email'];
					$recipient_password = $_POST['password'];
					$recipient_name = $_POST['firstname'].' '.$_POST['lastname'];
					$subject = 'Task Manager Registration Successfull';
					$email_template_file = 'new_user_email_template.php';
					$email_template = file_get_contents($email_template_file);
					$body = str_replace(array('{{full_name}}', '{{user_email}}', '{{user_password}}','{{date}}'), 
					array($recipient_name,$recipient_email,$recipient_password,date("Y")), 
					$email_template);
					if (send_email($recipient_email, $recipient_name, $subject, $body)) {
						return 1;
					}
					else {
						return 2;
					}
		}
		else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}
		if($save){
			return 1;		
		}
	}
	
	function show_loan_no_detail() {
		if (isset($_POST['option'])) {
			$loan_no_id = $_POST['option'];
	
			$result = $this->db->query("SELECT * from loan_no where id=$loan_no_id");
			$row = $result->fetch_assoc();

			$result = $this->db->query("SELECT * FROM borrower where loan_no_id=$loan_no_id");
			$borrower = "";
			while ($row23 = $result->fetch_assoc()) {
				$borrower .= $row23['borrower'].' <br>';
			}
			
			$loan_no = $row['loan_no'];
			$qry2 = $this->db->query('SELECT * FROM branch where id = "'.$row['branch'].'"');
			$row2 = $qry2->fetch_assoc();
			$branch = $row2['branch'];
			
			$qry2 = $this->db->query('SELECT * FROM users where id = "'.$row['processor'].'"');
			$row2 = $qry2->fetch_assoc();
			$processor = $row2['firstname'].' '.$row2['lastname'];
			
			$userIds = json_decode($row['coordinator']);
			$idsStr = implode(",", $userIds);
			$result = $this->db->query("SELECT firstname, lastname FROM users WHERE id IN ($idsStr)");
			$coordinator = "";
			while ($row23 = $result->fetch_assoc()) {
				$coordinator .= $row23['firstname'].' '.$row23['lastname'].'<br>';
			}
	

			// Output the data in a table
			echo '
			<style>
			.table td, .table th {
				padding: 0.1rem;
			}
			.table td {
				font-size: 14px;
			}
			.table {
				width:300px;
			}
			</style>
			<table class="table table-bordered table-striped table-hover">
				<tbody>
					<tr>
						<td style="background-color: #f2f2f2;">Loan No#:</td>
						<td style="background-color: #f2f2f2; color: red;">'.$loan_no.'</td>
					</tr>
					<tr>
						<td style="background-color: #f2f2f2;">Branch:</td>
						<td style="background-color: #f2f2f2; color: red;">'.$branch.'</td>
					</tr>
					<tr>
						<td style="background-color: #f2f2f2;">Borrower Name:</td>
						<td style="background-color: #f2f2f2; color: #28150a;">'.$borrower.'</td>
					</tr>
					<tr>
						<td style="background-color: #f2f2f2;">Processor:</td>
						<td style="background-color: #f2f2f2; color: blue;">'.$processor.'</td>
					</tr>
					<tr>
						<td style="background-color: #f2f2f2;">Coordinator:</td>
						<td style="background-color: #f2f2f2; color: green;">'.$coordinator.'</td>
					</tr>
				</tbody>
			</table>
						<div class="form-group">
                            <a id="start_scrub" class="btn toggle-btn btn-success "  href="javascript:void(0)" data-id="'.$loan_no.'" data-loanid="'.$loan_no_id.'" >Start Scrub</a>
                        </div>

						<script>
						$(document).ready(function() {


							$("#start_scrub").on("click", function() {
								uni_modal("Confirmation", "start_scrub.php?id=" + $(this).attr("data-id") + "&loan_no_id=" + $(this).attr("data-loanid"), "small");
							});
							
						
							
						});
						</script>';
		
			// Exit the script
			exit();
		}
	}
	
	
	
	function populate_branch_processor(){
		if(isset($_POST['branch_id'])  )  {
			$branch_id = $_POST['branch_id'];
			// Store the officers records in arrays
			$officer1 = array();
			$result = $this->db->query('SELECT * FROM users where branch = '.$branch_id.' && type =2');
			while($row = $result->fetch_assoc()) {
				$officer1[] = $row;
			}
			echo json_encode(array("officer1" => $officer1));
		}
	}

	function populate_branch_coordinator(){
		if(isset($_POST['processor_id'])  )  {
			$processor_id = $_POST['processor_id'];
			// Store the officers records in arrays
			$officer2 = array();
			$result = $this->db->query('SELECT m.coordinator, u.firstname, u.lastname
			FROM mapping m
			JOIN users u ON m.coordinator = u.id
			WHERE m.user_id='.$processor_id.'');
			while($row = $result->fetch_assoc()) {
				$officer2[] = $row;
			}
			echo json_encode(array("officer2" => $officer2));
		}
	}
	
	function save_loan(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){
			if (is_array($v)) {
				$inner_values = array();
				foreach ($v as $innerValue) {
					// do something with $innerValue
					$inner_values[] = $innerValue;
				}
				$json = json_encode($inner_values);
				$data .= ", $k='$json' ";
			} else {
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM loan_file where loan_number = $loan_number ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_file set $data");
		}else{
			$save = $this->db->query("UPDATE loan_file set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function save_loan_number_file(){
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];
	
		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE loan_no");
			$delete_borrower = $this->db->query("TRUNCATE TABLE borrower");
			$delete_scrub = $this->db->query("TRUNCATE TABLE scrub");
			$delete_order_outs = $this->db->query("TRUNCATE TABLE order_outs");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}
	
			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);
	
			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
	
			// Insert the data into the database
			foreach ($data as $row) {
				// Insert loan_no data
				$save_loan_no = $this->db->query("INSERT INTO loan_no (loan_no, branch, processor, coordinator) 
														VALUES ('" . $row['loan_no'] . "', '" . $row['branch'] . "', '" . $row['processor'] . "','" . $row['coordinator'] . "')"
													);
				$loan_id = $this->db->insert_id;
			
				// Split the borrower field into an array of individual names
				$borrowers = explode(",", $row['borrower']);
				foreach ($borrowers as $borrower) {
					$borrower = trim($borrower); // remove any leading/trailing whitespaces
					// Insert borrower data with loan_id
					$save_borrower = $this->db->query("INSERT INTO borrower (loan_no_id, borrower) VALUES ('" . $loan_id . "', '" . $borrower . "')");
					if(!$save_borrower){
						echo "Error executing query for row with loan no: " . $row['loan_no'] . ". Error message: " . $this->db->error() . "<br>";
					}
				}
			
				// Insert scrub data with loan_id
				$save_scrub = $this->db->query("INSERT INTO scrub (loan_no_id, request_date_time, date_time_started, date_time_completed, title_request, status_of_title_request, status_of_scrub, remarks_notes, created_by) 
													VALUES ('" . $loan_id . "', '" . $row['request_date_time'] . "', '" . $row['date_time_started'] . "', '" . $row['date_time_completed'] . "', '" . $row['title_request'] . "', '" . $row['status_of_title_request'] . "', '" . $row['status_of_scrub'] . "', '" . $row['remarks_notes'] . "', '" . $row['created_by'] . "')"
												);

										
												
				if(!$save_scrub){
					echo "Error executing query for row with loan no: " . $row['loan_no'] . ". Error message: " . $this->db->error() . "<br>";
				}
								// Check if the title_follow_up_date_1 and title_follow_up_date_2 fields are not empty
				if(!empty($row['title_follow_up_date_1'])) {
					// Insert scrub follow-up data with scrub_id
					$save_scrub_follow_up_1 = $this->db->query("INSERT INTO scrub_followup (scrub_id, followup_date, user_id, remarks)
					VALUES ('" . $this->db->insert_id . "', '" . $row['title_follow_up_date_1'] . "', '" . $row['created_by'] . "', 'N/A')"
					);
					if(!$save_scrub_follow_up_1){
					echo "Error executing query for row with loan no: " . $row['loan_no'] . ". Error message: " . $this->db->error() . "<br>";
					}
					}
					
					if(!empty($row['title_follow_up_date_2'])) {
					// Insert scrub follow-up data with scrub_id
					$save_scrub_follow_up_2 = $this->db->query("INSERT INTO scrub_followup (scrub_id, followup_date, user_id, remarks)
					VALUES ('" . $this->db->insert_id . "', '" . $row['title_follow_up_date_2'] . "', '" . $row['created_by'] . "', 'N/A')"
					);
					if(!$save_scrub_follow_up_2){
					echo "Error executing query for row with loan no: " . $row['loan_no'] . ". Error message: " . $this->db->error() . "<br>";
					}
					}
			}
			
			if($save_loan_no && $save_scrub && (!isset($save_scrub_follow_up_1) || $save_scrub_follow_up_1) && (!isset($save_scrub_follow_up_2) || $save_scrub_follow_up_2)){
				return 1;
				}
			else{
				echo "Error executing query for row with loan no: " . $row['loan_no'] . ". Error message: " . $this->db->error() . "<br>";
			}
			
	
		} 
		else {
			// Print an error message
			return 3;
		}
	}
	
	
	

	function save_borrower_file(){
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];

		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE borrower");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}

			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);

			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);

			// Insert the data into the database
			foreach ($data as $row) {
			
				$save = $this->db->query("INSERT  INTO borrower (loan_no_id, borrower) 
				VALUES ('" . $row['loan_no_id'] . "', '" . $row['borrower'] . "')"
				);
			}
			if($save>0){
				return 1;
			}
			else{
				echo "Error executing query for row with loan no: " . $row['loan_no_id'] . ". Error message: " . $this->db->error() . "<br>";
			}
			

		} 
		else {
			// Print an error message
			return 3;
		}
	}

	function save_loan_no(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if($k == "coordinator"){
				$v = json_encode($v);
			}
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}
			
		}
		$data .= ", created_by='".$_SESSION['login_id']."' ";
		$data .= ", branch='".$_SESSION['login_branch']."' ";
		$data .= ", processor='".$_SESSION['login_id']."' ";
		$branch = $_SESSION['login_branch'];
		$check = $this->db->query("SELECT * FROM loan_no where loan_no ='$loan_no' ".(!empty($id) ? " and id != {$id} " : ' and branch="'.$branch.'" '  ) )->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO loan_no set $data");
			if($save){
				$processor_name = $this->db->query("SELECT * FROM users WHERE id='".$_SESSION['login_id']."' ");
				$processor_name=$processor_name->fetch_assoc();
				$processor_name = $processor_name['firstname'].' '.$processor_name['lastname'];
				$emailCount = 0;
				$emailCheck = $this->db->query("SELECT * FROM users WHERE id IN ('" . implode("', '", $coordinator) . "')");
				if ($emailCheck->num_rows > 0) {
					while ($row = $emailCheck->fetch_assoc()) {
						$recipient_email = $row['email'];
						$recipient_name = $row['firstname'];
						$subject = 'New Loan Assignment';
						$email_template_file = 'new_loan_email_template.php';
						$email_template = file_get_contents($email_template_file);
						$body = str_replace(array('{{full_name}}', '{{loan_no}}', '{{processor_name}}','{{date}}'), 
						array($row['firstname'].' '.$row['lastname'],$loan_no,$processor_name,date("Y")), 
						$email_template);
						if (send_email($recipient_email, $recipient_name, $subject, $body)) {
							$emailCount++;
						}
					}
					if ($emailCount > 0) {
						return 1;
						
					} 
					else {
						return 2;
						
					}
				}
				
			}

		}else{
			$save = $this->db->query("UPDATE loan_no set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	

	function save_scrub(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}
		}
		$check = $this->db->query("SELECT * FROM scrub where loan_no_id ='$loan_no_id' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO scrub set $data");
			if($save){
				
				return 1;
			}
		}else{
			$save = $this->db->query("UPDATE scrub set $data where id = $id");
			if($save){
				return 1;
			}
			else{
				return 2;
			}
		}
	}
	
	
		function update_scrub(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				
			}
			$data .= ", updated_by='".$_SESSION['login_id']."' ";
			
			if(!empty($id)){
				$save = $this->db->query("UPDATE scrub set $data where id = $id");
			}
	
			if($save){
				return 1;
			}
		}

		function update_order_outs(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
			}
			
			if(!empty($id)){
				$data .= ", updated_by='".$_SESSION['login_id']."' ";
				$save = $this->db->query("UPDATE order_outs set $data where id = $id");
			}
	
			if($save){
				return 1;
			}
		}

	function save_tor(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		
		$check = $this->db->query("SELECT * FROM type_of_request where type_of_request ='$type_of_request' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO type_of_request set $data");
		}else{
			$save = $this->db->query("UPDATE type_of_request set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function save_over_due_interval(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		// $check = $this->db->query("SELECT * FROM over_due WHERE branch = '{$branch}' " . (!empty($id) ? " AND id != '{$id}' " : " AND (days = '{$days}' OR hours = '{$hours}')"))->num_rows;
		$check = $this->db->query("SELECT * FROM over_due WHERE branch = '{$branch}' " . (!empty($id) ? " AND id != '{$id}' " : " OR  days = '{$days}' "))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO over_due set $data");
		}else{
			$save = $this->db->query("UPDATE over_due set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function save_borrower(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		$data .= ", created_by='".$_SESSION['login_id']."' ";
		$check = $this->db->query("SELECT * FROM borrower where borrower ='$borrower' ".(!empty($id) ? " and id != {$id} " : ' and loan_no_id="'.$loan_no_id.'"'))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO borrower set $data");
		}else{
			$save = $this->db->query("UPDATE borrower set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function start_scrub(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		$timestamp = date("Y-m-d H:i:s");
    	$data .= ", created_by='".$_SESSION['login_id']."' ";
		$data .= ", date_time_started='$timestamp' ";

		$check = $this->db->query("SELECT * FROM scrub where loan_no_id =".$loan_no_id." ")->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO scrub set $data");
			
			if ($save) {
				$last_id = $this->db->insert_id;
				echo json_encode(array("status" => 1, "last_id" => $last_id));
			  } else {
				echo json_encode(array("status" => 0));
			  }
		}
		
	}

	function start_order_outs(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		$timestamp = date("Y-m-d H:i:s");
		$data .= ", date_time_ordered='$timestamp' ";
		$data .= ", created_by='".$_SESSION['login_id']."' ";
		$check = $this->db->query("SELECT * FROM order_outs where type_of_request =".$type_of_request." and scrub_id=".$scrub_id)->num_rows;
		if($check > 0){
			echo json_encode(array("status" => 0));
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO order_outs set $data");
			if ($save) {
				$last_id = $this->db->insert_id;
				echo json_encode(array("status" => 1, "last_id" => $last_id));
			  } else {
				echo json_encode(array("status" => 0));
			  }
		}
		
	}

	function end_scrub(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		if(!empty($id)){
			$timestamp = date("Y-m-d H:i:s");
			$data .= ", date_time_completed='$timestamp' ";
			$data .= ", updated_by='".$_SESSION['login_id']."' ";
			$save = $this->db->query("UPDATE scrub set $data where id = $id");
		}
		if($save){
			return 1;
		}
		
	}

	function end_order_outs(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		if(!empty($id)){
			$timestamp = date("Y-m-d H:i:s");
			$data .= ", date_time_completed='$timestamp' ";
			$data .= ", updated_by='".$_SESSION['login_id']."' ";
			$save = $this->db->query("UPDATE order_outs set $data where id = $id");
		}
		if($save){
			return 1;
		}
		
	}

	function save_mapping(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
		}
		$check = $this->db->query("SELECT * FROM mapping where user_id ='$user_id' ".(!empty($id) ? " and id != {$id} " : '')." and coordinator = '$coordinator'")->num_rows;

		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO mapping set $data");
		}else{
			$save = $this->db->query("UPDATE mapping set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function save_followup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		$timestamp = date("Y-m-d H:i:s");
    	$data .= ", follow_up_date='$timestamp' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO follow_up set $data");
		}else{
			$data .= ", updated_by='".$_SESSION['login_id']."' ";
			$save = $this->db->query("UPDATE follow_up set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}

	function save_order(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
		}
		$check = $this->db->query("SELECT * FROM order_outs WHERE type_of_request = '$type_of_request' " 
                            . (!empty($id) ? "AND id != {$id} " : '') 
                            . (!empty($scrub_id) ? "AND scrub_id = '$scrub_id' " : '')
                        )->num_rows;

		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO order_outs set $data");
		}else{
			$save = $this->db->query("UPDATE order_outs set $data where id = $id");
		}
		if($save) {
			// $count = 0;
			// //checking if there exist any scrub file
			// $sid = $this->db->query("SELECT * FROM scrub where id = ".$_POST['scrub_id']);
			// $sid = $sid->fetch_assoc();
			// $tor = $this->db->query("SELECT * FROM type_of_request where id = $type_of_request");
			// $tor = $tor->fetch_assoc();
			// $staffEmail = $this->db->query("SELECT * FROM users where id IN (".$sid['processing_manager'].", ".$sid['loan_processor'].",".$sid['loan_coordinating_manager'].", ".$sid['loan_coordinator'].") ");
			// while ($row = $staffEmail->fetch_assoc()) {
			// 	$recipient_email = $row['email'];
			// 	$recipient_name = $row['firstname'];
			// 	$subject = 'There is an update to the Loan '.$sid['loan_no'].'';
			// 	$body = '<p>Dear <strong>'.$row['firstname'].' '.$row['lastname'].',</strong></p>
			// 	<p>This is to inform you that there has been an update to the following record:</p>
			// 	<table width: 50%; border="1px">
			// 	  <tr>
			// 		<td><strong>Loan Number# </strong></th>
			// 		<td>'.$sid['loan_no'].'</td>
			// 	  </tr>
			// 	  <tr>
			// 		<td><strong>Type: </strong></th>
			// 		<td>Order Outs</td>
			// 	  </tr>
			// 	  <tr>
			// 		<td><strong>Type of Request: </strong></th>
			// 		<td>'.$tor['type_of_request'].'</td>
			// 	  </tr>
			// 	  <tr>
			// 		<td><strong>Priority: </strong></th>
			// 		<td>'.$_POST['priority'].'</td>
			// 	  </tr>
			// 	</table>
			// 	<p>Please review the updated record and take any necessary actions.</p>
			// 	<p>Thank you,</p>
			// 	<p>Regards,<br>Task Manager Team</p>';
			// 	if (send_email($recipient_email, $recipient_name, $subject, $body)) {
			// 		$count++;
			// 	} 
			// }
			// if ($count > 0) {
			// 	return 1;
			// } else {
			// 	return 2;
			// }
				return 1;
		}

		
	}
	
	function save_scrub_file(){
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];

		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE scrub");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}

			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);

			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);

			// Insert the data into the database
			foreach ($data as $row) {
			
				$save = $this->db->query("INSERT  INTO scrub (loan_no_id, request_date_time, date_time_started, date_time_completed, title_request, status_of_title_request,  status_of_scrub, remarks_notes,created_by) 
				VALUES ('" . $row['loan_no_id'] . "', '" . $row['request_date_time'] . "', '" . $row['date_time_started'] . "','" . $row['date_time_completed'] . "', '" . $row['title_request'] . "', '" . $row['status_of_title_request'] . "', '" . $row['status_of_scrub'] . "', '" . $row['remarks_notes'] . "', '" . $row['created_by'] . "')"
				);
				
			}
			if($save>0){
				return 1;
			}
			else{
				echo "Error executing query for row with loan no: " . $row['loan_no_id'] . ". Error message: " . $this->db->error() . "<br>";
			}
			

		} 
		else {
			// Print an error message
			return 3;
		}
	}
	function save_order_out_file() {
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];
	
		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE order_outs");
			$delete_follow_up = $this->db->query("TRUNCATE TABLE follow_up");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}
	
			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);
	
			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
	
			// Insert the data into the database
			// Insert the data into the database
			foreach ($data as $row) {
				$loan_no = $row['loan_no'];
				$status = $row['status'];

				// Get the scrub_id from the scrub table based on the loan_no and status values
				$query = "SELECT id FROM scrub WHERE loan_no_id = (SELECT id FROM loan_no WHERE loan_no = '" . $loan_no . "') ";
				$result = $this->db->query($query);
				if ($result->num_rows > 0) {
					$row_scrub = $result->fetch_assoc();
					$scrub_id = $row_scrub['id'];

					// Save the record in the order_outs table with the corresponding scrub_id value
					$type_of_request = $row['type_of_request'];
					$priority = $row['priority'];
					$status = $row['status'];
					$screen_updated = $row['screen_updated'];
					$date_time_completed = $row['date_time_completed'];
					$remarks = str_replace('"', '', $row['remarks']);
					$remarks = str_replace("'", "", $remarks);

					$save = $this->db->query("INSERT INTO order_outs (scrub_id, type_of_request,due_date,status, priority, date_time_ordered, screen_updated, date_time_completed, remarks,created_by) 
						VALUES ('" . $scrub_id . "', '" . $type_of_request . "', NOW() ,'" . $status . "','" . $priority . "', NOW(), '" . $screen_updated . "', '" . $date_time_completed . "', '" . $remarks . "',1)"
					);

					// Save the follow-up records in the followup table with the corresponding order_outs_id value
					if ($save) {
						$order_out_id = $this->db->insert_id;
						$followup_dates = array($row['followup1'], $row['followup2'], $row['followup3']);
						foreach ($followup_dates as $followup_date) {
							if (!empty($followup_date)) {
								$followup_query = "INSERT INTO follow_up (order_out_id, follow_up_date, remarks_notes, user_id) 
									VALUES ('" . $order_out_id . "', '" . $followup_date . "', 'N/A', 1)";
								$this->db->query($followup_query);
							}
						}
					}
				} else {
					// Handle error when scrub_id not found
				}
			}

	
			if($save > 0) {
				return 1;
			 }
			 return 0; // return 0 if there was an error inserting the data
		} else {
			// Print an error message
			return 3;
		}
	}
	

	function save_followup_csv_file(){
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];

		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE  follow_up");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}

			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);

			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);

			// Insert the data into the database
			foreach ($data as $row) {
			
				
				$row['remarks_notes'] = str_replace('"', '', $row['remarks_notes']);
				$row['remarks_notes'] = str_replace("'", "", $row['remarks_notes']);
				$save = $this->db->query("INSERT  INTO follow_up (order_out_id,  remarks_notes) 
				VALUES ('" . $row['order_out_id'] . "',  '" . $row['remarks_notes'] . "')"
				);
				
			}
			if($save>0){
				return 1;
			}
			else{
				echo "Error executing query for row with loan no: " . $row['order_out_id'] . ". Error message: " . $this->db->error() . "<br>";
			}
			
		} 
		else {
			// Print an error message
			return 3;
		}
	}

	function save_scrub_followup_csv_file(){
		// Get the file information
		$filename = $_FILES['file']['name'];
		$filetmp = $_FILES['file']['tmp_name'];

		// Check if the file is a CSV file
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if ($ext == 'csv') {
			// Delete the old records from the database
			$delete = $this->db->query("TRUNCATE TABLE  scrub_followup");
			// Delete the old CSV file if it exists
			if (file_exists($filename)) {
				unlink($filename);
			}

			// Move the uploaded file to the current directory
			move_uploaded_file($filetmp, $filename);

			// Open the file and read its contents
			$handle = fopen($filename, 'r');
			$header = NULL;
			$data = array();
			while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);

			// Insert the data into the database
			foreach ($data as $row) {
			
				
				$row['remarks_notes'] = str_replace('"', '', $row['remarks_notes']);
				$row['remarks_notes'] = str_replace("'", "", $row['remarks_notes']);
				$save = $this->db->query("INSERT  INTO scrub_followup (scrub_id,  remarks) 
				VALUES ('" . $row['scrub_id'] . "',  '" . $row['remarks'] . "')"
				);
				
			}
			if($save>0){
				return 1;
			}
			else{
				echo "Error executing query for row with loan no: " . $row['scrub_id'] . ". Error message: " . $this->db->error() . "<br>";
			}
			
		} 
		else {
			// Print an error message
			return 3;
		}
	}

	function save_branch(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			
		}
		
		$check = $this->db->query("SELECT * FROM branch where branch ='$branch' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO branch set $data");
		}else{
			$save = $this->db->query("UPDATE branch set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_mapping(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM mapping where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_tor(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM type_of_request where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_loan_number() {
		extract($_POST);
	
		// Get the loan_no_id associated with the scrub
		// $loan_no_query = $this->db->query("SELECT id FROM scrub WHERE loan_no_id = ".$id);
		// $scrub_id = $loan_no_query->fetch_assoc()['id'];
	
		// Delete the loan_no record
		$delete1 = $this->db->query("DELETE FROM loan_no WHERE id = ".$id);
	
		// Delete the scrub record
		$delete2 = $this->db->query("DELETE FROM scrub WHERE loan_no_id = ".$id);

		// Delete the borrower record
		$delete3 = $this->db->query("DELETE FROM borrower WHERE loan_no_id = ".$id);
	
		// Delete the scrub_followup record associated with the loan_no_id
		// $delete3 = $this->db->query("DELETE FROM scrub_followup WHERE scrub_id = ".$scrub_id['id']);
	
		// Get the order_outs_id associated with the loan_no_id
		// $order_outs_query = $this->db->query("SELECT id FROM order_outs WHERE scrub_id = ".$scrub_id['id']);
		// $order_outs_id = $order_outs_query->fetch_assoc()['id'];
	
		// Delete the order_outs record associated with the loan_no_id
		// $delete4 = $this->db->query("DELETE FROM order_outs WHERE scrub_id = ".$scrub_id['id']);
	
		// Delete the scrub_followup record associated with the order_outs_id
		// $delete5 = $this->db->query("DELETE FROM follow_up WHERE order_outs_id = ".$order_outs_id['id']);
	
		if ($delete1 ) {
			return 1;
		}
	}
	
	  
	function delete_order(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM order_outs where id = ".$id);
		$delete = $this->db->query("DELETE FROM follow_up where order_out_id = ".$id);
		if($delete)
			return 1;
	}
	function delete_loan(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM loan_file where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_scrub(){
		extract($_POST);
		$delete1 = $this->db->query("DELETE FROM scrub where id = ".$id);
		$delete2 = $this->db->query("DELETE FROM order_outs where scrub_id = ".$id);
		$delete3 = $this->db->query("DELETE FROM scrub_followup where scrub_id = ".$id);
		if($delete1 || $delete2 || $delete3)
			return 1;
	}
	function delete_scrub_followup(){
		extract($_POST);
		$delete1 = $this->db->query("DELETE FROM scrub_followup where id = ".$id);
		
		if($delete1 )
			return 1;
	}
	function delete_borrower(){
		extract($_POST);
		$delete1 = $this->db->query("DELETE FROM  borrower where id = ".$id);
		
		if($delete1 )
			return 1;
	}
	function delete_branch(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM branch where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_followup(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM follow_up where id = ".$id);
		if($delete)
			return 1;
	}
	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";

		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_project(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(isset($user_ids)){
			$data .= ", user_ids='".implode(',',$user_ids)."' ";
		}
		// echo $data;exit;
		if(empty($id)){
			$save = $this->db->query("INSERT INTO project_list set $data");
		}else{
			$save = $this->db->query("UPDATE project_list set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_project(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM project_list where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_task(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO task_list set $data");
		}else{
			$save = $this->db->query("UPDATE task_list set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function save_scrub_followup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'remarks')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$timestamp = date("Y-m-d H:i:s");
		$data .= ", followup_date='$timestamp' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO scrub_followup set $data");
		}else{
			$data .= ", updated_by='".$_SESSION['login_id']."' ";
			$save = $this->db->query("UPDATE scrub_followup set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	
	function delete_task(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_list where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_progress(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'comment')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$dur = abs(strtotime("2020-01-01 ".$end_time)) - abs(strtotime("2020-01-01 ".$start_time));
		$dur = $dur / (60 * 60);
		$data .= ", time_rendered='$dur' ";
		// echo "INSERT INTO user_productivity set $data"; exit;
		if(empty($id)){
			$data .= ", user_id={$_SESSION['login_id']} ";
			
			$save = $this->db->query("INSERT INTO user_productivity set $data");
		}else{
			$save = $this->db->query("UPDATE user_productivity set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_progress(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM user_productivity where id = $id");
		if($delete){
			return 1;
		}
	}
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");
		while($row= $get->fetch_assoc()){
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['name'] = ucwords($row['name']);
			$row['adult_price'] = number_format($row['adult_price'],2);
			$row['child_price'] = number_format($row['child_price'],2);
			$row['amount'] = number_format($row['amount'],2);
			$data[]=$row;
		}
		return json_encode($data);

	}
}
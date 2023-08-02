<?php
ob_start();
date_default_timezone_set("Asia/Karachi");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}

if($action == 'all_branch_users'){
	$save = $crud->all_branch_users();
	if($save)
		echo $save;
}
if($action == 'save_mapping'){
	$save = $crud->save_mapping();
	if($save)
		echo $save;
}
if($action == 'save_loan'){
	$save = $crud->save_loan();
	if($save)
		echo $save;
}
if($action == 'save_scrub_file'){
	$save = $crud->save_scrub_file();
	if($save)
		echo $save;
}
if($action == 'save_followup_csv_file'){
	$save = $crud->save_followup_csv_file();
	if($save)
		echo $save;
}
if($action == 'save_order_out_file'){
	$save = $crud->save_order_out_file();
	if($save)
		echo $save;
}
if($action == 'save_loan_no'){
	$save = $crud->save_loan_no();
	if($save)
		echo $save;
}
if($action == 'save_scrub'){
	$save = $crud->save_scrub();
	if($save)
		echo $save;
}
if($action == 'save_order'){
	$save = $crud->save_order();
	if($save)
		echo $save;
}
if($action == 'save_borrower'){
	$save = $crud->save_borrower();
	if($save)
		echo $save;
}
if($action == 'delete_loan_number'){
	$save = $crud->delete_loan_number();
	if($save)
		echo $save;
}
if($action == 'delete_borrower'){
	$save = $crud->delete_borrower();
	if($save)
		echo $save;
}
if($action == 'populate_branch_processor'){
	$save = $crud->populate_branch_processor();
	if($save)
		echo $save;
}
if($action == 'populate_branch_coordinator'){
	$save = $crud->populate_branch_coordinator();
	if($save)
		echo $save;
}
if($action == 'delete_scrub'){
	$save = $crud->delete_scrub();
	if($save)
		echo $save;
}
if($action == 'delete_mapping'){
	$save = $crud->delete_mapping();
	if($save)
		echo $save;
}
if($action == 'delete_order'){
	$save = $crud->delete_order();
	if($save)
		echo $save;
}
if($action == 'save_branch'){
	$save = $crud->save_branch();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'delete_loan'){
	$save = $crud->delete_loan();
	if($save)
		echo $save;
}
if($action == 'delete_branch'){
	$save = $crud->delete_branch();
	if($save)
		echo $save;
}
if($action == 'delete_followup'){
	$save = $crud->delete_followup();
	if($save)
		echo $save;
}
if($action == 'save_project'){
	$save = $crud->save_project();
	if($save)
		echo $save;
}
if($action == 'save_tor'){
	$save = $crud->save_tor();
	if($save)
		echo $save;
}
if($action == 'save_followup'){
	$save = $crud->save_followup();
	if($save)
		echo $save;
}
if($action == 'delete_project'){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}
if($action == 'delete_tor'){
	$save = $crud->delete_tor();
	if($save)
		echo $save;
}
if($action == 'delete_scrub_followup'){
	$save = $crud->delete_scrub_followup();
	if($save)
		echo $save;
}
if($action == 'save_task'){
	$save = $crud->save_task();
	if($save)
		echo $save;
}
if($action == 'save_scrub_followup'){
	$save = $crud->save_scrub_followup();
	if($save)
		echo $save;
}
if($action == 'show_loan_no_detail'){
	$save = $crud->show_loan_no_detail();
	if($save)
		echo $save;
}
if($action == 'save_loan_number_file'){
	$save = $crud->save_loan_number_file();
	if($save)
		echo $save;
}
if($action == 'save_borrower_file'){
	$save = $crud->save_borrower_file();
	if($save)
		echo $save;
}
if($action == 'save_over_due_interval'){
	$save = $crud->save_over_due_interval();
	if($save)
		echo $save;
}
if($action == 'save_scrub_followup_csv_file'){
	$save = $crud->save_scrub_followup_csv_file();
	if($save)
		echo $save;
}
if($action == 'start_scrub'){
	$save = $crud->start_scrub();
	if($save)
		echo $save;
}
if($action == 'end_scrub'){
	$save = $crud->end_scrub();
	if($save)
		echo $save;
}
if($action == 'start_order_outs'){
	$save = $crud->start_order_outs();
	if($save)
		echo $save;
}
if($action == 'end_order_outs'){
	$save = $crud->end_order_outs();
	if($save)
		echo $save;
}
if($action == 'update_scrub'){
	$save = $crud->update_scrub();
	if($save)
		echo $save;
}
if($action == 'update_order_outs'){
	$save = $crud->update_order_outs();
	if($save)
		echo $save;
}
if($action == 'delete_task'){
	$save = $crud->delete_task();
	if($save)
		echo $save;
}
if($action == 'save_progress'){
	$save = $crud->save_progress();
	if($save)
		echo $save;
}
if($action == 'delete_progress'){
	$save = $crud->delete_progress();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
ob_end_flush();
?>

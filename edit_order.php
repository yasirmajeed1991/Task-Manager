<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM order_outs where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'new_order_outs.php';
?>
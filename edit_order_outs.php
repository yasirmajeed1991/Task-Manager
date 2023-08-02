<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM order_outs where id = ".$_GET['rid'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'update_order_outs.php';
?>
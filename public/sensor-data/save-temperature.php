<?php
	require "../../api/Modal.php";
	$id = $_GET['id'];
	echo $t = $_GET['temperatura'];
	echo "\n";
	if($id && $t){
		$pg = new PostgreSQL();
		$sql = "UPDATE controle SET status = $1 WHERE codigo = $2";
		$pg->QueryOnly($sql, [$t, $id]);
	}
?>
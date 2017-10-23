<?php
	
	include "koneksi.php";

	$id = $_POST['id'];

	$query = mysql_query("SELECT * FROM users WHERE id='".$id."'");

	while ($row = mysql_fetch_array($query)){

		$char ='"';

		
		$json = '{
				"saldo": "'.str_replace($char,'`',strip_tags($row['saldo'])).'",
				"nama": "'.str_replace($char,'`',strip_tags($row['nama'])).'"}';
	}

	echo $json;

	
?>
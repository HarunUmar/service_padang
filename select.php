<?php 
	include "koneksi.php";
	$katagori = $_GET['id'];
	$query = mysql_query("SELECT * FROM menu where id_katagori=".$katagori."");
	
	
	
	

	$json = '[';
	
	while ($row = mysql_fetch_array($query)){
	
		$char ='"';
		$json .= '{
			"id": "'.str_replace($char,'`',strip_tags($row['id'])).'", 
			"nama": "'.str_replace($char,'`',strip_tags($row['nama'])).'",
			"harga": "'.str_replace($char,'`',strip_tags($row['harga'])).'",
			"status": "'.str_replace($char,'`',strip_tags($row['status'])).'",
			"id_katagori": "'.str_replace($char,'`',strip_tags($row['id_katagori'])).'", 			
			"image": "'.str_replace($char,'`',strip_tags($row['image'])).'"},';
	}
	
	$json = substr($json,0,strlen($json)-1);
	

	
	$json .= ']';
	
	
	echo $json;
	

	
?>
<?php
	include "koneksi.php";
	sleep(2);
	
	$offset = isset($_GET['offset']) && $_GET['offset'] != '' ? $_GET['offset'] : 0;
	$user = $_GET['user'];
	$all = mysql_query("SELECT DISTINCT menu.nama,pesanan.id, pesanan.tgl,pesanan.status, menu_pesanan.jumlah FROM menu JOIN menu_pesanan ON menu.id = menu_pesanan.id_menu Join pesanan ON menu_pesanan.id_pesanan = pesanan.id WHERE pesanan.id_users =".$user." ORDER BY pesanan.id DESC");
	
	//$all = mysql_query("SELECT * FROM pesanan ORDER BY id DESC");
	$count_all = mysql_num_rows($all);
	
	//$query = mysql_query("SELECT * FROM pesanan ORDER BY id DESC LIMIT $offset,10");
	$query = mysql_query("SELECT DISTINCT menu.nama,pesanan.id, pesanan.status, pesanan.tgl,menu_pesanan.jumlah FROM menu JOIN menu_pesanan ON menu.id = menu_pesanan.id_menu Join pesanan ON menu_pesanan.id_pesanan = pesanan.id WHERE pesanan.id_users =$user ORDER BY pesanan.id DESC LIMIT $offset,10");
	$count = mysql_num_rows($query);
	$json_kosong = 0;
	
	if($count<10){
		if($count==0){
			$json_kosong = 1;
		}else{
			//$query = mysql_query("SELECT * FROM pesanan ORDER BY id DESC LIMIT $offset,$count");
			$query = mysql_query("SELECT DISTINCT menu.nama,pesanan.id, pesanan.status,pesanan.tgl,menu_pesanan.jumlah FROM menu JOIN menu_pesanan ON menu.id = menu_pesanan.id_menu Join pesanan ON menu_pesanan.id_pesanan = pesanan.id WHERE pesanan.id_users =$user ORDER BY pesanan.id DESC LIMIT $offset,$count");
			
			$count = mysql_num_rows($query);
			if(empty($count)){
				//$query = mysql_query("SELECT * FROM pesanan ORDER BY id DESC LIMIT 0,10");
				$query = mysql_query("SELECT DISTINCT menu.nama,pesanan.status,pesanan.id,pesanan.tgl, menu_pesanan.jumlah FROM menu JOIN menu_pesanan ON menu.id = menu_pesanan.id_menu Join pesanan ON menu_pesanan.id_pesanan = pesanan.id WHERE pesanan.id_users =$user ORDER BY pesanan.id DESC LIMIT 0,10");
				$num = 0;
			}else{
				$num = $offset;
			}
		}
	} else{
		$num = $offset;
	}
	
	$json = '[';
	
	while ($row = mysql_fetch_array($query)){
		$num++;
		$char ='"';
		$json .= '{
			"no": '.$num.',
			"id": "'.str_replace($char,'`',strip_tags($row['id'])).'", 
			"status": "'.str_replace($char,'`',strip_tags($row['status'])).'", 
			"tgl": "'.str_replace($char,'`',strip_tags($row['tgl'])).'"},';
	}
	
	$json = substr($json,0,strlen($json)-1);
	
	
	if($json_kosong==1){
		$json = '[{ "no": "", "id": "", "tgl": "", "status":""}]';
	}else{
		$json .= ']';
	}
	echo $json;
	

?>
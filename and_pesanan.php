<?php
	include "koneksi.php";
	error_reporting(0);
	class emp{}
	
	$id_menu		= $_POST['id_menu'];
	$id_katagori	= $_POST['id_katagori'];
	$id_rm		 	= $_POST['id_rm'];
	$id_users	 	= $_POST['id_users'];
	$jumlah			= $_POST['jumlah'];
	$lat			= $_POST['lat'];
	$lang			= $_POST['lang'];
	$tgl  			= gmdate("Y-m-d", time() +60*60*8);
	$jam 			= $_POST['jam'];
	$ket			= $_POST['ket'];
	$bayar 			= $_POST['bayar'];
	
	$query_cek = mysql_query("SELECT * FROM users WHERE id='".$id_users."'");
		$row_cek = mysql_fetch_row($query_cek);
		
	
	if (empty($id_menu)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Terjadi kesalahan menu belum di sertakan"; 
		die(json_encode($response));
	} 
	
	else if (empty($id_rm)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "terjadi kesalahan Nama Rumah Makan tidak disertakan"; 
		die(json_encode($response));
	} 
	else if (empty($id_users)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "terjadi kesalahan pemesan belum ditentukan"; 
		die(json_encode($response));
	}
	else if (empty($jumlah)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "terjadi kesalahan jumlah pesanan ditentukan"; 
		die(json_encode($response));
	} 	
	
	
		
		
	else if($row_cek[6] <= 0){
		
		$response = new emp();
		$response->success = 0;
		$response->message = "saldo anda masih 0, silahkan isi saldo terlebih dahulu"; 
		die(json_encode($response));
		
	}
	
	else if($row_cek[6] < $bayar){
		
		$response = new emp();
		$response->success = 0;
		$response->message = "saldo anda tidak mencukupi untuk melakukan pemesanan"; 
		die(json_encode($response));
	}
	
	
	
	else {
		
		$ubah_saldo = ($row_cek[6] - $bayar);
		mysql_query("UPDATE users SET saldo = '".$ubah_saldo."' WHERE id='".$id_users."'");
		
		$terakhir  = mysql_query("SELECT * FROM pesanan WHERE id IN ( SELECT MAX(id) FROM pesanan )");
		$no = mysql_fetch_row($terakhir);
		$no_terakhir = $no[0] + 1;
		
		$query = mysql_query("INSERT INTO pesanan (id_rm,id_users,lat,lang,tgl,jam,ket) VALUES ('$id_rm','$id_users','$lat','$lang','$tgl','$jam','$ket')");
		
		//id_menu 
		$str1 = str_replace('[', '', $id_menu);
		$str2 = str_replace('  ', '', $str1);
		$str3 = (str_replace(']', '', $str2));
		$str4  = explode(",",$str3);
		
		//jumlah
		$str11 = str_replace('[', '', $jumlah);
		$str22 = str_replace('  ', '', $str11);
		$str33 = (str_replace(']', '', $str22));
		$str44  = explode(",",$str33);
		
		$diman = count($str44);
		foreach ($str4 as $value) {
	
	
		$query1= mysql_query("INSERT INTO menu_pesanan (id_pesanan,id_menu,jumlah) VALUES ('$no_terakhir','$value','0')");
			
			for($i =0; $i<$diman; $i++) {
				
				$query2 = mysql_query("UPDATE menu_pesanan SET jumlah = '$str44[$i]' WHERE menu_pesanan.id_pesanan = '$no_terakhir' and menu_pesanan.id_menu = '$value[$i]'");
					
			}
			
			
			}
		
		
		
		if ($query){
			
			$response = new emp();
			$response->success = 1;
			$response->message = "Menu berhasil Di pesan".;
			die(json_encode($response));
		} else{ 
			$response = new emp();
			$response->success = 0;
			$response->message = "gagal Memesan Menu";
			die(json_encode($response)); 
		}
	}	
	
	
?>	
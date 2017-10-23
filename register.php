<?php
	include "koneksi.php";
	
	class emp{}
	
	$id_rm		= $_POST['id_rm'];
	$nama		= $_POST['username'];
	$email	 	= $_POST['email'];
	$password 	= $_POST['password'];
	$no_hp		= $_POST['no_hp'];
	$saldo 		= "0";
	$confrim   = $_POST['confirm_password'];
	
	
		
	
	if (empty($id_rm)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Rumah Makan Belum Di tentukan"; 
		die(json_encode($response));
	} 
	
	else if (empty($nama)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Nama Masi kosong"; 
		die(json_encode($response));
	} 
	else if (empty($email)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "email masi kosong"; 
		die(json_encode($response));
	}
	else if (empty($password)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Password masi kosong"; 
		die(json_encode($response));
	}
	else if (empty($no_hp)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "nomor hp masi kosong"; 
		die(json_encode($response));
	}
	else if (empty($confrim)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Konfirmasi password anda"; 
		die(json_encode($response));
	}	
	
	
	else if ($password  !=  $confrim) {
		$response = new emp();
		$response->success = 0;
		$response->message = "password tidak sama"; 
		die(json_encode($response));
		
	}
	else  {
		
		
		$acak = "ADINDAKUS987654321GTRDFTR";
	
		$pass = md5($acak. md5($password) . $acak );

	$query= mysql_query("INSERT INTO users (id_rm,nama,email,pass,no_hp,saldo) VALUES ('$id_rm','$nama','$email','$pass','$no_hp','$saldo')");
			
		if ($query){
			
			$response = new emp();
			$response->success = 1;
			$response->message = "Pendaftaran Berhasil";
			die(json_encode($response));
		} else{ 
			$response = new emp();
			$response->success = 0;
			$response->message = "gagal Mendaftar";
			die(json_encode($response)); 
		}
	}	
	
	
?>	
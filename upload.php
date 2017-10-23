<?php
	include "koneksi.php";
	
	class emp{}
	
	$image 			= $_POST['image'];
	$id_katagori 	= $_POST['id_katagori'];
	$nama			= $_POST['nama'];
	$harga 			= $_POST['harga'];
	
	
	if (empty($image)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "Sertakan Foto Atau gambar Menu"; 
		die(json_encode($response));
	} 
	
	else if (empty($nama)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "nama makanan masi kososng"; 
		die(json_encode($response));
	} 
	
	else if (empty($id_katagori)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "katagori manu belum ditentukan"; 
		die(json_encode($response));
	}
	
	else if (empty($harga)) { 
		$response = new emp();
		$response->success = 0;
		$response->message = "harga Menu masi kosong"; 
		die(json_encode($response));
	}
	
	
	else {
		$random = random_word(20);
		
		$path = "images/".$random.".png";
		
		// sesuiakan ip address laptop/pc atau URL server
		$actualpath = "http://localhost/upload_image/$path";
		
		$query = mysql_query("INSERT INTO menu (id_katagori,nama,harga,image) VALUES ('$id_katagori','$nama','$harga','$actualpath')");
		
		if ($query){
			file_put_contents($path,base64_decode($image));
			
			$response = new emp();
			$response->success = 1;
			$response->message = "Successfully Uploaded";
			die(json_encode($response));
		} else{ 
			$response = new emp();
			$response->success = 0;
			$response->message = "Error Upload image";
			die(json_encode($response)); 
		}
	}	
	
	
	function random_word($id = 20){
		$pool = '1234567890abcdefghijkmnpqrstuvwxyz';
		
		$word = '';
		for ($i = 0; $i < $id; $i++){
			$word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $word; 
	}
	
?>	
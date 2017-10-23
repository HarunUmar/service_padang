<?php 

	include "koneksi.php";
	
	class emp{}
	$email	 	= $_POST['email'];
	$password 	= $_POST['password'];


$query = mysql_query("SELECT * FROM users WHERE email='".$email."'");
	
if($query) {
	
	$row = mysql_fetch_row($query);
	
	$acak = "ADINDAKUS987654321GTRDFTR";
		if (md5($acak . md5($password) . $acak) == $row[4])

			{
					$response = new emp();
					$response->id = $row[0];
					$response->id_rm = $row[1];
					$response->nama = $row[2];
					$response->email = $row[3];
					$response->success = 1;
					$response->message = "Selamat Datang ".$row[2].""; 
					die(json_encode($response));
			}
			
			else {

					$response = new emp();
					$response->success = 0;
					$response->message = "Login Gagal"; 
					die(json_encode($response));
			}
	}
else 

	{

		$response = new emp();
		$response->success = 0;
		$response->message = "Terjadi Kesalahan"; 
		die(json_encode($response));
}



		
	 	 	


?>
<?php
session_start();

	$username=htmlentities($_POST['username']);
	$password=htmlentities($_POST['password']);
	$nama_lengkap=htmlentities(ubah_huruf_awal(" ", $_POST['nama_lengkap']));
	$email=htmlentities($_POST['email']);
	$no_telp=htmlentities($_POST['no_hp']);
	$alamat=htmlentities($_POST['alamat']);
	$provinsi=htmlentities(ubah_huruf_awal(" ", $_POST['provinsi']));
	$kota=htmlentities(ubah_huruf_awal(" ", $_POST['kota']));
	$kode_pos=htmlentities($_POST['kode_pos']);
	$password_ulang=htmlentities($_POST['password_ulang']);
	$captcha=htmlentities($_POST['cap']);

if(isset($_POST['simpan'])){
	if($captcha==$_SESSION['captcha_session']){ // Check Captcha
		if($password==$password_ulang){ // Jika Password dan Ulang Password Sama Maka Lanjut
	
			$sql_user=mysql_query("select id_member from t_member where username='".$username."'"); // Check Duplikat Username
			$check_user=mysql_num_rows($sql_user);

			$sql_check_email=mysql_query("select id_member from t_member where email='".$email."'"); // Check Duplikat Password 
			$check_email=mysql_num_rows($sql_check_email);		
		
			if($check_email<1){ // Jika Email Sudah Dipakai Maka Gagal
				if($check_user<1){ // Jika Username Sudah Dipakai Maka Gagal
				
					$sql_simpan=mysql_query("insert into t_member (username,password,nama_lengkap,email,no_telp,alamat,provinsi,kota,kode_pos) VALUES ('".$username."','".md5($password.$salt_pass)."','".$nama_lengkap."','".$email."','".$no_telp."','".$alamat."','".$provinsi."','".$kota."',".$kode_pos.")") or die(mysql_error());
			
					if($sql_simpan){
						echo "<script>alert('Selamat Anda Telah Terdaftar!');window.location=('index.php?module=login');</script>";
					}else{
						echo "<script>alert('Maaf, Pendaftaran Gagal, Masukan Data Anda Dengan Benar!');window.location=('index.php?module=daftar');</script>";
					}
				}else{
					echo "<script>alert('Username Sudah Dipakai!');window.location=('index.php?module=daftar');</script>";
				}
			}else{
				echo "<script>alert('Email Sudah Dipakai!');window.location=('index.php?module=daftar');</script>";
			}
		}else{
			echo "<script>alert('Password Tidak Sama!');window.location=('index.php?module=daftar');</script>";
		}
}
}

?>

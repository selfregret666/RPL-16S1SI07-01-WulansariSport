<?php
session_start();

$username=htmlentities(trim($_POST['username']));
$password=md5(htmlentities(trim($_POST['password'].$salt_pass)));
$captcha=htmlentities($_POST['cap']);	

// AUTHENTICATION //
if(isset($_POST['login'])){
	if($captcha==$_SESSION['captcha_session']){
		$sql_login=mysql_query("select id_member,username from t_member where username='".$username."' and password='".$password."'");
		$row=mysql_fetch_assoc($sql_login);
		$login=mysql_num_rows($sql_login);
			if($login==1){
				$_SESSION['id_member']=$row['id_member'];
				$_SESSION['username']=$row['username'];
				echo "<script>alert('Login Berhasil! Selamat Berbelanja!');window.location=('index.php');</script>";
			}else{
				echo "<script>alert('Login Gagal! Silahkan Check Kembali Username dan Password!');</script>";
			}
	}else{
		echo "<script>alert('Captcha Salah!');</script>";
	}
	
}
?>


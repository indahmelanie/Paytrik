<?php 

require_once "koneksi.php";

if( isset($_SESSION['user']) ){
	header("Location: dashboard.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Login </title>  
	<meta name="viewport" content="width=device-width">                            
	<link rel="stylesheet" type="text/css" href="style.css">      
</head>
<body>
<div class="login bflex">
	<div class="llogin">
		<img src="image/login.png">
	</div>
	<div class="rlogin cflex">
		<form method="POST">
			<p class="error"></p>
			<img src="image/logo.png">
			<div class="winput">
				<input type="text" name="username" autocomplete="off" placeholder="Masukan username . . .">
			</div>
			<div class="winput" style="margin-top: 15px">
				<input type="password" name="password" autocomplete="off" placeholder="Masukan password . . .">
				
			<div class="winput" style="margin-top: 25px;">
				<button type="submit" name="btn-login" style="width: 100%;"> Login sekarang </button>
			</div>
			<p> Masuk dengan no pelanggan jika anda sebagai pelanggan. </p>
		</form>
	</div>
</div>
</body>
</html>
<?php 

if( isset($_POST['btn-login']) ){

	$username = mysqli_escape_string($connect, htmlspecialchars($_POST['username']));
	$password = mysqli_escape_string($connect, htmlspecialchars($_POST['password']));

	if( !empty(trim($username)) && !empty(trim($password)) ){

		$sql = mysqli_query($connect, "SELECT * FROM tblogin WHERE username='$username' AND password='$password'");

		if( mysqli_num_rows($sql) > 0 ){

			$data = mysqli_fetch_assoc($sql);

			$_SESSION['user'] = $username;
			$_SESSION['namaLengkap'] = $data['namaLengkap'];
			$_SESSION['level'] = $data['level'];

			header("Location: dashboard.php");

		} else {
			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Username atau password salah !';
			</script>";
		}

	} else{
		echo "<script>
			var error = document.getElementsByClassName('error')[0];
			error.style.display='block';
			error.innerHTML = 'Form masih ada yang kosong !';
		</script>";
	}

}

?>
<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Input Petugas </title>    
	<meta name="viewport" content="width=device-width">            
	<link rel="stylesheet" type="text/css" href="style.css">      
</head>
<body>
<div class="container bflex">
	<div class="head cflex">
		<a class="btn-menu">
			<div class="icon icon1"></div>
			<div class="icon icon2"></div>
			<div class="icon icon3"></div>
		</a>
	</div>
	<div class="lcontainer">
		<ul class="menu">
			<li class="title-menu"><a href="dashboard.php"><span> Dashboard </span></a></li>
			<?php if($_SESSION['level'] == 'Admin' ){ ?>
				<li class="title-menu"><a href="inputtarif.php"><span style="color: #16e4b4"> Input </span></a>
					<ul class="drop">
						<li><a href="inputtarif.php"> Tarif </a></li>
						<li><a href="inputpetugas.php" style="color: #16e4b4"> Petugas </a></li>
						<li><a href="inputpelanggan.php"> Pelanggan </a></li>
					</ul>
				</li>
				<li class="title-menu"><a href="tampiltarif.php"><span> Tampil </span></a>
					<ul class="drop">
						<li><a href="tampiltarif.php"> Tarif </a></li>
						<li><a href="tampilpetugas.php"> Petugas </a></li>
						<li><a href="tampilpelanggan.php"> Pelanggan </a></li>
					</ul>
				</li>
			<?php } ?>
			<li class="title-menu"><a href="inputtagihan.php"><span> Tagihan </span></a></li>
			<li class="title-menu"><a href="inputpembayaran.php"><span> Pembayaran </span></a></li>
			<li><a class="btn-logout"><span> Logout </span></a></li>
		</ul>
	</div>
	<div class="rcontainer">
		<div class="header bflex">
			<a href="dashboard.php">
				<img src="image/logo.png">
			</a>
			<div class="title-user">
				<span> <?php echo $_SESSION['level'] ?> </span>
			</div>
		</div>
		<div class="wrapper">
			<div class="logout">
				<div class="screen-logout"></div>
				<div class="delimiter">
					<div class="clogout">
						<img src="export/logout.png">
						<h1> Apakah anda ingin Logout ? </h1>
						<p> Tekan tombol logout untuk keluar dari halaman atau tekan tombol batalkan untuk membaltakannya. </p>
						<div class="cflex">
							<a href="logout.php" class="btn-hapus"> Logout </a>
							<a class="close-logout"> Batalkan </a>
						</div>
					</div>
				</div>
			</div>
			<div class="delimiter">
				<img src="export/rocket.png" class="gravity2">
				<div class="page">
					<div class="bflex move">
						<h1> Input Petugas </h1>
						<div class="cross cflex">
							<a href="tampilpetugas.php"> Tampil<font style="color: #18154f">_</font>Petugas </a>
							<p> Anda dapat melihat petugas <br/> tekan tombol disamping. </p>
						</div>
					</div>
					<ul>
						<li><a href="inputtarif.php"> Tarif </a></li>
						<li style="border-bottom: 2px solid #5388f3;"><a href="inputpetugas.php" style="color: #5388f3; font-weight: bold;"> Petugas </a></li>
						<li><a href="inputpelanggan.php"> Pelanggan </a></li>
					</ul>
				</div>
				<form method="POST">
					<p class="error"></p>
					<div class="winput bflex">
						<div class="cinput rmargin">
							<span> Username </span>
							<input type="text" name="username" placeholder="Masukan username . . .">
						</div>
						<div class="cinput">
							<span> Password </span>
							<input type="text" name="password" placeholder="Masukan password . . .">
						</div>
					</div>
					<div class="winput tmargin">
						<span> Nama Lengkap </span>
						<input type="text" name="namaLengkap" placeholder="Masukan nama lengkap . . .">
					</div>
					<div class="winput tmargin">
						<span> Level </span>
						<select name="level">
							<option value="Petugas"> Petugas </option>
							<option value="Admin"> Admin </option>
						</select>
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-input" style="left: 0px"> Input Petugas </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
<?php 

if( isset($_POST['btn-input']) ){

	$username = mysqli_escape_string($connect, htmlspecialchars($_POST['username']));
	$password = mysqli_escape_string($connect, htmlspecialchars($_POST['password']));
	$namaLengkap = mysqli_escape_string($connect, htmlspecialchars($_POST['namaLengkap']));
	$level = mysqli_escape_string($connect, htmlspecialchars($_POST['level']));

	if( !empty(trim($username)) && !empty(trim($password)) && !empty(trim($namaLengkap)) ){

		$sql = mysqli_query($connect, "SELECT * FROM tblogin WHERE username = '$username'");

		if( mysqli_num_rows($sql) > 0 ){

			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Username sudah digunakan !';
			</script>";

		} else {
				
			$sql = mysqli_query($connect, "INSERT INTO tblogin VALUES('', '$username', '$password', '$namaLengkap', '$level')");

			if( $sql ){
				header("Location: tampilpetugas.php");
			} else {
				echo "<script>
					var error = document.getElementsByClassName('error')[0];
					error.style.display='block';
					error.innerHTML = 'Error !';
				</script>";
			}

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
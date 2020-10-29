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
	<title> Paytrik - Input Pelanggan </title>
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
			<?php if( $_SESSION['level'] == 'Admin' ){ ?>
				<li class="title-menu"><a href="inputtarif.php"><span style="color: #16e4b4"> Input </span></a>
					<ul class="drop">
						<li><a href="inputtarif.php"> Tarif </a></li>
						<li><a href="inputpetugas.php"> Petugas </a></li>
						<li><a href="inputpelanggan.php" style="color: #16e4b4"> Pelanggan </a></li>
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
						<h1> Input Pelanggan </h1>
						<div class="cross cflex">
							<a href="tampilpelanggan.php"> Tampil<font style="color: #18154f">_</font>Pelanggan </a>
							<p> Anda dapat melihat pelanggan <br/> tekan tombol disamping. </p>
						</div>
					</div>
					<ul>
						<li><a href="inputtarif.php"> Tarif </a></li>
						<li><a href="inputpetugas.php"> Petugas </a></li>
						<li style="border-bottom: 2px solid #5388f3;"><a href="inputpelanggan.php" style="color: #5388f3; font-weight: bold;"> Pelanggan </a></li>
					</ul>
				</div>
				<form method="POST">
					<p class="error"></p>
					<div class="winput bflex">
						<div class="cinput rmargin">
							<span> No Pelanggan </span>
							<input type="text" name="noPelanggan" placeholder="Masukan no pelanggan . . .">
						</div>
						<div class="cinput">
							<span> No Meter </span>
							<input type="text" name="noMeter" placeholder="Masukan no meter . . .">
						</div>
					</div>
					<div class="winput tmargin">
						<span> Tarif </span>
						<select name="kodeTarif">
							<?php 
								$sql = mysqli_query($connect, "SELECT * FROM tbtarif");
								while( $data = mysqli_fetch_assoc($sql) ){
							?>
							<option value="<?php echo $data['kodeTarif'] ?>"> <?php echo $data['kodeTarif'] ?> ( Tarif/Kwh : <?php echo $data['tarifPerKwh'] ?> ) </option>
							<?php } ?>
						</select>
					</div>
					<div class="winput tmargin">
						<span> Nama Lengkap </span>
						<input type="text" name="namaLengkap" placeholder="Masukan nama lengkap . . .">
					</div>
					<div class="winput tmargin">
						<span> Telepon </span>
						<input type="text" name="telp" placeholder="Masukan telepon . . .">
					</div>
					<div class="winput tmargin">
						<span> Alamat </span>
						<textarea name="alamat" placeholder="Masukan alamat . . ."></textarea>
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-input" style="left: 0px"> Input Pelanggan </button>
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

	$noPelanggan = mysqli_escape_string($connect, htmlspecialchars($_POST['noPelanggan']));
	$noMeter = mysqli_escape_string($connect, htmlspecialchars($_POST['noMeter']));
	$kodeTarif = mysqli_escape_string($connect, htmlspecialchars($_POST['kodeTarif']));
	$namaLengkap = mysqli_escape_string($connect, htmlspecialchars($_POST['namaLengkap']));
	$telp = mysqli_escape_string($connect, htmlspecialchars($_POST['telp']));
	$alamat = mysqli_escape_string($connect, htmlspecialchars($_POST['alamat']));

	if( !empty(trim($noPelanggan)) && !empty(trim($noMeter)) && !empty(trim($namaLengkap)) && !empty(trim($telp)) && !empty(trim($alamat)) ){

		$sql = mysqli_query($connect, "SELECT * FROM tblogin WHERE username = '$noPelanggan'");

		if( mysqli_num_rows($sql) > 0 ){

			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Username sudah digunakan !';
			</script>";

		} else {
				
			$sql1 = mysqli_query($connect, "INSERT INTO tblogin VALUES('', '$noPelanggan', '$noPelanggan', '$namaLengkap', 'Pelanggan')");

			if( $sql1 ){
					
				$sql2 = mysqli_query($connect, "INSERT INTO tbpelanggan VALUES('', '$noPelanggan', 'PJYN$noMeter', '$kodeTarif', '$namaLengkap', '$telp', '$alamat')");

				if( $sql2 ){
					header("Location: tampilpelanggan.php");
				} else {
					echo "<script>
						var error = document.getElementsByClassName('error')[0];
						error.style.display='block';
						error.innerHTML = 'Error2 !';
					</script>";
				}

			} else {
				echo "<script>
					var error = document.getElementsByClassName('error')[0];
					error.style.display='block';
					error.innerHTML = 'Error1 !';
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
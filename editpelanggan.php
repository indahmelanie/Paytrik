<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodePelanggan = $_GET['kodepelanggan'];

$sql = mysqli_query($connect, "SELECT * FROM tbpelanggan WHERE noPelanggan ='$kodePelanggan'");

if( isset($kodePelanggan) ){
	if( mysqli_num_rows($sql) < 0 ){
		echo "<script>
			alert('Akun tidak ditemukan !');
			location.href = 'tampilpelanggan.php';
		</script>";	
	}
} else {
	header("Location: tampilpelanggan.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Edit Pelanggan </title>                                                                 
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
			<li class="title-menu"><a href="dashboard.php"><span style="color: #16e4b4"> Dashboard </span></a></li>
			<?php if( $_SESSION['level'] == 'Admin' ){ ?>
				<li class="title-menu"><a href="inputtarif.php"><span> Input </span></a>
					<ul class="drop">
						<li><a href="inputtarif.php"> Tarif </a></li>
						<li><a href="inputpetugas.php"> Petugas </a></li>
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
				<form method="POST">
					<p class="error"></p>
					<?php 
						if( mysqli_num_rows($sql) > 0 ){ 
							while( $row = mysqli_fetch_assoc($sql) ){
					?>
					<div class="winput bflex">
						<div class="cinput rmargin">
							<span> No Pelanggan </span>
							<input type="text" name="noPelanggan" placeholder="Masukan no pelanggan . . ." value="<?php echo $row['noPelanggan'] ?>" readonly>
						</div>
						<div class="cinput">
							<span> No Meter </span>
							<input type="text" name="noMeter" placeholder="Masukan no meter . . ." value="<?php echo $row['noMeter'] ?>" readonly>
						</div>
					</div>
					<div class="winput tmargin">
						<span> Tarif </span>
						<select name="kodeTarif">
							<?php 
								$sql1 = mysqli_query($connect, "SELECT * FROM tbtarif JOIN tbpelanggan USING(kodeTarif) WHERE kodeTarif = $row[kodeTarif]");
								$kodeTarif = null;
								if( $data = mysqli_fetch_assoc($sql1) ){
									$kodeTarif = $data['kodeTarif'];
							?>
							<option value="<?php echo $data['kodeTarif'] ?>"> <?php echo $data['daya'] ?> ( Tarif/Kwh : <?php echo $data['tarifPerKwh'] ?> ) </option>
							<?php 
								} 

								$sql2 = mysqli_query($connect, "SELECT * FROM tbtarif WHERE kodeTarif <> $kodeTarif");

								while( $data = mysqli_fetch_assoc($sql2) ){
							?>
							<option value="<?php echo $data['kodeTarif'] ?>"> <?php echo $data['daya'] ?> ( Tarif/Kwh : <?php echo $data['tarifPerKwh'] ?> ) </option>
							<?php } ?>
						</select>
					</div>
					<div class="winput tmargin">
						<span> Nama Lengkap </span>
						<input type="text" name="namaLengkap" placeholder="Masukan nama lengkap . . ." value="<?php echo $row['namaLengkap'] ?>">
					</div>
					<div class="winput tmargin">
						<span> Telepon </span>
						<input type="text" name="telp" placeholder="Masukan telepon . . ." value="<?php echo $row['telp'] ?>">
					</div>
					<div class="winput tmargin">
						<span> Alamat </span>
						<textarea name="alamat" placeholder="Masukan alamat . . ."><?php echo $row['alamat'] ?></textarea>
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-update" style="left: 0px"> Update Pelanggan </button>
					</div>
					<?php 
						}
					} else {
						echo "<script>
							var error = document.getElementsByClassName('error')[0];
							error.style.display='block';
							error.innerHTML = 'Akun tidak ditemukan !';
						</script>";
					} ?>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
<?php 

if( isset($_POST['btn-update']) ){

	$kodeTarif = mysqli_escape_string($connect, htmlspecialchars($_POST['kodeTarif']));
	$namaLengkap = mysqli_escape_string($connect, htmlspecialchars($_POST['namaLengkap']));
	$telp = mysqli_escape_string($connect, htmlspecialchars($_POST['telp']));
	$alamat = mysqli_escape_string($connect, htmlspecialchars($_POST['alamat']));

	if( !empty(trim($namaLengkap)) && !empty(trim($telp)) && !empty(trim($alamat)) ){
				
		$sql3 = mysqli_query($connect, "UPDATE tblogin SET namaLengkap = '$namaLengkap' WHERE username = '$kodePelanggan'");
 
		if( $sql3 ){
				
			$sql4 = mysqli_query($connect, "UPDATE tbpelanggan SET kodeTarif = '$kodeTarif', namaLengkap = '$namaLengkap', telp = '$telp', alamat = '$alamat' WHERE noPelanggan = '$kodePelanggan'");

			if( $sql4 ){
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

	} else{
		echo "<script>
			var error = document.getElementsByClassName('error')[0];
			error.style.display='block';
			error.innerHTML = 'Form masih ada yang kosong !';
		</script>";
	}

}

?>
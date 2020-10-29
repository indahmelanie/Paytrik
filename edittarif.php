<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodeTarif = $_GET['kodetarif'];

$sql = mysqli_query($connect, "SELECT * FROM tbtarif WHERE kodeTarif = '$kodeTarif'");

if( isset($kodeTarif) ){
	if( mysqli_num_rows($sql) < 0 ){
		echo "<script>
			alert('Tarif tidak ditemukan !');
			location.href = 'tampiltarif.php';
		</script>";	
	}
} else {
	header("Location: tampiltarif.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Edit Tarif </title>    
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
							<span> Daya </span>
							<input type="text" name="daya" placeholder="Masukan daya . . ." value="<?php echo $row['daya'] ?>" readonly>
						</div>
						<div class="cinput">
							<span> Tarif / Kwh </span>
							<input type="text" name="tarifPerKwh" placeholder="Masukan tarif / kwh . . ." value="<?php echo $row['tarifPerKwh'] ?>">
						</div>
					</div>
					<div class="winput tmargin">
						<span> Beban </span>
						<input type="text" name="beban" placeholder="Masukan beban . . ." value="<?php echo $row['beban'] ?>">
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-update" style="left: 0px"> Update Tarif </button>
					</div>
					<?php 
						}
					} else {
						echo "<script>
							var error = document.getElementsByClassName('error')[0];
							error.style.display='block';
							error.innerHTML = 'Tarif tidak ditemukan !';
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

	$tarifPerKwh = mysqli_escape_string($connect, htmlspecialchars($_POST['tarifPerKwh']));
	$beban = mysqli_escape_string($connect, htmlspecialchars($_POST['beban']));

	if( !empty(trim($tarifPerKwh)) && !empty(trim($beban)) ){
		
		$sql = mysqli_query($connect, "UPDATE tbtarif SET tarifPerKwh = '$tarifPerKwh', beban = '$beban' WHERE kodeTarif = '$kodeTarif'");

		if( $sql ){
			header("Location: tampiltarif.php");
		} else {
			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Error !';
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
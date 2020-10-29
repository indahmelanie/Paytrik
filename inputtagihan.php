<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Cari Tagihan </title>                                        
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
			<li class="title-menu"><a href="inputtagihan.php"><span style="color: #16e4b4"> Tagihan </span></a></li>
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
		<div class="wrapper" style="padding-bottom: 0px">
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
				<h1 style="margin-top: 35px"> Cari Tagihan </h1>
				<p class="error"></p>
				<form method="GET" action="daftartagihan.php?nopelanggan=<?php echo $_GET['nopelanggan'] ?>" style="margin-top: 25px">
					<div class="winput bflex tag">
						<span> No<font style="color: #fff">_</font>Pelanggan </span>
						<?php if( $_SESSION['level'] != "Pelanggan" ){ ?>
							<input type="text" name="nopelanggan" placeholder="Masukan no pelanggan . . ." style="border-right: 0px; border-radius: 3px 0px 0px 3px; margin: 0px 0px 0px 15px">
						<?php } else { ?>
							<input type="text" name="nopelanggan" placeholder="Masukan no pelanggan . . ." value="<?php echo $_SESSION['user'] ?>" readonly style="border-right: 0px; border-radius: 3px 0px 0px 3px; margin: 0px 0px 0px 15px">
						<?php }?>
						<button type="submit" style="border-radius: 0px 3px 3px 0px"> Telusuri </button>
					</div>
				</form>
				<div class="pay">
					<img src="export/tagihan.png">
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

$noPelanggan = $_GET['nopelanggan'];
$kodeTagihan = $_GET['kodetagihan'];
$status = $_GET['status'];

$user = mysqli_query($connect, "SELECT * FROM tbpelanggan WHERE noPelanggan = '$noPelanggan'");

if( isset($noPelanggan) && isset($kodeTagihan) && isset($status) ){
	if( mysqli_num_rows($user) > 0 ){
		$data = mysqli_fetch_assoc($user);
	} else {
		echo "<script>
			alert('Akun tidak ditemukan !');
			location.href = 'inputtagihan.php';
		</script>";
	}
} else {
	header("Location: inputtagihan.php");
}

$sql = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE kodeTagihan = '$kodeTagihan'");

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Cetak Nota </title>                                                                 
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
		<?php if( $status == "Belum" || $status == "Proses" ){ ?>
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
				<p class="error"></p>
				<?php if($status == "Belum"){ ?>
					<h1 style="margin-top: 35px"> Cetak Nota Paytrik Belum Lunas </h1>
				<?php } else { ?>
					<h1 style="margin-top: 35px"> Cetak Nota Paytrik Masih Proses </h1>
				<?php } ?>
				<div class="user bflex">
					<span> Nama : <?php echo $data['namaLengkap'] ?> </span>
					<p> No Meter : <?php echo $data['noMeter'] ?> </p>
				</div>
				<?php if( mysqli_num_rows($sql) > 0 ){ $i = 1; ?>
				<table class="tmargin">
					<tr>
						<td><span> No Tagihan </span></td>
						<td><span> No Pelanggan </span></td>
						<td><span> Bulan </span></td>
						<td><span> Tahun </span></td>
						<td><span> Pemakaian </span></td>
						<td><span> Total Bayar </span></td>
						<td><span> Status </span></td>
					</tr>
					<?php while( $row = mysqli_fetch_assoc($sql) ){ ?>
					<tr>  
						<td><p class="number" style="width: auto; font-weight: bold;"> <?php echo $row['noTagihan'] ?> </p></td>
						<td><p> <?php echo $row['noPelanggan'] ?> </p></td>
						<td><p> <?php echo $row['bulanTagih'] ?> </p></td>
						<td><p> <?php echo $row['tahunTagih'] ?> </p></td>
						<td><p> <?php echo $row['totalBayar'] ?> </p></td>
						<td><p> <?php echo $row['jumlahPemakaian'] ?> </p></td>
						<td><p> <?php echo $row['status'] ?> </p></td>
					</tr>
					<?php } ?>
				</table>
				<?php } else {
					echo "<script>
							var error = document.getElementsByClassName('error')[0];
							error.style.display='block';
							error.innerHTML = 'Data nota masih kosong !';
						</script>";
				} ?>
				<?php if($status == "Belum"){ ?>
					<p style="margin: 25px 0px; line-height: 23px;"> Anda dapat melakukan transaksi pembayaran melalui form pembayaran pada menu pembayaran, dan mencantumkan bukti pembayaran berupa transfer bank. </p>
				<?php } else { ?>
					<p style="margin: 25px 0px; line-height: 23px;"> Pembayaran anda masih diproses. Masih menunggu konfirmasi dari admin. . . </p>
				<?php } ?>
				<a href="javascript:;" class="btn-edit" onclick="window.print()"> Print </a>
			</div>
		</div>
		<?php } else { ?>
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
				<p class="error"></p>
				<h1 style="margin-top: 35px"> Cetak Nota Paytrik Lunas </h1>
				<div class="user bflex">
					<span> Nama : <?php echo $data['namaLengkap'] ?> </span>
					<p> No Meter : <?php echo $data['noMeter'] ?> </p>
				</div>
				<?php if( mysqli_num_rows($sql) > 0 ){ $i = 1; ?>
				<table class="tmargin">
					<tr>
						<td><span> No Tagihan </span></td>
						<td><span> No Pelanggan </span></td>
						<td><span> Bulan </span></td>
						<td><span> Tahun </span></td>
						<td><span> Pemakaian </span></td>
						<td><span> Total Bayar </span></td>
						<td><span> Status </span></td>
					</tr>
					<?php while( $row = mysqli_fetch_assoc($sql) ){ ?>
					<tr>  
						<td><p class="number" style="width: auto; font-weight: bold"> <?php echo $row['noTagihan'] ?> </p></td>
						<td><p> <?php echo $row['noPelanggan'] ?> </p></td>
						<td><p> <?php echo $row['bulanTagih'] ?> </p></td>
						<td><p> <?php echo $row['tahunTagih'] ?> </p></td>
						<td><p> <?php echo $row['totalBayar'] ?> </p></td>
						<td><p> <?php echo $row['jumlahPemakaian'] ?> </p></td>
						<td><p> <?php echo $row['status'] ?> </p></td>
					</tr>
					<?php } ?>
				</table>
				<?php } else {
					echo "<script>
							var error = document.getElementsByClassName('error')[0];
							error.style.display='block';
							error.innerHTML = 'Data nota masih kosong !';
						</script>";
				} ?>
				<p style="margin: 25px 0px; line-height: 23px;"> Nota pembayaran anda sudah Lunas, terimakasih sudah bertransaksi di paytrik . . . </p>
				<a href="javascript:;" class="btn-edit" onclick="window.print()"> Print </a>
			</div>
		</div>
		<?php } ?>
	</div>
	<script type="text/javascript" src="script.js"></script>
</div>
</body>
</html>

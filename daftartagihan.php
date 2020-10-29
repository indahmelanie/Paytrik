<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

$noPelanggan = $_GET['nopelanggan'];

$user = mysqli_query($connect, "SELECT * FROM tbpelanggan WHERE noPelanggan = '$noPelanggan'");

if( isset($noPelanggan) ){
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

$sql = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE noPelanggan = '$noPelanggan'");

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Daftar Tagihan </title>                                                                 
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
			<li><a class="btn-logout" "><span> Logout </span></a></li>
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
				<h1 style="margin-top: 35px"> Daftar Tagihan </h1>
				<div class="user bflex">
					<span> Nama : <?php echo $data['namaLengkap'] ?> </span>
					<p> No Meter : <?php echo $data['noMeter'] ?> </p>
				</div>
				<p class="error ctext"></p>
				<?php if( mysqli_num_rows($sql) > 0 ){ $i = 1; ?>
					<div class="max">
						<table class="tmargin">
							<tr>
								<td><span> No </span></td>
								<td><span> Bulan </span></td>
								<td><span> Tahun </span></td>
								<td><span> Pemakaian </span></td>
								<?php if( $_SESSION['level'] == "Pelanggan" ){ ?>
									<td><span> Total<font style="color: #fff">_</font>Bayar </span></td>
								<?php } ?>
								<td><span> Status </span></td>
								<td><span> Aksi </span></td>
							</tr>
							<?php while( $row = mysqli_fetch_assoc($sql) ){ ?>
							<tr>  
								<td><p class="number"> <?php echo $i++ ?> </p></td>
								<td><p> <?php echo $row['bulanTagih'] ?> </p></td>
								<td><p> <?php echo $row['tahunTagih'] ?> </p></td>
								<td><p> Rp. <?php echo $row['jumlahPemakaian'] ?> </p></td>
								<?php if( $_SESSION['level'] == "Pelanggan" ){ ?>
								<td><p> Rp. <?php echo $row['totalBayar'] ?> </p></td>
								<?php } ?>
								<td><p> <?php echo $row['status'] ?> </p></td>
								<td>
									<div class="cflex">
										<a href="cetaknota.php?nopelanggan=<?php echo $row['noPelanggan'] ?>&kodetagihan=<?php echo $row['kodeTagihan'] ?>&status=<?php echo $row['status'] ?>" class="btn-detail"> Cetak </a>
										<a href="detailpembayaran.php?nopelanggan=<?php echo $row['noPelanggan'] ?>&kodetagihan=<?php echo $row['kodeTagihan'] ?>" class="btn-edit"> Detail </a>
										<a href="hapustagihan.php?nopelanggan=<?php echo $row['noPelanggan'] ?>&kodetagihan=<?php echo $row['kodeTagihan'] ?>" class="btn-hapus"> Hapus </a>
									</div>
								</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				<?php } else {
					echo "<script>
							var error = document.getElementsByClassName('error')[0];
							error.style.display='block';
							error.innerHTML = 'Data tagihan masih kosong !';
						</script>";
				} ?>
				<?php if( $_SESSION['level'] != "Pelanggan" ){ ?>
				<h1 style="margin-top: 50px; margin-bottom: 25px"> Input Tagihan </h1>
				<form method="POST">
					<div class="winput bflex">
						<div class="cinput">
							<span> Bulan </span>
							<select name="bulanTagih">
								<option value="Januari">Januari</option>
								<option value="Februari">Februari</option>
								<option value="Maret">Maret</option>
								<option value="April">April</option>
								<option value="Mei">Mei</option>
								<option value="Juni">Juni</option>
								<option value="Juli">Juli</option>
								<option value="Agustus">Agustus</option>
								<option value="September">September</option>
								<option value="Oktober">Oktober</option>
								<option value="November">November</option>
								<option value="Desember">Desember</option>
							</select>
						</div>
						<div class="cinput lmargin">
							<span> Tahun </span>
							<select name="tahunTagih">
							<?php for( $i=2019; $i>=2000; $i-- ){ ?>
								<option value="<?php echo $i ?>"> <?php echo $i ?> </option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="winput tmargin">
						<span> Jumlah Pemakaian </span>
						<input type="text" name="jumlahPemakaian" placeholder="Masukan jumlah pemakaian . . .">
					</div>
					<div class="wiput tmargin">
						<button type="submit" name="btn-input" style="left: 0px"> Input Tagihan </button>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script> 
</body>
</html>
<?php 

if( isset($_POST['btn-input']) ){

	$bulanTagih = mysqli_escape_string($connect, htmlspecialchars($_POST['bulanTagih']));
	$tahunTagih = mysqli_escape_string($connect, htmlspecialchars($_POST['tahunTagih']));
	$jumlahPemakaian = mysqli_escape_string($connect, htmlspecialchars($_POST['jumlahPemakaian']));
	$status = "Belum";

	if( !empty(trim($jumlahPemakaian)) ){

		function buatNoTagihan(){
			global $connect;
			$acak = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
			$noTagihan = substr(str_shuffle($acak), 0, 6);

			return $noTagihan;
		}
		$noTagihan = buatNoTagihan();

		function cariKodeTarif($noPelanggan){
			global $connect;
			$sql = mysqli_query($connect, "SELECT kodeTarif FROM tbpelanggan WHERE noPelanggan = '$noPelanggan'");
			if( mysqli_num_rows($sql) > 0 ){
				$data = mysqli_fetch_assoc($sql);
				$kodeTarif = $data['kodeTarif'];
			} else {
				$kodeTarif = "";
			}

			return $kodeTarif;
		}
		$kodeTarif = cariKodeTarif($noPelanggan);

		function totalBayar($jumlahPemakaian, $kodeTarif){
			global $connect;
			$sql = mysqli_query($connect, "SELECT * FROM tbtarif WHERE kodeTarif = '$kodeTarif'");
			if( mysqli_num_rows($sql) > 0 ){
				$data = mysqli_fetch_assoc($sql);

				$tarifPerKwh = $data['tarifPerKwh'];
				$beban = $data['beban'];

				$totalBayar = ($jumlahPemakaian * $tarifPerKwh) + $beban;
			} else {
				$totalBayar = 0;
			}

			return $totalBayar;
		}
		$totalBayar = totalBayar($jumlahPemakaian, $kodeTarif);
				
		$check = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE noPelanggan = '$noPelanggan' AND bulanTagih = '$bulanTagih' AND tahunTagih = '$tahunTagih'");

		if( mysqli_num_rows($check) > 0 ){
			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Bulan dan tahun tagihan sudah digunakan !';
			</script>";
		} else {
			$sql = mysqli_query($connect, "INSERT INTO tbtagihan VALUES('', '$noTagihan', '$noPelanggan', '$tahunTagih', '$bulanTagih', '$jumlahPemakaian', '$totalBayar', '$status')");

			if( $sql ){
				echo "<script>
					location.href='daftartagihan.php?nopelanggan=$noPelanggan';
				</script>";
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
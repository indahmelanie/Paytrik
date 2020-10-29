<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

$noPelanggan = $_GET['nopelanggan'];
$kodeTagihan = $_GET['kodetagihan'];

$user = mysqli_query($connect, "SELECT * FROM tbpelanggan WHERE noPelanggan = '$noPelanggan'");

$sql = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE kodeTagihan = '$kodeTagihan'");

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Detail Pembayaran </title>                                                                 
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
				<h1 style="margin: 35px 0px 50px"> Detail Pembayaran </h1>
				<p class="error"></p>
				<div class="wdetail bflex" style="justify-content: stretch; align-items: stretch;">
					<div class="ldetail">
						<span> Bukti Pembayaran : </span>
						<?php 
							$sql1 = mysqli_query($connect, "SELECT * FROM tbpembayaran WHERE kodeTagihan = '$kodeTagihan'");
							if( mysqli_num_rows($sql1) > 0 ){
								$data = mysqli_fetch_assoc($sql1);
						?>
						<img src="buktiPembayaran/<?php echo $data['buktiPembayaran'] ?>" style="height: auto; width: 100%;">
						<p class="ctext" style="font-weight: bold; margin-top: 15px"> <?php echo $data['buktiPembayaran']; ?> </p>
						<?php } else { ?>
						<img src="export/lost.png" style="height: auto; width: 100%;">
						<p class="ctext" style="font-weight: bold"> Belum ada bukti pembayaran </p>
						<?php } ?>
					</div>
					<div class="rdetail">
						<?php if( mysqli_num_rows($sql) > 0 ){ $i = 1; ?>
						<div class="max">
							<table style="margin: 0px">
								<tr>
									<td><span> No<font style="color: #fff">_</font>Tagihan </span></td>
									<td><span> Bulan </span></td>
									<td><span> Tahun </span></td>
									<td><span> Pemakaian </span></td>
									<td><span> Bayar </span></td>
									<td><span> Status </span></td>
								</tr>
								<?php if( $row = mysqli_fetch_assoc($sql) ){ ?>
								<tr>  
									<td><p class="number" style="width: auto; font-weight: bold;"> <?php echo $row['noTagihan'] ?> </p></td>
									<td><p> <?php echo $row['bulanTagih'] ?> </p></td>
									<td><p> <?php echo $row['tahunTagih'] ?> </p></td>
									<td><p> <?php echo $row['totalBayar'] ?> </p></td>
									<td><p> <?php echo $row['jumlahPemakaian'] ?> </p></td>
									<td><p> <?php echo $row['status'] ?> </p></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<?php } else {
							echo "<script>
									var error = document.getElementsByClassName('error')[0];
									error.style.display='block';
									error.innerHTML = 'Data detail kosong !';
								</script>";
						} ?>
						<?php if( $_SESSION['level'] != "Pelanggan" ){ ?>
						<form method="POST" style="margin-top: 25px">
							<div class="winput">
								<span> Rubah Status </span>
								<div class="cinput bflex" style="margin-top: 15px">
									<select name="status" style="margin: 0px; border-radius: 3px 0px 0px 3px; border-right: 0px">
										<option value=""> Pilih status </option>
										<option value="Lunas"> Lunas </option>
										<option value="Proses"> Proses </option>
										<option value="Belum"> Belum </option>
									</select>
									<button type="submit" name="btn-bayar" style="border-radius: 0px 3px 3px 0px;border-color: #ECf1f6; border-left: 0px;"> Update </button>
								</div>
							</div>
							<?php if( $row['status'] != 'Lunas' ){ ?>
							<div class="winput tmargin">
								<button type="submit" name="btn-remove" class="btn-hapus" style="margin: 0px; left: 0px"> Hapus Pembayaran </button>
							</div>
							<?php } ?>
						</form>
						<?php } else { 
							if( $row['status'] == 'Lunas' ){
							?>
								<div class="user-detail">
									<span> Informasi : </span>
									<p> Terimakasih sudah menggunakan jasa paytrik dalam melakukan proses transaksi pembayaran online pulsa listrik. </p>
								</div>
							<?php
								} else if( $row['status'] == 'Proses' ){
							?>
								<div class="user-detail">
									<span> Informasi : </span>
									<p> Status pembayaran anda saat ini yaitu Proses, dan sedang menunggu proses transaksi anda dari admin. </p>
								</div>
							<?php 
								} else {
							?>
								<div class="user-detail">
									<span> Informasi : </span>
									<p> Mohon maaf anda harus segera membayar tagihan listrik, pembayaran dapat dilakukan dengan masuk kehalaman Pembayaran. </p>
								</div>
							<?php	
								}
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
<?php 

if( isset($_POST['btn-bayar']) ){

	$status = $_POST['status'];

	if( $status == "" ){
		echo "<script>
			var error = document.getElementsByClassName('error')[0];
			error.style.display='block';
			error.innerHTML = 'Form rubah status masih kosong !';
		</script>";
	} else {
		$sql3 = mysqli_query($connect, "UPDATE tbpembayaran SET status = '$status' WHERE kodeTagihan = '$kodeTagihan'");

		if( $sql3 ){
			$sql4 = mysqli_query($connect, "UPDATE tbtagihan SET status = '$status' WHERE kodeTagihan = '$kodeTagihan'");
			if( $sql4 ){
				echo "<script>
					location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
				</script>";
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

}

if( isset($_POST['btn-remove']) ){

	$status = "Belum";

	$sql = mysqli_query($connect, "DELETE FROM tbpembayaran WHERE kodeTagihan = '$kodeTagihan'");

	if( $sql ){
		$sql1 = mysqli_query($connect, "UPDATE tbtagihan SET status = '$status' WHERE kodeTagihan = '$kodeTagihan'");

		if( $sql1 ){
			echo "<script> location.href = 'daftartagihan.php?nopelanggan=$noPelanggan' </script>";
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

?>

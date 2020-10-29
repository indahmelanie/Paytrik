<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$perPage 	= 5;
$page 		= isset($_GET['pages']) ? (int)$_GET['pages'] : 1;
$start 		= ($page > 1) ? ( $page * $perPage ) - $perPage : 0;

$sql 		= mysqli_query($connect, "SELECT * FROM tbtarif LIMIT $start, $perPage");

$result 	= mysqli_query($connect, "SELECT * FROM tbtarif");
$total		= mysqli_num_rows($result);

$pages 		= ceil($total/$perPage);


?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Tampil Tarif </title>    
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
				<li class="title-menu"><a href="tampiltarif.php"><span style="color: #16e4b4"> Tampil </span></a>
					<ul class="drop">
						<li><a href="tampiltarif.php" style="color: #16e4b4"> Tarif </a></li>
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
				<img src="export/satelit.png" class="gravity1">
				<div class="page">
					<div class="bflex move">
						<h1> Tampil Tarif </h1>
						<div class="cross cflex">
							<a href="inputtarif.php"> Input<font style="color: #18154f">_</font>Tarif </a>
							<p> Anda dapat menambah tarif <br/> tekan tombol disamping. </p>
						</div>
					</div>
					<ul>
						<li style="border-bottom: 2px solid #5388f3;"><a href="tampiltarif.php" style="color: #5388f3; font-weight: bold;"> Tarif </a></li>
						<li><a href="tampilpetugas.php"> Petugas </a></li>
						<li><a href="tampilpelanggan.php"> Pelanggan </a></li>
					</ul>
				</div>
				<p class="error"></p>
				<?php if( mysqli_num_rows($result) > 0 ){ ?>
				<form method="GET">
					<div class="winput bflex">
						<input type="text" name="pencarian/tarif" placeholder="Cari data tarif disini . . ." style="margin-top: 0px; border-right: 0px; border-radius: 3px 0px 0px 3px">
						<button type="submit" style="margin-top: 0px; border-radius: 0px 3px 3px 0px"> Telusuri </button>
					</div>
				</form>
				<div class="max">
					<table>
						<tr>
							<td><span> No </span></td>
							<td><span> Daya </span></td>
							<td><span> Tarif / Kwh </span></td>
							<td><span> Beban </span></td>
							<td><span> Aksi </span></td>
						</tr>
						<?php 

							if( isset($_GET['pencarian/tarif']) ){

								$pencarian = $_GET['pencarian/tarif'];

								if( $pencarian == "" ){
									$sql = mysqli_query($connect, "SELECT * FROM tbtarif LIMIT $start, $perPage");
								} else {
									$sql = mysqli_query($connect, "SELECT * FROM tbtarif WHERE daya LIKE '%$pencarian%' OR tarifPerKwh LIKE '%pencarian%' OR beban LIKE '%$pencarian%'");
								}

							} else {
								$sql = mysqli_query($connect, "SELECT * FROM tbtarif LIMIT $start, $perPage");
							}

							if( mysqli_num_rows($sql) > 0 ){
								while( $row = mysqli_fetch_assoc($sql) ){

						?>
						<tr>
							<td><p class="number"> <?php echo $start+=1; ?> </p></td>
							<td><p> <?php echo $row['daya'] ?> </p></td>
							<td><p> <?php echo $row['tarifPerKwh'] ?> </p></td>
							<td><p> <?php echo $row['beban'] ?> </p></td>
							<td> 
								<div class="cflex">
									<a href="edittarif.php?kodetarif=<?php echo $row['kodeTarif'] ?>" class="btn-edit"> Edit </a>
									<a href="hapustarif.php?kodetarif=<?php echo $row['kodeTarif'] ?>" class="btn-hapus"> Hapus </a>
								</div>
							</td>
						</tr>
						<?php
								} 
							} else {
							echo "<script>
								var error = document.getElementsByClassName('error')[0];
								error.style.display='block';
								error.innerHTML = 'Data tarif tidak ditemukan !';
							</script>";
						} ?>
					</table>
					<div class="pagination">
						<ul>
							<?php for( $c = 1; $c <= $pages; $c++ ){ ?>
								<li><a href="?pages=<?php echo $c ?>"> <?php echo $c ?> </a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php } else {
					echo "<script>
						var error = document.getElementsByClassName('error')[0];
						error.style.display='block';
						error.innerHTML = 'Data tarif masih kosong !';
					</script>";
				} ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
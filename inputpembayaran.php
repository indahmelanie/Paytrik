<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Input Pembayaran </title>    
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
			<li class="title-menu"><a href="inputtagihan.php"><span> Tagihan </span></a></li>
			<li class="title-menu"><a href="inputpembayaran.php"><span style="color: #16e4b4"> Pembayaran </span></a></li>
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
				<form method="POST" enctype="multipart/form-data">
					<div class="sflex move" style="margin-top: 25px">
						<h1> Pembayaran </h1>
						<div class="cross cflex pays" style="display: flex; align-items: center; padding: 10px 15px">
							<img src="export/correct.png">
							<p style="margin: 0px 0px 0px 15px"> Lakukan proses pembayaran dengan lengkap <br/> dalam menginput form pembayaran. </p>
						</div>
					</div>
					<p class="error"></p>
					<div class="winput bflex" style="margin-top: 50px">
						<div class="cinput rmargin">
							<span> No Tagihan </span>
							<select name="kodeTagihan">
								<?php 
									if( $_SESSION['level'] != 'Pelanggan' ){
										$sql = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE status = 'Belum'");
										if( mysqli_num_rows($sql) > 0 ){
											while( $data = mysqli_fetch_assoc($sql) ){
								?>
									<option value="<?php echo $data['kodeTagihan'] ?>"> <?php echo $data['noTagihan'] ?> ( No Pelanggan : <?php echo $data['noPelanggan'] ?> ) </option>
								<?php 
											}
										} else { 
								?>
									<option value="" disabled> Tagihan Kosong </option>
								<?php 
										}
									} else {
										$sqls = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE status = 'Belum' AND noPelanggan = $_SESSION[user]");
										if( mysqli_num_rows($sqls) > 0 ){
											while( $datas = mysqli_fetch_assoc($sqls) ){
								?>
								<option value="<?php echo $datas['kodeTagihan'] ?>"> <?php echo $datas['noTagihan'] ?> </option>
								<?php
											}
										} else { 
								?>
										<option value="" disabled> Tagihan anda Kosong </option>
								<?php
										} 
									}
								?>
							</select>
						</div>
						<div class="cinput">
							<span> Tanggal </span>
							<input type="date" name="tglBayar">
						</div>
					</div>
					<div class="winput tmargin">
						<span> Jumlah Tagihan </span>
						<input type="text" name="jumlahTagihan" placeholder="Masukan jumlah tagihan . . .">
					</div>
					<div class="winput tmargin sflex">
						<span> Bukti Pembayaran </span>
						<input type="file" name="buktiPembayaran" style="border: none; margin: 0px 0px 0px 15px; height: 30px; width: auto; padding: 0px">
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-input" style="left: 0px"> Bayar Tagihan </button>
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

	$kodeTagihan = mysqli_escape_string($connect, htmlspecialchars($_POST['kodeTagihan']));
	$tglBayar = mysqli_escape_string($connect, htmlspecialchars($_POST['tglBayar']));
	$jumlahTagihan = mysqli_escape_string($connect, htmlspecialchars($_POST['jumlahTagihan']));
	$buktiPembayaran = $_FILES['buktiPembayaran'];

	$filename = $buktiPembayaran['name'];
	$tmp_name = $buktiPembayaran['tmp_name'];
	$size 	  = $buktiPembayaran['size'];
	$type 	  = $buktiPembayaran['type'];

	$status = "Proses";

	if( !empty(trim($jumlahTagihan)) && !empty(trim($tglBayar)) && !empty($buktiPembayaran) ){

		if( $size <= 10000000 ) {

			$extension = pathinfo($filename, PATHINFO_EXTENSION);

			if( $type == "image/jpg" || $type == "image/jpeg" || $type == "image/png" ){
				$filename = time().".".$extension;

				move_uploaded_file($tmp_name, "buktiPembayaran/".$filename);

				$sql1 = mysqli_query($connect, "INSERT INTO tbpembayaran VALUES('', '$kodeTagihan', '$tglBayar', '$jumlahTagihan', '$filename', '$status')");

				if( $sql1 ){
					$sql2 = mysqli_query($connect, "UPDATE tbtagihan SET status = '$status' WHERE kodeTagihan = '$kodeTagihan'");

					if( $sql2 ){
						echo "<script>
							alert('Selamat transaksi berhasil !, Status pembayaran anda menjadi Proses');
							location.href = 'inputpembayaran.php';
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
			} else {
				echo "<script>
					var error = document.getElementsByClassName('error')[0];
					error.style.display='block';
					error.innerHTML = 'Maaf tipe file bukti pembayaran hanya boleh .jpg, .jpeg, .png !';
				</script>";
			}

		} else {
			echo "<script>
				var error = document.getElementsByClassName('error')[0];
				error.style.display='block';
				error.innerHTML = 'Maaf ukuran file bukti pembayaran harus dibawah (10 MB)!';
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
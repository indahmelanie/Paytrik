<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodePetugas = $_GET['kodepetugas'];

$sql = mysqli_query($connect, "SELECT * FROM tblogin WHERE kodeLogin = $kodePetugas");

if( isset($kodePetugas) ){
	if( mysqli_num_rows($sql) < 0 ){
		echo "<script>
			alert('Akun tidak ditemukan !');
			location.href = 'tampilpetugas.php';
		</script>";	
	}
} else {
	header("Location: tampilpetugas.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title> Paytrik - Edit Petugas </title>    
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
							<span> Username </span>
							<input type="text" name="username" placeholder="Masukan username . . ." value="<?php echo $row['username'] ?>" readonly>
						</div>
						<div class="cinput">
							<span> Password </span>
							<input type="text" name="password" placeholder="Masukan password . . ." value="<?php echo $row['password'] ?>">
						</div>
					</div>
					<div class="winput tmargin">
						<span> Nama Lengkap </span>
						<input type="text" name="namaLengkap" placeholder="Masukan nama lengkap . . ." value="<?php echo $row['namaLengkap'] ?>">
					</div>
					<div class="winput tmargin">
						<span> Level </span>
						<?php if( $row['username'] == $_SESSION['user'] ){ ?>
						<select name="level" disabled>
							<?php  
								$sql1 = mysqli_query($connect, "SELECT * FROM tblogin WHERE level != 'Pelanggan'");
								$level = null;
								if( $data = mysqli_fetch_assoc($sql1) ){
									$level = $data['level'];
							?>
							<option value="<?php echo $data['level'] ?>" selected> <?php echo $data['level'] ?> </option>
							<?php 
								}  

								$sql2 = mysqli_query($connect, "SELECT * FROM tblogin WHERE level <> '$level' AND level <> 'Pelanggan'");
								while( $data2 = mysqli_fetch_assoc($sql2) ){
							?>
							<option value="<?php echo $data2['level'] ?>"> <?php echo $data2['level'] ?> </option>
							<?php } ?>
						</select>
						<?php } else { ?>
							<select name="level">
								<?php  
									$sql1 = mysqli_query($connect, "SELECT * FROM tblogin WHERE kodeLogin = '$kodePetugas'");
									$level = null;
									if( $data = mysqli_fetch_assoc($sql1) ){
										$level = $data['level'];
								?>
								<option value="<?php echo $data['level'] ?>" selected> <?php echo $data['level'] ?> </option>
								<?php 
									}  

									$sql2 = mysqli_query($connect, "SELECT * FROM tblogin WHERE level != '$level' LIMIT 1");
									while( $data2 = mysqli_fetch_assoc($sql2) ){
								?>
								<option value="<?php echo $data2['level'] ?>"> <?php echo $data2['level'] ?> </option>
								<?php } ?>
							</select>
						<?php } ?>
					</div>
					<div class="winput tmargin">
						<button type="submit" name="btn-update" style="left: 0px"> Update Petugas </button>
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

	$password = mysqli_escape_string($connect, htmlspecialchars($_POST['password']));
	$namaLengkap = mysqli_escape_string($connect, htmlspecialchars($_POST['namaLengkap']));
	$level = mysqli_escape_string($connect, htmlspecialchars($_POST['level']));

	if( !empty(trim($password)) && !empty(trim($namaLengkap)) ){
				
		$sql2 = mysqli_query($connect, "UPDATE tblogin SET password = '$password', namaLengkap = '$namaLengkap', level = '$level' WHERE kodeLogin = $kodePetugas");

		if( $sql2 ){
			header("Location: tampilpetugas.php");
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
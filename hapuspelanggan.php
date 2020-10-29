<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodePelanggan = $_GET['kodepelanggan'];

if( isset($kodePelanggan) ){
	$cekTagihan = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE noPelanggan = '$kodePelanggan' AND status <> 'Lunas'");

	if( mysqli_num_rows($cekTagihan) > 0 ){
		echo "<script>
			alert('Maaf pelanggan tidak dapat dihapus, karena masih memiliki proses tagihan !');
			location.href = 'tampilpelanggan.php';
		</script>";
	} else {
		$ambilTagihan = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE noPelanggan = '$kodePelanggan' AND status = 'Lunas'");

		if( mysqli_num_rows($ambilTagihan) > 0 ){
			while( $tagihan = mysqli_fetch_assoc($ambilTagihan) ){
				$kodeTagihan = $tagihan['kodeTagihan'];
				$sql1 = mysqli_query($connect, "DELETE FROM tbpembayaran WHERE kodeTagihan = '$kodeTagihan'");

				if( $sql1 ){

					$sql2 = mysqli_query($connect, "DELETE FROM tbtagihan WHERE noPelanggan = '$kodePelanggan'");

					if( $sql2 ){
						$sql3 = mysqli_query($connect, "DELETE FROM tbpelanggan WHERE noPelanggan = '$kodePelanggan'");

						if( $sql3 ){
							$sql4 = mysqli_query($connect, "DELETE FROM tblogin WHERE username = '$kodePelanggan'");

							if( $sql4 ){
								header("Location: tampilpelanggan.php");
							} else {
								echo "<script> alert('Error4') </script>";
							}

						} else {
							echo "<script> alert('Error3') </script>";
						}
					} else {
						echo "<script> alert('Error2') </script>";
					}

				} else {
					echo "<script> alert('Error1') </script>";
				}
			}
		} else {
			$sql2 = mysqli_query($connect, "DELETE FROM tbtagihan WHERE noPelanggan = '$kodePelanggan'");

			if( $sql2 ){
				$sql3 = mysqli_query($connect, "DELETE FROM tbpelanggan WHERE noPelanggan = '$kodePelanggan'");

				if( $sql3 ){
					$sql4 = mysqli_query($connect, "DELETE FROM tblogin WHERE username = '$kodePelanggan'");

					if( $sql4 ){
						header("Location: tampilpelanggan.php");
					} else {
						echo "<script> alert('Error4') </script>";
					}

				} else {
					echo "<script> alert('Error3') </script>";
				}
			} else {
				echo "<script> alert('Error2') </script>";
			}
		}
	}
} else {
	header("Location: tampilpelanggan.php");
}

?>
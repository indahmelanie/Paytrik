<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$noPelanggan = $_GET['nopelanggan'];
$kodeTagihan = $_GET['kodetagihan'];

if( isset($noPelanggan) && isset($kodeTagihan) ){

	$select = mysqli_query($connect, "SELECT * FROM tbtagihan WHERE kodeTagihan = '$kodeTagihan' AND status = 'Lunas'");

	if( mysqli_num_rows($select) > 0 ){
		echo "<script>
				alert('Tagihan lunas tidak dapat dihapus !');
				location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
			</script>";
	} else {

		$sql1 = mysqli_query($connect, "DELETE FROM tbpembayaran WHERE kodeTagihan = '$kodeTagihan'");

		if( $sql1 ){
			$sql2 = mysqli_query($connect, "DELETE FROM tbtagihan WHERE kodeTagihan = '$kodeTagihan'");

			if( $sql2 ){
				echo "<script>
					location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
				</script>";
			} else {
				echo "<script>
					alert('Error1 !');
					location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
				</script>";
			}
		} else {
			echo "<script>
				alert('Error1 !');
				location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
			</script>";
		}
	}

} else {
	echo "<script>
		location.href = 'daftartagihan.php?nopelanggan=$noPelanggan';
	</script>";
}

?>
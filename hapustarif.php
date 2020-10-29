<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodeTarif = $_GET['kodetarif'];

if( isset($kodeTarif) ){

	$sql = mysqli_query($connect, "DELETE FROM tbtarif WHERE kodeTarif = '$kodeTarif'");

	if( $sql ){
		header("Location: tampiltarif.php");
	} else {
		echo "<script>
			alert('Tarif tidak bisa dihapus, karena ada pelanggan yang memiliki tarif ini !');
			location.href = 'tampiltarif.php;
		</script>";
	}

} else {
	header("Location: tampiltarif.php");
}

?>
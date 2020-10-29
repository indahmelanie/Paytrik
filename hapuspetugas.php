<?php 

require_once "koneksi.php";

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

if( $_SESSION['level'] != "Admin" ){
	header("Location: index.php");
}

$kodePetugas = $_GET['kodepetugas'];

if( isset($kodePetugas) ){

	$sql = mysqli_query($connect, "DELETE FROM tblogin WHERE kodeLogin = '$kodePetugas'");

	if( $sql ){
		header("Location: tampilpetugas.php");
	} else {
		echo "<script>
			alert('Error !');
			location.href = 'tampilpetugas.php;
		</script>";
	}

} else {
	header("Location: tampilpetugas.php");
}

?>
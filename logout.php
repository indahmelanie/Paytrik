<?php 

require_once "koneksi.php";

session_destroy();

if( !isset($_SESSION['user']) ){
	header("Location: index.php");
}

header("Location: index.php");

?>
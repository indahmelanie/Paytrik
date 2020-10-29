<?php 

session_start();

$connect = mysqli_connect("localhost", "root", "", "paytrik");

if( !$connect ){
	echo "Error koneksi!";
}

?>
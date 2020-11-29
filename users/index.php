<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "users/tampil.php"; break;
	case 'simpan': include "users/simpan.php"; break;
	case 'hapus': include "users/hapus.php"; break;
}
?>

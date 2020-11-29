<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "suppliers/tampil.php"; break;
	case 'simpan': include "suppliers/simpan.php"; break;
	case 'hapus': include "suppliers/hapus.php"; break;
}
?>

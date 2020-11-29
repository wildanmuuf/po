<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "category/tampil.php"; break;
	case 'simpan': include "category/simpan.php"; break;
	case 'hapus': include "category/hapus.php"; break;
}
?>

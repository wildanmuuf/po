<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "unit/tampil.php"; break;
	case 'simpan': include "unit/simpan.php"; break;
	case 'hapus': include "unit/hapus.php"; break;
}
?>

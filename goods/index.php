<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "goods/tampil.php"; break;
	case 'simpan': include "goods/simpan.php"; break;
	case 'hapus': include "goods/hapus.php"; break;
	case 'receipt': include "goods/receipt/index.php"; break;

}
?>

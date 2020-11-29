<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "product/tampil.php"; break;
	case 'simpan': include "product/simpan.php"; break;
	case 'hapus': include "product/hapus.php"; break;
	case 'receipt': include "product/receipt/index.php"; break;
}
?>

<?php
include_once "sesi.php";
$modul=(isset($_GET['p']))?$_GET['p']:"awal";
switch($modul){
	case 'awal': default: include "product/receipt/tampil.php"; break;
	case 'simpan': include "product/receipt/simpan.php"; break;
	case 'hapus': include "product/receipt/hapus.php"; break;
}
?>

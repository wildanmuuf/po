<?php
include_once "sesi.php";
$modul=(isset($_GET['p']))?$_GET['p']:"awal";
switch($modul){
	case 'awal': default: include "goods/receipt/tampil.php"; break;
	case 'simpan': include "goods/receipt/simpan.php"; break;
	case 'hapus': include "goods/receipt/hapus.php"; break;
}
?>

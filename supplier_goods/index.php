<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "supplier_goods/tampil.php"; break;
	case 'simpan': include "supplier_goods/simpan.php"; break;
	case 'hapus': include "supplier_goods/hapus.php"; break;
}
?>

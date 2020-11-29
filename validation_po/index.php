<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "purchase_requition/tampil.php"; break;
	case 'simpan': include "purchase_requition/simpan.php"; break;
	case 'hapus': include "purchase_requition/hapus.php"; break;
	case 'input_po': include "purchase_requition/input_po/index.php"; break;

}
?>

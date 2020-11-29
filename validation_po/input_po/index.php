<?php
include_once "sesi.php";
$modul=(isset($_GET['p']))?$_GET['p']:"awal";
switch($modul){
	case 'awal': default: include "purchase_requition/input_po/tampil.php"; break;
	case 'simpan': include "purchase_requition/input_po/simpan.php"; break;
	

}
?>

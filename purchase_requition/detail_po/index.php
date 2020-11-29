<?php
include_once "sesi.php";
$modul=(isset($_GET['p']))?$_GET['p']:"awal";
switch($modul){
	case 'awal': default: include "purchase_requition/detail_po/tampil.php"; break;
	case 'save_account': include "purchase_requition/detail_po/save_account.php"; break;

}
?>

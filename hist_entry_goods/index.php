<?php
include_once "sesi.php";
$modul=(isset($_GET['p']))?$_GET['p']:"awal";
switch($modul){
	case 'awal': default: include "hist_entry_goods/tampil.php"; break;
}
?>

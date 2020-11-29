<?php
include_once "sesi.php";
$modul=(isset($_GET['s']))?$_GET['s']:"awal";
switch($modul){
	case 'awal': default: include "purchase_requition/tampil.php"; break;
	case 'input_po': include "purchase_requition/input_po/index.php"; break;
	case 'entry_goods': include "purchase_requition/entry_goods/index.php"; break;
	case 'print_po': include "purchase_requition/print_po.php"; break;
	case 'print_nota': include "purchase_requition/print_nota.php"; break;
	case 'print_po_supplier': include "purchase_requition/print_po_supplier.php"; break;
	case 'detail_po': include "purchase_requition/detail_po/index.php"; break;
	case 'hapus': include "purchase_requition/hapus.php"; break;
}
?>

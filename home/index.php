<?php
include_once "sesi.php";
$id_user = $_SESSION['id_user'];
$sql = "SELECT r.rolename FROM tb_users as u
	JOIN tb_roles as r ON u.id_role=r.id_role
	WHERE u.id_user='$id_user'";
$query = $dbcon->prepare($sql);
$query->execute();
$r = $query->fetch(PDO::FETCH_ASSOC);
$home=$r['rolename'];
switch($home){
	case 'Administrator': include "home/home_admin.php"; break;
	case 'Kitchen': include "home/home_admin.php"; break;
}
?>

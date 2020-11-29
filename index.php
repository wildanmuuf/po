<?php
include('fungsi/connection.php');
try{
	session_start();
    $id_user = $_SESSION["id_user"];
	include_once "sesi.php";
	$modul=(isset($_GET['m']))?$_GET['m']:"awal";
	$sql="SELECT m.* FROM tb_permission as p
            JOIN tb_roles as r ON p.id_role=r.id_role
			JOIN tb_menu as m ON p.id_menu=m.id_menu
			JOIN tb_users as u ON r.id_role=u.id_role
            where u.id_user='$id_user' and m.aktif='Y'";
	$query = $dbcon->prepare($sql);
	$query->execute();
	while($r=$query->fetch(PDO::FETCH_ASSOC)){
		if($modul==$r['module']){
			$aktif = $r['parent_id'];
			$aktif_sub = $r['id_menu'];
			$aktif_title = $r['menu_name'];
			if($r['parent_id']=="*"){
				$menu = $r['module'];
				$aktif = $r['id_menu'];
			}
			include $r['path'];
		}
	}
}catch(PDOException $ex){
	exit($ex->getMessage());
}

?>

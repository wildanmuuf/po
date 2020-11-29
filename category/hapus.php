<?php
if(isset($_GET['idc'])){
	try{
		$id = $_GET['idc'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_category SET active='T', last_modified='$today' WHERE id_category='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=category'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Kategori Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

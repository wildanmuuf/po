<?php
if(isset($_GET['idpg'])){
	try{
		$id = $_GET['idpg'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_product SET active='T', mod_timestamp='$today' WHERE id_product='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=goods'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Kategori Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

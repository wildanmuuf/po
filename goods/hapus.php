<?php
if(isset($_GET['idg'])){
	try{
		$id = $_GET['idg'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_goods SET active='T', mod_timestamp='$today' WHERE id_goods='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=goods'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Barang Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

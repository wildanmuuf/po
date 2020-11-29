<?php
if(isset($_GET['ids'])){
	try{
		$id = $_GET['ids'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_unit SET active='T', last_modified='$today' WHERE id_unit='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=unit'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Satuan Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

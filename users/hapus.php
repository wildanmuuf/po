<?php
if(isset($_GET['idu'])){
	try{
		$id = $_GET['idu'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_category SET active='T', mod_timestamp='$today' WHERE id_category='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=users'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Users Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

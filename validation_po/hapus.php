<?php
if(isset($_GET['idpr'])){
	try{
		$id = $_GET['idpr'];
		$today = date('Y-m-d H:i:s');
		$sql="UPDATE tb_purchase_requition SET status=0, last_modified='$today' WHERE id_purchase_requition='$id'";
		$dbcon->exec($sql);
		echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Barang Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

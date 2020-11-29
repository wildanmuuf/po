<?php
if(isset($_GET['idrp'])){
	try{
		$id = $_GET['idrp'];
		$today = date('Y-m-d H:i:s');
		$sql="DELETE FROM tb_receipt WHERE id_receipt='$id'";
		$dbcon->exec($sql);

		$sql = "UPDATE tb_product SET total_cost = (SELECT sum(cost) FROM tb_receipt WHERE id_product = :id_product) FROM tb_product WHERE id_product:id_product";
        $query = $dbcon->prepare($sql);
        $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
		$query->execute();
		
		echo "<script type='text/javascript'> document.location = 'index.php?m=product'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Kategori Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

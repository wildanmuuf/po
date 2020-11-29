<?php
if(isset($_GET['idp'])){
	try{
        $idpr = $_POST['idpr'];
		$status = 0;
		$today = date('Y-m-d H:i:s');
		$sql = "UPDATE tb_purchase_requition SET status=:status, last_modified=:last_modified WHERE id_purchase_requition=:idpr";
        $query=$dbcon->prepare($sql);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("last_modified", $today, PDO::PARAM_STR);
        $query->execute();
        $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Cetak Nota Pengajuan", "Ditransfer", "Selesai");
		echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Kategori Error!');</script>";
		print_r($dbcon->errorInfo());
	}
}
?>

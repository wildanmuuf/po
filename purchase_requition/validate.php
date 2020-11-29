<?php
    include('../fungsi/connection.php');
    try{
        $status = $_POST['status'];
        $idpr = $_POST['idpr'];
		$today = date('Y-m-d H:i:s');
        $sql = "UPDATE tb_purchase_requition SET status=:status, last_modified=:last_modified WHERE id_purchase_requition=:idpr";
        $query=$dbcon->prepare($sql);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("last_modified", $today, PDO::PARAM_STR);
        $query->execute();
        $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Cetak Nota Pengajuan", "Ditransfer", "Proses Beli", "Pembayaran Suplier", "Selesai");
        $status_view =$arr_status[$status];
        echo json_encode(array('status' => $status_view));
    }catch(PDOException $ex){
        // echo $ex->getMessage();
        print_r($ex);
    }
?>
   
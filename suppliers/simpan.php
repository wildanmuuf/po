<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $suplier = $_POST['suplier'];
        $telp = $_POST['telp'];
        $alamat = $_POST['alamat'];
        $today = date('Y-m-d H:i:s');
        $aktif = !empty($_POST['aktif']) ? "Y" : "T";
        $id_supplier = $_POST['id_supplier'];
        if($id_supplier <> ""){
            if($id_supplier > 0){
                $sql = "UPDATE tb_suppliers SET name=:suplier, address=:alamat, phone_number=:telp, active=:aktif, last_modified=:last_modified, modified_by=:modified_by where id_supplier=:id_supplier";
                $query = $dbcon->prepare($sql);
                $query->bindParam("suplier", $suplier, PDO::PARAM_STR);
                $query->bindParam("alamat", $alamat, PDO::PARAM_STR);
                $query->bindParam("telp", $telp, PDO::PARAM_STR);
                $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=suppliers'; </script>";
            }
        }else{
            $sql = "INSERT INTO tb_suppliers VALUES (null, :suplier, :alamat, :telp, :aktif, :created, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("suplier", $suplier, PDO::PARAM_STR);
            $query->bindParam("alamat", $alamat, PDO::PARAM_STR);
            $query->bindParam("telp", $telp, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
            $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=suppliers'; </script>";

        }
        
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Suplier Error!');</script>";
        exit($ex->getMessage());
    }
}else{
	echo '<script>window.history.back()</script>';
}
?>

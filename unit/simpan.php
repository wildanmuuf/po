<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $unit = $_POST['unit'];
        $today = date('Y-m-d H:i:s');
        $aktif = !empty($_POST['aktif']) ? "Y" : "T";
        $id_unit = $_POST['id_unit'];
        if($id_unit <> ""){
            if($id_unit > 0){
                $sql = "UPDATE tb_unit SET name=:unit, active=:aktif, last_modified=:last_modified, modified_by=:modified_by where id_unit=:id_unit";
                $query = $dbcon->prepare($sql);
                $query->bindParam("unit", $unit, PDO::PARAM_STR);
                $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->bindParam("id_unit", $id_unit, PDO::PARAM_STR);
                $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=unit'; </script>";
            }
        }else{
            $sql = "INSERT INTO tb_unit VALUES (null, :unit, :aktif, :created, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("unit", $unit, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
            $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=unit'; </script>";
        }
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Satuan Error!');</script>";
        exit($ex->getMessage());
    }
}else{
	echo '<script>window.history.back()</script>';
}
?>

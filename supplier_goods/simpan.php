<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $id_supplier_goods = $_POST['id_supplier_goods'];
        $id_supplier = $_POST['id_supplier'];
        $id_goods = $_POST['id_goods'];
        $price = str_replace(".", "", $_POST['price']);
        $price = str_replace("Rp ", "", $price);
        $today = date('Y-m-d H:i:s');
        $aktif = !empty($_POST['aktif']) ? "Y" : "T";
        if($id_supplier_goods <> ""){
            if($id_supplier_goods > 0){
                $sql = "UPDATE tb_supplier_goods SET id_supplier=:id_supplier, id_goods=:id_goods, price=:price, active=:aktif, last_modified=:last_modified, modified_by=:modified_by where id_supplier_goods=:id_supplier_goods";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
                $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
                $query->bindParam("price", $price, PDO::PARAM_STR);
                $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->bindParam("id_supplier_goods", $id_supplier_goods, PDO::PARAM_STR);
                $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=supplier_goods'; </script>";
            }
        }else{
            $sql = "INSERT INTO tb_supplier_goods VALUES (null, :id_supplier, :id_goods, :price, :aktif, :created, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
            $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
            $query->bindParam("price", $price, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
            $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=supplier_goods'; </script>";

        }
        
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Suplier Error!');</script>";
        exit($ex->getMessage());
    }
}else{
	echo '<script>window.history.back()</script>';
}
?>

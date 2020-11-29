<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $purchase_requition = $_POST['purchase_requition'];
        $unit = $_POST['unit'];
        $quantity_unit = $_POST['quantity'];
        $group = $_POST['id_group'];
        $price_estimate = str_replace(".", "", $_POST['price_estimate']);
        $price_estimate = str_replace("Rp ", "", $price_estimate);
        $today = date('Y-m-d H:i:s');
        $aktif = !empty($_POST['aktif']) ? "Y" : "T";
        $id_goods = $_POST['id_goods'];
        if($id_goods <> ""){
            if($id_goods > 0){
                $sql = "UPDATE tb_goods SET name=:purchase_requition, price_estimate=:price_estimate, quantity_unit=:quantity_unit, active=:aktif, last_modified=:last_modified, modified_by=:modified_by,
                   id_role=:group, id_unit=:unit where id_goods=:id_goods";
                $query = $dbcon->prepare($sql);
                $query->bindParam("purchase_requition", $purchase_requition, PDO::PARAM_STR);
                $query->bindParam("price_estimate", $price_estimate, PDO::PARAM_STR);
                $query->bindParam("quantity_unit", $quantity_unit, PDO::PARAM_STR);
                $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                $query->bindParam("group", $group, PDO::PARAM_STR);
                $query->bindParam("unit", $unit, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
                $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition'; </script>";
            }
        }else{
            $sql = "INSERT INTO tb_goods VALUES (null, :purchase_requition, 0, :quantity, :price_estimate, :price_estimate, :aktif, :created, null, :created_by, 0, :group, :unit)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("purchase_requition", $purchase_requition, PDO::PARAM_STR);
            $query->bindParam("quantity_unit", $quantity_unit, PDO::PARAM_STR);
            $query->bindParam("price_estimate", $price_estimate, PDO::PARAM_STR);
            $query->bindParam("group", $group, PDO::PARAM_STR);
            $query->bindParam("unit", $unit, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
            $query->execute();
            echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition'; </script>";
        }
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Barang Error!');</script>";
        exit($ex->getMessage());
    }
}else{
	echo '<script>window.history.back()</script>';
}
?>

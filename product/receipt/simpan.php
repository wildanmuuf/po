<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $id_goods = $_POST['id_goods'];
        $quantity = $_POST['quantity'];
        $today = date('Y-m-d H:i:s');
        $id_product = $_POST['id_product'];
        $id_receipt = $_POST['id_receipt'];
        $cost = str_replace(".", "", $_POST['cost']);
        $cost = str_replace("Rp ", "", $cost);
        if($id_receipt <> ""){
            if($id_receipt > 0){
                $sql = "UPDATE tb_receipt SET id_goods=:id_goods, cost=:cost, quantity=:quantity, last_modified=:mod_time, modified_by=:modified_by where id_receipt=:id_receipt";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
                $query->bindParam("cost", $cost, PDO::PARAM_STR);
                $query->bindParam("quantity", $quantity, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("mod_time", $today, PDO::PARAM_STR);
                $query->bindParam("id_receipt", $id_receipt, PDO::PARAM_STR);
                $query->execute();
            }
        }else{
            $sql = "INSERT INTO tb_receipt VALUES (null, :id_product, :id_goods, :quantity, :cost, :added_time, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
            $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
            $query->bindParam("cost", $cost, PDO::PARAM_STR);
            $query->bindParam("quantity", $quantity, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("added_time", $today, PDO::PARAM_STR);
            $query->execute();
        }

        $sql = "UPDATE tb_product SET total_cost = (SELECT sum(cost) FROM tb_receipt WHERE id_product =:id_product) WHERE id_product=:id_product";
        $query = $dbcon->prepare($sql);
        $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
        $query->execute();
        echo "<script type='text/javascript'> document.location = 'index.php?m=product&s=receipt&idp=$id_product'; </script>";

        
    }catch(PDOException $ex){
        
        echo "<script type='text/javascript'>alert('Tambah Produk Error!');</script>";
        // exit($ex->getMessage());
        var_dump($ex);
    }
}
?>

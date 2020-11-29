<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $id_goods = $_POST['id_goods'];
        $quantity = $_POST['quantity'];
        $today = date('Y-m-d H:i:s');
        $id_parent_goods = $_POST['id_parent_goods'];
        $id_goods_receipt = $_POST['id_goods_receipt'];
        $cost = str_replace(".", "", $_POST['cost']);
        $cost = str_replace("Rp ", "", $cost);
        if($id_goods_receipt <> ""){
            if($id_goods_receipt > 0){
                $sql = "UPDATE tb_goods_receipt SET child_id_goods=:child_id_goods, cost=:cost, quantity=:quantity, last_modified=:mod_time, modified_by=:modified_by where id_goods_receipt=:id_goods_receipt";
                $query = $dbcon->prepare($sql);
                $query->bindParam("child_id_goods", $id_goods, PDO::PARAM_STR);
                $query->bindParam("cost", $cost, PDO::PARAM_STR);
                $query->bindParam("quantity", $quantity, PDO::PARAM_STR);
                $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("mod_time", $today, PDO::PARAM_STR);
                $query->bindParam("id_goods_receipt", $id_goods_receipt, PDO::PARAM_STR);
                $query->execute();
            }
        }else{
            $sql = "INSERT INTO tb_goods_receipt VALUES (null, :id_parent_goods, :id_goods, :quantity, :cost, :added_time, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
            $query->bindParam("id_parent_goods", $id_parent_goods, PDO::PARAM_STR);
            $query->bindParam("cost", $cost, PDO::PARAM_STR);
            $query->bindParam("quantity", $quantity, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("added_time", $today, PDO::PARAM_STR);
            $query->execute();
        }
        $sql = "UPDATE tb_goods SET fixed_price = (SELECT sum(cost) FROM tb_goods_receipt WHERE parent_id_goods =:id_parent_goods) WHERE id_goods=:id_parent_goods";
        $query = $dbcon->prepare($sql);
        $query->bindParam("id_parent_goods", $id_parent_goods, PDO::PARAM_STR);
        $query->execute();
        echo "<script type='text/javascript'> document.location = 'index.php?m=goods&s=receipt&idpg=$id_parent_goods'; </script>";
    }catch(PDOException $ex){
        
        echo "<script type='text/javascript'>alert('Tambah Produk Error!');</script>";
        exit($ex->getMessage());
    }
}
?>

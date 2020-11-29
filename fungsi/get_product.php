<?php
    include('../fungsi/connection.php');
    try{
        $data_url = file_get_contents("https://admin.coffeeandcouple.com/fungsi/get_products.php");
        $data = unserialize(base64_decode($data_url));
        foreach($data as $value){
            $id_product = $value['id_product'];
            $product_name = $value['product_name'];
            $price = $value['price'];
            $id_category = $value['id_category'];
            $created = $value['created'];
            $last_modified = $value['last_modified'];
            $active = $value['active'];
            $sql = "SELECT id_product FROM tb_product WHERE id_product = :id_product";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() == 0){
                $sql = "INSERT INTO tb_product VALUES (:id_product, :product_name, :price, :active, :created, null, 0, 0, :id_category)";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
                $query->bindParam("product_name", $product_name, PDO::PARAM_STR);
                $query->bindParam("price", $price, PDO::PARAM_STR);
                $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
                $query->bindParam("created", $created, PDO::PARAM_STR);
                $query->bindParam("active", $active, PDO::PARAM_STR);
                $query->execute();
            }else{
                $sql = "UPDATE tb_product SET product_name=:product_name, price=:price, id_category=:id_category, last_modified=:last_modified, active=:active WHERE id_product=:id_product";
                $query = $dbcon->prepare($sql);
                $query->bindParam("product_name", $product_name, PDO::PARAM_STR);
                $query->bindParam("price", $price, PDO::PARAM_STR);
                $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
                $query->bindParam("last_modified", $last_modified, PDO::PARAM_STR);
                $query->bindParam("active", $active, PDO::PARAM_STR);
                $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
                $query->execute();
            }
        }
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
?>
   
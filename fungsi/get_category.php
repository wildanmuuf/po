<?php
    include('../fungsi/connection.php');
    try{
        $data_url = file_get_contents("https://admin.coffeeandcouple.com/fungsi/get_categories.php");
        $data = unserialize(base64_decode($data_url));
        foreach($data as $value){
            $id_category = $value['id_category'];
            $category_name = $value['category_name'];
            $created = $value['created'];
            $last_modified = $value['last_modified'];
            $group_category = $value['group_category'];
            $active = $value['active'];
            $sql = "SELECT id_category FROM tb_category WHERE id_category = :id_category";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() == 0){
                $sql = "INSERT INTO tb_category VALUES (:id_category, :category_name, :group_category, :active, :created, null, 0, 0)";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
                $query->bindParam("category_name", $category_name, PDO::PARAM_STR);
                $query->bindParam("group_category", $group_category, PDO::PARAM_STR);
                $query->bindParam("created", $created, PDO::PARAM_STR);
                $query->bindParam("active", $active, PDO::PARAM_STR);
                $query->execute();
                echo "update";
            }else{
                $sql = "UPDATE tb_category SET category_name=:category_name, group_category=:group_category,  last_modified=:last_modified, active=:active WHERE id_category=:id_category";
                $query = $dbcon->prepare($sql);
                $query->bindParam("category_name", $category_name, PDO::PARAM_STR);
                $query->bindParam("last_modified", $last_modified, PDO::PARAM_STR);
                $query->bindParam("active", $active, PDO::PARAM_STR);
                $query->bindParam("group_category", $group_category, PDO::PARAM_STR);
                $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
                $query->execute();
                echo "update";
            }
        }
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
?>
   
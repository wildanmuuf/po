<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $produk = $_POST['produk'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $group_product = $_POST['group_product'];
        $today = date('Y-m-d H:i:s');
        $aktif = $_POST['aktif'];
        $id_product = $_POST['id_product'];
        if($id_product <> ""){
            if($id_product > 0){
                $sql = "UPDATE tb_product SET product_name=:produk, price=:harga, active=:aktif, last_modified=:mod_time, id_category=:kategori where id_product=:id_product";
                $query = $dbcon->prepare($sql);
                $query->bindParam("produk", $produk, PDO::PARAM_STR);
                $query->bindParam("harga", $harga, PDO::PARAM_STR);
                $query->bindParam("mod_time", $today, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->bindParam("group_product", $group_product, PDO::PARAM_STR);
                $query->bindParam("kategori", $kategori, PDO::PARAM_STR);
                $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
                $query->execute();
                echo "<script type='text/javascript'> document.location = 'index.php?m=product'; </script>";
            }
        }else{
            $sql = "INSERT INTO tb_product VALUES (null, :produk, :harga, 0,0, :aktif, :added_time, null, :created_by, 0, :kategori, :group_product)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("produk", $produk, PDO::PARAM_STR);
            $query->bindParam("kategori", $kategori, PDO::PARAM_STR);
            $query->bindParam("group_product", $group_product, PDO::PARAM_STR);
            $query->bindParam("harga", $harga, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("added_time", $today, PDO::PARAM_STR);
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
            $query->execute();
            $id_product = $dbcon->lastInsertId();
            if($group_product == 1){
                echo "<script type='text/javascript'> document.location = 'index.php?m=product&s=receipt&idp=$id_product'; </script>";
            }else{
                echo "<script type='text/javascript'> document.location = 'index.php?m=product'; </script>";
            }
        }
        
    }catch(PDOException $ex){
        
        echo "<script type='text/javascript'>alert('Tambah Produk Error!');</script>";
        exit($ex->getMessage());
    }
}else{
	echo '<script>window.history.back()</script>';
}
?>

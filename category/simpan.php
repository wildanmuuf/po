<?php
if(isset($_POST['simpan'])){
        try{
            $kategori = $_POST['kategori'];
            $grup_kategori = $_POST['grup_kategori'];
            $today = date('Y-m-d H:i:s');
            $aktif = !empty($_POST['aktif']) ? "Y" : "T";
            $id_category = $_POST['id_category'];
            if($id_category <> ""){
                if($id_category > 0){
                    $sql = "UPDATE tb_category SET category_name=:kategori, group_category=:grup_kategori, active=:aktif, last_modified=:mod_time where id_category=:id_category";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("kategori", $kategori, PDO::PARAM_STR);
                    $query->bindParam("mod_time", $today, PDO::PARAM_STR);
                    $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                    $query->bindParam("grup_kategori", $grup_kategori, PDO::PARAM_STR);
                    $query->bindParam("id_category", $id_category, PDO::PARAM_STR);
                    $query->execute();
                echo "<script type='text/javascript'> document.location = 'index.php?m=category'; </script>";
                }
            }else{
                $sql = "INSERT INTO tb_category VALUES (null, :kategori, :grup_kategori, :aktif, :created, null, :created_by, 0)";
                $query = $dbcon->prepare($sql);
                $query->bindParam("kategori", $kategori, PDO::PARAM_STR);
                $query->bindParam("grup_kategori", $grup_kategori, PDO::PARAM_STR);
                $query->bindParam("created", $today, PDO::PARAM_STR);
                $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->execute();
                echo "<script type='text/javascript'> document.location = 'index.php?m=category'; </script>";

            }
           
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Tambah Kategori Error!');</script>";
            exit($ex->getMessage());
        }
}else{
	echo '<script>window.history.back()</script>';
}
?>

<?php
if(isset($_POST['simpan'])){
        try{
            $username = $_POST['username'];
            $grup_user = $_POST['grup_user'];
            $today = date('Y-m-d H:i:s');
            $password = $_POST['password'];
            if($password <> ""){
                $encrypt = hash('sha256', $password);
            }else{
                $sql = "SELECT password FROM tb_users WHERE id_user=:id_user";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_user", $id_user, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $encrypt = $result['password'];
            }
            $aktif = !empty($_POST['aktif']) ? "Y" : "T";
            $id_user = $_POST['id_user'];
            if($id_user <> ""){
                if($id_user > 0){
                    $sql = "UPDATE tb_users SET username=:username, password=:password,  id_role=:id_role, status=:aktif, last_modified=:last_modified where id_user=:id_user";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("username", $username, PDO::PARAM_STR);
                    $query->bindParam("password", $encrypt, PDO::PARAM_STR);
                    $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                    $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                    $query->bindParam("id_role", $grup_user, PDO::PARAM_STR);
                    $query->bindParam("id_user", $id_user, PDO::PARAM_STR);
                    $query->execute();
                echo "<script type='text/javascript'> document.location = 'index.php?m=users'; </script>";
                }
            }else{
                $sql = "INSERT INTO tb_users VALUES (null, :username, :password, :aktif, :created, null, :id_role)";
                $query = $dbcon->prepare($sql);
                $query->bindParam("username", $username, PDO::PARAM_STR);
                $query->bindParam("password", $encrypt, PDO::PARAM_STR);
                $query->bindParam("created", $today, PDO::PARAM_STR);
                $query->bindParam("id_role", $grup_user, PDO::PARAM_STR);
                $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
                $query->execute();
                echo "<script type='text/javascript'> document.location = 'index.php?m=users'; </script>";

            }
           
        }catch(PDOException $ex){
            echo "<script type='text/javascript'>alert('Tambah Users Error!');</script>";
            exit($ex->getMessage());
        }
}else{
	echo '<script>window.history.back()</script>';
}
?>

<?php
    if(isset($_POST['btn_login'])){
        include('fungsi/connection.php');
        try{
            session_start();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $encrypt = hash('sha256', $password);
            $sql = "SELECT u.* 
            FROM tb_users as u 
            JOIN tb_roles as r on u.id_role=r.id_role
            WHERE u.username=:username AND u.password=:password";
            $query = $dbcon->prepare($sql);
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password", $encrypt, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() > 0){
                $user = $query->fetch(PDO::FETCH_ASSOC);
                $id_user = $user['id_user'];
                $sql_cek = "SELECT aktif FROM tb_security_password
                    WHERE id_user = :id_user";
                $query_cek = $dbcon->prepare($sql_cek);
                $query_cek->bindParam("id_user", $id_user, PDO::PARAM_STR);
                
                if($query_cek->execute()){
                    $r1 = $query_cek->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['id_user'] = $user['id_user'];
                    if($user['status'] == "C" && $r1['aktif'] == "Y"){
                        $_SESSION['status_user'] = $user['status'];
                        echo "<script type='text/javascript'> document.location = 'index.php?m=change_password'; </script>";
                    }else{
                        $_SESSION['id_user'] = $user['id_user'];
                        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
                    }
                }
            }else{
                echo "<script type='text/javascript'>alert('Username/password salah'); window.history.back();</script>";
                print_r($query->errorInfo());
            }
        }catch(PDOException $ex){
            exit($ex->getMessage());
        }
    }
?>
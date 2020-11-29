<?php
if(isset($_POST['simpan'])){
    try{
        $id_user = $_SESSION['id_user'];
        $method = $_POST['method'];
        $idpr = $_POST['idpr'];
        $id_account = 0;
        $today = date('Y-m-d H:i:s');
        $cur_account = isset($_POST['cur_account']) ? $_POST['cur_account'] : 0;
        if($method == 2){
            if($cur_account == 0){
                $behalf = $_POST['behalf'];
                $account_bank = $_POST['account_bank'];
                $today = date('Y-m-d H:i:s');
                $account = $_POST['account'];
                $sql = "INSERT INTO tb_account VALUES (null, :behalf, :account, :account_bank, :created, null, :created_by, 0)";
                $query = $dbcon->prepare($sql);
                $query->bindParam("behalf", $behalf, PDO::PARAM_STR);
                $query->bindParam("account", $account, PDO::PARAM_STR);
                $query->bindParam("account_bank", $account_bank, PDO::PARAM_STR);
                $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
                $query->bindParam("created", $today, PDO::PARAM_STR);
                $query->execute();
                $id_account = $dbcon->lastInsertId();
            }
        }
        
        $sql = "INSERT INTO tb_payment VALUES (null, :method, :idpr, :id_account, :created, null, :created_by, 0)";
        $query = $dbcon->prepare($sql);
        $query->bindParam("method", $method, PDO::PARAM_STR);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->bindParam("id_account", $id_account, PDO::PARAM_STR);
        $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
        $query->bindParam("created", $today, PDO::PARAM_STR);

        if($query->execute()){
            $status = 4;
            $sql = "UPDATE tb_purchase_requition SET status=:status, last_modified=:last_modified WHERE id_purchase_requition=:idpr";
            $query=$dbcon->prepare($sql);
            $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
            $query->bindParam("status", $status, PDO::PARAM_STR);
            $query->bindParam("last_modified", $today, PDO::PARAM_STR);
            $query->execute();

            echo "<script type='text/javascript'> 

                    window.open('index.php?m=purchase_requition&s=print_nota&idpr=$idpr')";
            echo "</script>";
            echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition&s=detail_po&idpr=$idpr'; </script>";
        }
    }catch(PDOException $ex){
        
        echo "<script type='text/javascript'>alert('Tambah Produk Error!');</script>";
        exit($ex->getMessage());
    }
}
?>

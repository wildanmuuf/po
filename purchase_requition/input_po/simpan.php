<?php
if(isset($_POST['simpan'])){
    try{
        $id_purchase_requition = isset($_POST['idpr']) ? $_POST['idpr'] : "";
        $trx_date = strtr($_POST['trx_date'], '/', '-');
        $trx_date = date('Y-m-d', strtotime($trx_date));
        $today = date('Y-m-d H:i:s');
        if(isset($_POST['due_date'])){
            $due_date = $_POST['due_date'];
            $due_date = strtr($_POST['due_date'], '/', '-');
            $due_date = date('Y-m-d', strtotime($due_date));
        }
        $category = $_POST['category'];
        $sql = "SELECT max(id_purchase_requition) as maxCode FROM tb_purchase_requition";
        $query = $dbcon->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $arr_code = explode('-',$result['maxCode']);
        $num = 0;
        if($result['maxCode'] != ''){
            $num = (int) $arr_code[3];
        }
        $num++;
        $cc = "CC";
        $trx = date('Ymd',strtotime($trx_date));
        $code = $cc.'-'.$category.'-'.$trx.'-'. sprintf("%04s", $num);

        $status = 1;
        $total = $_POST['total_po'];
        $id_user = $_SESSION['id_user'];
        $goods = $_POST['goods'];
        $quantities = $_POST['qty'];
        $suppliers = $_POST['suppliers'];
        $count = count($_POST['goods']);
        $i = 0;
        $data = array();
        while($i < $count){
            $arr = array();
            $arr['id_goods'] = $goods[$i]; 
            $arr['quantity'] = $quantities[$i]; 
            $arr['supplier'] = $suppliers[$i];
            $data[] = $arr;
            $i++;
        }
        $i = 0;
        if($id_purchase_requition == ""){
            $sql = "INSERT INTO tb_purchase_requition VALUES (:code, :trx_date, :due_date,  :category, :total, :status, :created, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("code", $code, PDO::PARAM_STR);
            $query->bindParam("trx_date", $trx_date, PDO::PARAM_STR);
            $query->bindParam("due_date", $due_date, PDO::PARAM_STR);
            $query->bindParam("total", $total, PDO::PARAM_STR);
            $query->bindParam("category", $category, PDO::PARAM_STR);
            $query->bindParam("status", $status, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            if($query->execute()){
                while($i < count($data)){
                    $sql = "INSERT INTO tb_detail_pr_item VALUES (null, :quantity, :id_purchase_requition, :id_supplier, :id_goods)";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("quantity", $data[$i]['quantity'], PDO::PARAM_STR);
                    $query->bindParam("id_purchase_requition", $code, PDO::PARAM_STR);
                    $query->bindParam("id_supplier", $data[$i]['supplier'], PDO::PARAM_STR);
                    $query->bindParam("id_goods", $data[$i]['id_goods'], PDO::PARAM_STR);
                    $query->execute();
                    $i++;
                }
            }
        }
        else{
            $sql = "UPDATE tb_purchase_requition SET trx_date=:trx_date, due_date=:due_date,
                total=:total, category=:category, last_modified=:last_modified, modified_by=:modified_by
                WHERE id_purchase_requition=:id";
            $query = $dbcon->prepare($sql);
            $query->bindParam("trx_date", $trx_date, PDO::PARAM_STR);
            $query->bindParam("due_date", $due_date, PDO::PARAM_STR);
            $query->bindParam("total", $total, PDO::PARAM_STR);
            $query->bindParam("category", $category, PDO::PARAM_STR);
            $query->bindParam("last_modified", $today, PDO::PARAM_STR);
            $query->bindParam("modified_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("id", $id_purchase_requition, PDO::PARAM_STR);
            if($query->execute()){
                $sql = "SELECT id_goods FROM tb_detail_pr_item WHERE id_purchase_requition = :idpr";
                $query = $dbcon->prepare($sql);
                $query->bindParam("idpr", $id_purchase_requition, PDO::PARAM_STR);
                $query->execute();
                if($query->rowCount() > 0){
                    $sql = "DELETE FROM tb_detail_pr_item WHERE id_purchase_requition = :idpr";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("idpr", $id_purchase_requition, PDO::PARAM_STR);
                    $query->execute();
                }
                while($i < count($data)){
                    $sql = "INSERT INTO tb_detail_pr_item VALUES (null, :quantity, :id_purchase_requition, :id_supplier, :id_goods)";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("quantity", $data[$i]['quantity'], PDO::PARAM_STR);
                    $query->bindParam("id_purchase_requition", $code, PDO::PARAM_STR);
                    $query->bindParam("id_supplier", $data[$i]['supplier'], PDO::PARAM_STR);
                    $query->bindParam("id_goods", $data[$i]['id_goods'], PDO::PARAM_STR);
                    $query->execute();
                    $i++;
                }
            }
        }
        echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition'; </script>";
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Barang Error!');</script>";
        print_r($ex);
    }
}
?>

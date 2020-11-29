<?php
if(isset($_POST['simpan'])){
    try{
        $idpr = isset($_POST['idpr']) ? $_POST['idpr'] : "";
        $today = date('Y-m-d H:i:s');
        $infos = $_POST['info'];
        $id_dprs = $_POST['id_dpr'];
        $id_user = $_SESSION['id_user'];
        $quantities = $_POST['qty_receive'];
        $prices = $_POST['price_fixed'];
        $count = count($_POST['qty_receive']);
        $i = 0;
        $data = array();
        while($i < $count){
            $arr = array();
            $arr['info'] = $infos[$i]; 
            $arr['id_dpr'] = $id_dprs[$i]; 
            $arr['quantity'] = $quantities[$i];
            $arr['fixed_price'] = $prices[$i];
            $data[] = $arr;
            $i++;
        }
        $i = 0;
        while($i < count($data)){
            $sql = "SELECT CASE WHEN g.fixed_price > 0 THEN g.fixed_price
            ELSE g.price_estimate
            END price FROM tb_detail_pr_item dpr
            JOIN tb_goods g ON g.id_goods = dpr.id_goods
            WHERE id_detail_pr_item = :id_dpr";
            $query = $dbcon->prepare($sql);
            $query->bindParam("id_dpr", $data[$i]['id_dpr'], PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $last_price = $result['price'];
            $sql = "INSERT INTO tb_entry_goods VALUES (null, :quantity, :fixed_price, :last_price, :info, :id_dpr, :created, null, :created_by, 0)";
            $query = $dbcon->prepare($sql);
            $query->bindParam("quantity", $data[$i]['quantity'], PDO::PARAM_STR);
            $query->bindParam("info", $data[$i]['info'], PDO::PARAM_STR);
            $query->bindParam("fixed_price", $data[$i]['fixed_price'], PDO::PARAM_STR);
            $query->bindParam("id_dpr", $data[$i]['id_dpr'], PDO::PARAM_STR);
            $query->bindParam("created_by", $id_user, PDO::PARAM_STR);
            $query->bindParam("last_price", $last_price, PDO::PARAM_STR);
            $query->bindParam("created", $today, PDO::PARAM_STR);
            if($query->execute()){
                $sql = "SELECT id_goods FROM tb_detail_pr_item WHERE id_detail_pr_item = :id_dpr";
                $query = $dbcon->prepare($sql);
                $query->bindParam("id_dpr", $data[$i]['id_dpr'], PDO::PARAM_STR);
                if($query->execute()){
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    $id_goods = $result['id_goods'];
                    $sql = "UPDATE tb_goods SET stock=(SELECT stock FROM tb_goods WHERE id_goods=:id_goods)+:entry_stock, 
                        last_modified=:last_modified, fixed_price=:fixed_price WHERE id_goods=:id_goods";
                    $query = $dbcon->prepare($sql);
                    $query->bindParam("entry_stock", $data[$i]['quantity'], PDO::PARAM_STR);
                    $query->bindParam("fixed_price", $data[$i]['fixed_price'], PDO::PARAM_STR);
                    $query->bindParam("last_modified", $today, PDO::PARAM_STR);
                    $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
                    $query->execute();
                }
            }

            $i++;
        }
        $sql = "SELECT category FROM tb_purchase_requition WHERE id_purchase_requition=:idpr";
        $query=$dbcon->prepare($sql);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result['category'] == 1){
            $status = 8;
        }else{
            $status = 7;
        }
        $sql = "UPDATE tb_purchase_requition SET status=:status, last_modified=:last_modified WHERE id_purchase_requition=:idpr";
        $query=$dbcon->prepare($sql);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->bindParam("status", $status, PDO::PARAM_STR);
        $query->bindParam("last_modified", $today, PDO::PARAM_STR);
        $query->execute();
        echo "<script type='text/javascript'> document.location = 'index.php?m=purchase_requition&s=detail_po&idpr=$idpr'; </script>";
    }catch(PDOException $ex){
        echo "<script type='text/javascript'>alert('Tambah Barang Error!');</script>";
        print_r($ex);
    }
}
?>

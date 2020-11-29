<?php
    try{
        include('../../fungsi/connection.php');
        $idpr = $_POST['idpr'];
        $sql = "SELECT g.*, u.name as unit, dpr.*,
            CASE WHEN g.fixed_price > 0 THEN g.fixed_price
            ELSE g.price_estimate
            END price
            FROM tb_goods g 
            JOIN tb_detail_pr_item dpr ON dpr.id_goods = g.id_goods
            JOIN tb_unit u ON u.id_unit = g.id_unit
            WHERE g.active='Y' and dpr.id_purchase_requition=:idpr";
        $query = $dbcon->prepare($sql);
        $query->bindParam('idpr', $idpr, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        $counter = 0;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $arr['id_goods'] = $row['id_goods'];
            $arr['stock'] = $row['stock'];
            $arr['unit'] = $row['unit'];
            $arr['price'] = $row['price'];
            $arr['id_supplier'] = $row['id_supplier'];
            $arr['quantity_unit'] = $row['quantity_unit'];
            $arr['quantity'] = $row['quantity'];
            $data[$counter] = $arr;
            $counter++;
        }
        echo json_encode($data);
        header('Content-Type: application/json; charset=utf-8');
    }catch(PDOException $ex){
        exit($ex->getMessage());
    }

?>
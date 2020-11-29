<?php
    try{
        include('../../fungsi/connection.php');
        $id_goods = $_POST['id'];
        $sql = "SELECT g.*, u.name as unit,
            CASE WHEN g.fixed_price > 0 THEN g.fixed_price
            ELSE g.price_estimate
            END price
            FROM tb_goods g 
            JOIN tb_unit u ON u.id_unit = g.id_unit
            WHERE g.active='Y' and g.id_goods=:id_goods";
        $query = $dbcon->prepare($sql);
        $query->bindParam('id_goods', $id_goods, PDO::PARAM_INT);
        $query->execute();
        $data = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $data['stock'] = $row['stock'];
            $data['id_goods'] = $row['stock'];
            $data['unit'] = $row['unit'];
            $data['price'] = $row['price'];
            $data['quantity_unit'] = $row['quantity_unit'];
        }
        echo json_encode($data);
    }catch(PDOException $ex){
        exit($ex->getMessage());
    }

?>
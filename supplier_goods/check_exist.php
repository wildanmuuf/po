<?php
    include('../fungsi/connection.php');
    $id_supplier = $_POST['id_supplier'];
    $id_goods = $_POST['id_goods'];
    $sql = "SELECT sg.id_supplier_goods, g.name, sg.price FROM tb_supplier_goods sg
    JOIN tb_goods g ON g.id_goods=sg.id_goods
    WHERE sg.id_supplier=:id_supplier and sg.id_goods=:id_goods";
    $query = $dbcon->prepare($sql);
    $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
    $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
    $query->execute(); // Eksekusi querynya
    $exist = 0;
    $price = 0;
    $id_supplier_goods = 0;
    $name = "";
    if($query->rowCount() > 0){
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $exist =  1;
        $price = $data['price'];
        $name = $data['name'];
        $id_supplier_goods = $data['id_supplier_goods'];
    }
    $callback = array('exist'=>$exist, 'id_supplier_goods'=>$id_supplier_goods, 'name'=>$name, 'price'=>$price); 
    echo json_encode($callback);
?>
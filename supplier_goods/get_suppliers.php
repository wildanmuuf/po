<?php
    include('../fungsi/connection.php');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $sql = "SELECT sg.id_supplier_goods, g.name as goods, s.name as supplier, sg.price, g.price_estimate, g.stock 
            FROM tb_supplier_goods sg
            JOIN tb_goods g ON g.id_goods=sg.id_goods
            JOIN tb_suppliers s ON s.id_supplier=sg.id_supplier";
        if($searchValue != ""){
            $sql.= " WHERE g.name LIKE concat('%', :search, '%') or s.name LIKE concat('%', :search, '%') ORDER BY g.name";
            $query=$dbcon->prepare($sql);
            $query->bindParam("search", $searchValue, PDO::PARAM_STR);
            $query->execute();
        }else{
            $sql.=" ORDER BY g.name";
            $query=$dbcon->prepare($sql);
            $query->execute();
        }
        
        $totalData = $query->rowCount();
        $sql.=" LIMIT ".$requestData['start'].",".$requestData['length'];
        $query=$dbcon->prepare($sql);
        $query->bindParam("search", $searchValue, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        $count = $query->rowCount();
        $data = array();
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $no++;
            $arr[] = $no;
            $arr[] = $r['goods'];
            $arr[] = $r['supplier'];
            $arr[] = "Rp " . number_format($r['price'], 0, ',', '.');
            $arr[] = "Rp " . number_format($r['price_estimate'], 0, ',', '.');
            $arr[] = '<center><a href="index.php?m=supplier_goods&s=edit&idsg='.$r['id_supplier_goods'].'"><i class="fa fa-edit fa-2x"></i></a> | <a href="index.php?m=supplier_goods&s=hapus&idsg='.$r['id_supplier_goods'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
            $data[] = $arr;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),  
            "recordsTotal"    => intval( $count ), 
            "recordsFiltered" => intval( $totalData ),
            "data"            => $data );
        echo json_encode($json_data);
        $json_data=array();
       
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
?>
   
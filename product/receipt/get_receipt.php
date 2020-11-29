<?php
    include('../../fungsi/connection.php');
    try{
        $requestData = $_REQUEST;
        $id_product = $_POST['id_product'];
        $searchValue = $requestData['search']['value'];
        $limit = $requestData['start'];
        $offset = $requestData['length'];
        $sql = "SELECT rp.id_receipt, rp.quantity, rp.cost, g.name as goods, u.name as unit FROM tb_receipt as rp
            JOIN tb_goods as g ON g.id_goods = rp.id_goods
            JOIN tb_unit as u ON u.id_unit = g.id_unit
            WHERE rp.id_product=:id_product";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and (g.name LIKE :goods or u.name LIKE :unit)";
            $searchArray = array( 
                'goods'=>"%$searchValue%", 
                'unit'=>"%$searchValue%"
           );
        }
        $query=$dbcon->prepare($sql);
        $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery;
        $query=$dbcon->prepare($sqlFilter);
        $query->bindParam("id_product", $id_product, PDO::PARAM_STR);

        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        $query->execute();
        $totalData = $query->rowCount();
        $sqlFetch = $sql.$searchQuery." ORDER BY g.name LIMIT :limit, :offset";
        $query=$dbcon->prepare($sqlFetch);
        $query->bindParam("id_product", $id_product, PDO::PARAM_STR);
        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        
        $query->bindParam("limit", $limit, PDO::PARAM_INT);
        $query->bindParam("offset", $offset, PDO::PARAM_INT);
        $query->execute();
        $data = array();
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $no++;
            $arr[] = $no;
            $arr[] = $r['goods'];
            $arr[] = $r['quantity'].' '.$r['unit'];
            $arr[] = "Rp " . number_format($r['cost'], 0, ',', '.');
            $arr[] = '<center> &nbsp; <a href="index.php?m=product&s=receipt&idp='.$id_product.'&p=edit&idrp='.$r['id_receipt'].'"><i class="fa fa-edit fa-2x"></i></a> &nbsp; <a href="index.php?m=product&s=hapus&idp='.$r['id_receipt'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
        print_r($ex);
        echo $ex->getMessage();
    }
?>
   
<?php
    include('../fungsi/connection.php');
    setlocale (LC_TIME, 'id_ID');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $id_supplier = $_POST['id_supplier'];
        $trx_date = isset($_POST['trx_date']) ? date('Y-m-d', strtotime(strtr($_POST['trx_date'], '/', '-'))) : "";
        $limit = $requestData['start'];
        $offset = $requestData['length'];
        $sqlGroup = "";
        $sql = "SELECT pr.id_purchase_requition, g.name as goods, eg.quantity_receive, eg.price_update, eg.last_price, eg.info, date(eg.created) as date_receive,
            u.name as unit, s.name as supplier
            FROM tb_purchase_requition pr
            JOIN tb_detail_pr_item dpr ON pr.id_purchase_requition = dpr.id_purchase_requition
            JOIN tb_goods g ON dpr.id_goods = g.id_goods
            JOIN tb_entry_goods eg ON dpr.id_detail_pr_item = eg.id_detail_pr_item
            JOIN tb_suppliers s ON s.id_supplier = dpr.id_supplier
            JOIN tb_unit u ON u.id_unit = g.id_unit
            WHERE 1=1";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and pr.id_purchase_requition LIKE :code";
            $searchArray = array( 
                'code'=>"%$searchValue%"
           );
        }

        $supplierQuery = "";
        if($id_supplier != ""){
            $supplierQuery = " and s.id_supplier=:id_supplier";
        }

        $trxDateQuery = "";
        if($trx_date != ""){
            $trxDateQuery = " and date(eg.created) = date(:trx_date)";
        }

        
        $query=$dbcon->prepare($sql.$sqlGroup);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery.$supplierQuery.$trxDateQuery;
        $query=$dbcon->prepare($sqlFilter);
        if($id_supplier != "" ){
            $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        }

        if($trx_date != "" ){
            $query->bindParam("trx_date", $trx_date, PDO::PARAM_STR);
        }

        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        $query->execute();
        $totalData = $query->rowCount();
        
        $offsetQuery = "";
        if($offset > 0){
            $offsetQuery = "LIMIT :limit, :offset";
        }
        $sqlFetch = $sql.$searchQuery.$supplierQuery.$trxDateQuery.$sqlGroup." ORDER BY  pr.trx_date ".$offsetQuery;
        $query=$dbcon->prepare($sqlFetch);

        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        if($id_supplier != "" ){
            $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        }

        if($trx_date != "" ){
            $query->bindParam("trx_date", $trx_date, PDO::PARAM_STR);
        }

        if($offset > 0){
            $query->bindParam("limit", $limit, PDO::PARAM_INT);
            $query->bindParam("offset", $offset, PDO::PARAM_INT);
        }
        $query->execute();
        $data = array();
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $arr[] = $r['id_purchase_requition'];
            $arr[] = $r['date_receive'];
            $arr[] = $r['goods'];
            $arr[] = $r['quantity_receive'];
            $arr[] = $r['unit'];
            $arr[] = $r['supplier'];
            $arr[] = "Rp " . number_format($r['price_update'], 0, ',', '.');
            $arr[] = $r['info'];
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
        // echo $ex->getMessage();
        print_r($ex);
    }
?>
   
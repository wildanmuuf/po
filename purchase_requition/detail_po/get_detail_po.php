<?php
    include('../../fungsi/connection.php');
    setlocale (LC_TIME, 'id_ID');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $id_supplier = $_POST['id_supplier'];
        $idpr = $_POST['idpr'];
        $limit = $requestData['start'];
        $offset = $requestData['length'];
        $sqlGroup = "";
        $sql = "SELECT dpr.*, g.id_goods, g.name as goods, g.quantity_unit, g.stock,
         CASE WHEN g.fixed_price > 0 THEN g.fixed_price
            ELSE g.price_estimate
            END price, s.name as supplier, u.name as unit
         FROM tb_purchase_requition pr
         JOIN tb_detail_pr_item dpr ON dpr.id_purchase_requition = pr.id_purchase_requition
         JOIN tb_goods g ON g.id_goods=dpr.id_goods
         JOIN tb_suppliers s ON s.id_supplier=dpr.id_supplier
         JOIN tb_unit u ON u.id_unit=g.id_unit
        WHERE pr.id_purchase_requition=:idpr";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and s.name LIKE :supplier";
            $searchArray = array( 
                'supplier'=>"%$searchValue%"
           );
        }

        $supplierQuery = "";
        if($id_supplier != ""){
            $supplierQuery = " and s.id_supplier=:id_supplier";
        }

        
        $query=$dbcon->prepare($sql.$sqlGroup);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery.$supplierQuery;
        $query=$dbcon->prepare($sqlFilter);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);
        if($id_supplier != "" ){
            $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
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
        $sqlFetch = $sql.$searchQuery.$supplierQuery.$sqlGroup." ORDER BY  dpr.id_supplier ".$offsetQuery;
        $query=$dbcon->prepare($sqlFetch);
        $query->bindParam("idpr", $idpr, PDO::PARAM_STR);

        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        if($id_supplier != "" ){
            $query->bindParam("id_supplier", $id_supplier, PDO::PARAM_STR);
        }
        if($offset > 0){
            $query->bindParam("limit", $limit, PDO::PARAM_INT);
            $query->bindParam("offset", $offset, PDO::PARAM_INT);
        }
        $query->execute();
        $data = array();
        $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Proses Antar", "Proses Verifikasi Barang", "Pembayaran", "Proses Bayar", "Selesai");
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $disabled = 'onclick="return false;"';
            $price = $r['quantity']/$r['quantity_unit']*$r['price'];
            $arr = array();
            $no++;
            $arr[] = $no;
            $arr[] = $r['stock'];
            $arr[] = $r['goods'];
            $arr[] = $r['quantity'];
            $arr[] = $r['unit'];
            $arr[] = $r['supplier'];
            $arr[] = "Rp " . number_format($price, 0, ',', '.');
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
   
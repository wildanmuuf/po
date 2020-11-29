<?php
    include('../fungsi/connection.php');
    setlocale (LC_TIME, 'id_ID');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $group = $_POST['group']  == 0 ? "" : $_POST['group'];
        $limit = $requestData['start'];
        $offset = $requestData['length'];
        $status = $_POST['status'];
        $category = $_POST['category'];
        $sqlGroup = "";

        $sql = "SELECT pr.*, r.rolename,
        (SELECT SUM((dpr.quantity/g.quantity_unit)*(CASE WHEN g.fixed_price > 0 THEN g.fixed_price
            ELSE g.price_estimate END)) as total FROM tb_detail_pr_item dpr
        JOIN tb_goods g ON g.id_goods = dpr.id_goods
        WHERE dpr.id_purchase_requition = pr.id_purchase_requition) as total
         FROM tb_purchase_requition pr
         JOIN tb_users u ON u.id_user = pr.created_by
         JOIN tb_roles r ON r.id_role = u.id_role
        WHERE 1=1 ";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and (pr.id_purchase_requition LIKE :purchase_requition)";
            $searchArray = array( 
                'purchase_requition'=>"%$searchValue%"
           );
        }

        $groupQuery = "";
        if($group != ""){
            $groupQuery = " and r.id_role=:group";
        }

        $statusQuery = "";
        if($status != "" ){
            $statusQuery = " and pr.status=:status";
        }

        $categoryQuery = "";
        if($category != "" ){
            $categoryQuery = " and pr.category=:category";
        }
        
        $query=$dbcon->prepare($sql.$sqlGroup);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery.$groupQuery.$statusQuery.$categoryQuery.$sqlGroup;
        $query=$dbcon->prepare($sqlFilter);
        if($group != ""){
            $query->bindParam("group", $group, PDO::PARAM_STR);
        }

        if($status != "" ){
            $query->bindParam("status", $status, PDO::PARAM_STR);
        }

        if($category != "" ){
            $query->bindParam("category", $category, PDO::PARAM_STR);
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
        $sqlFetch = $sql.$searchQuery.$groupQuery.$statusQuery.$categoryQuery.$sqlGroup." ORDER BY  pr.category, date(pr.created) DESC ".$offsetQuery;
        $query=$dbcon->prepare($sqlFetch);
        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        if($group != ""){
            $query->bindParam("group", $group, PDO::PARAM_STR);
        }
        if($status != "" ){
            $query->bindParam("status", $status, PDO::PARAM_STR);
        }
        if($category != "" ){
            $query->bindParam("category", $category, PDO::PARAM_STR);
        }
        if($offset > 0){
            $query->bindParam("limit", $limit, PDO::PARAM_INT);
            $query->bindParam("offset", $offset, PDO::PARAM_INT);
        }
        $query->execute();
        $data = array();
        $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Proses Antar", "Proses Verifikasi Barang", "Pembayaran", "Proses Bayar", "Selesai");
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $disabled = 'onclick="return false;"';
            $arr = array();
            $arr[] = $r['id_purchase_requition'];
            $arr[] = $r['category'] == 1 ? "PO 1 : Beli" : "PO 2 : PO";
            $arr[] = $r['trx_date'];
            $arr[] = $r['category'] == 2 ? $r['due_date'] : "<i>NULL</i>";
            $arr[] = $r['rolename'];
            $arr[] = "Rp " . number_format($r['total'], 0, ',', '.');
            $arr[] = $arr_status[$r['status']];
            
            $disabled_link = $r['status'] == 1 ? "" : $disabled;
            $arr[] = '<center><a '.$disabled_link.' href="index.php?m=purchase_requition&idpr='.$r['id_purchase_requition'].'"><i class="fas fa-receipt fa-2x"></i></a> | <a '.$disabled_link.' href="index.php?m=purchase_requition&s=input_po&idpr='.$r['id_purchase_requition'].'"><i class="fa fa-edit fa-2x"></i></a> | <a '.$disabled_link.' href="index.php?m=purchase_requition&s=hapus&idpr='.$r['id_purchase_requition'].'" onclick="return confirm(\'Yakin akan dibatalkan?\')"><i class="fa fa-times-circle-o fa-2x"></i></a><center>';
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
   
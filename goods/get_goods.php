<?php
    include('../fungsi/connection.php');
    setlocale (LC_TIME, 'id_ID');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $aktif = $_POST['aktif'];
        $group = $_POST['group']  == 0 ? "" : $_POST['group'];
        $limit = $requestData['start'];
        $offset = $requestData['length'];

        $sql = "SELECT g.*, un.name as unit FROM tb_goods g
            JOIN tb_roles r ON g.id_role=r.id_role
            JOIN tb_unit un ON un.id_unit=g.id_unit
            where g.active=:aktif";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and (g.name LIKE :goods or un.name LIKE :unit)";
            $searchArray = array( 
                'goods'=>"%$searchValue%", 
                'unit'=>"%$searchValue%"
           );
        }

        $groupQuery = "";
        if($group != ""){
            $groupQuery = " and r.id_role=:group";
        }
        $query=$dbcon->prepare($sql);
        $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery.$groupQuery;
        $query=$dbcon->prepare($sqlFilter);
        if($group != ""){
            $query->bindParam("group", $group, PDO::PARAM_STR);
        }
        $query->bindParam("aktif", $aktif, PDO::PARAM_STR);

        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
        $query->execute();
        $totalData = $query->rowCount();
        
        $offsetQuery = "";
        if($offset > 0){
            $offsetQuery = "LIMIT :limit, :offset";
        }
        $sqlFetch = $sql.$searchQuery.$groupQuery." ORDER BY g.name ".$offsetQuery;
        $query=$dbcon->prepare($sqlFetch);
        if($group != ""){
            $query->bindParam("group", $group, PDO::PARAM_STR);
        }
        $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
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
            $no++;
            $arr[] = ($limit++)+1;
            $arr[] = $r['name'];
            $arr[] = $r['quantity_unit'];
            $arr[] = $r['unit'];
            $arr[] = "Rp " . number_format($r['price_estimate'], 0, ',', '.');
            $arr[] = $r['stock'];
            $arr[] = "Rp " . number_format($r['fixed_price'], 0, ',', '.');
            $arr[] = $r['active'] == "Y" ? "Aktif" : "Tidak Aktif";
            $arr[] = '<center><a href="index.php?m=goods&s=receipt&idpg='.$r['id_goods'].'"><i class="fas fa-receipt fa-2x"></i></a> | <a href="index.php?m=goods&s=edit&idg='.$r['id_goods'].'"><i class="fa fa-edit fa-2x"></i></a> | <a href="index.php?m=goods&s=hapus&idg='.$r['id_goods'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
   
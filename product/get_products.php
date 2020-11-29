<?php
    include('../fungsi/connection.php');
    try{
        $requestData = $_REQUEST;
        $searchValue = $requestData['search']['value'];
        $limit = $requestData['start'];
        $offset = $requestData['length'];
        $category = $_POST['category']  == 0 ? "" : $_POST['category'];
        $aktif = $_POST['aktif'];
        
        $sql = "SELECT p.*, c.category_name FROM tb_product as p
            JOIN tb_category as c ON c.id_category = p.id_category
            where 1=1";
        $searchArray = array();
        $searchQuery = "";
        if($searchValue != ""){
            $searchQuery= " and (p.product_name LIKE :product or c.category_name LIKE :category)";
            $searchArray = array( 
                'product'=>"%$searchValue%", 
                'category'=>"%$searchValue%"
            );
        }

        $categoryQuery = "";
        if($category != ""){
            $categoryQuery = " and c.id_category=:category";
        }
        
        $aktifQuery = "";
        if($aktif != ""){
            $aktifQuery = " and p.active=:aktif";
        }

        $query=$dbcon->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        
        $sqlFilter = $sql.$searchQuery.$categoryQuery.$aktifQuery;
        $query=$dbcon->prepare($sqlFilter);
        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }

        if($aktifQuery != ""){
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
        }
        if($category != ""){
            $query->bindParam("category", $category, PDO::PARAM_STR);
        }
        $query->execute();
        $totalData = $query->rowCount();
        $sqlFetch = $sql.$searchQuery.$categoryQuery.$aktifQuery." ORDER BY c.category_name LIMIT :limit, :offset";
        $query=$dbcon->prepare($sqlFetch);
        foreach($searchArray as $key=>$search){
            $query->bindParam(''.$key, $search, PDO::PARAM_STR);
        }
         if($aktifQuery != ""){
            $query->bindParam("aktif", $aktif, PDO::PARAM_STR);
        }
        if($category != ""){
            $query->bindParam("category", $category, PDO::PARAM_STR);
        }
        $query->bindParam("limit", $limit, PDO::PARAM_INT);
        $query->bindParam("offset", $offset, PDO::PARAM_INT);
        $query->execute();
        $data = array();
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $no++;
            $arr[] = ($limit++)+1;
            $arr[] = $r['product_name'];
            $arr[] = $r['category_name'];
            $arr[] = $r['group_product'] == "1" ? "Produk Buatan/Masakan" : "Produk Jadi";
            $arr[] = "Rp " . number_format($r['price'], 0, ',', '.');
            $arr[] = "Rp " . number_format($r['total_cost'], 0, ',', '.');
            $arr[] = $r['active'] == "Y" ? "Aktif" : "Tidak Aktif";
            $link = $r['group_product'] == "1" 
                ? '<a href="index.php?m=product&s=receipt&idp='.$r['id_product'].'"><i class="fas fa-receipt fa-2x"></i></a>' 
                : '';
            $arr[] = '<center>'.$link.' &nbsp; <a href="index.php?m=product&s=edit&idp='.$r['id_product'].'"><i class="fa fa-edit fa-2x"></i></a> &nbsp; <a href="index.php?m=product&s=hapus&idp='.$r['id_product'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
   
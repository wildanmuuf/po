<?php
    include('../fungsi/connection.php');
    try{
        $requestData = $_REQUEST;
        $output = '';
        $aktif = $_POST['aktif'];
        if(!empty($aktif)){
            $clause = " and active='$aktif'";
        }else{
            $clause = "";
        }

        $sql = "SELECT*FROM tb_category 
            where 1=1 $clause ORDER BY category_name";
        $query=$dbcon->prepare($sql);
        $query->execute();
        $totalData = $query->rowCount();

        $sql.=" LIMIT ".$requestData['start'].",".$requestData['length'];
        $query=$dbcon->prepare($sql);
        $query->execute();
        $data = array();
        $count = $query->rowCount();
        $data = array();
        $no = 0;
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $arr = array();
            $no++;
            $arr[] = $no;
            $arr[] = $r['category_name'];
            $arr[] = $r['group_category'] == 1 ? "Makanan" : "Minuman";
            $arr[] = $r['created'];
            $arr[] = $r['last_modified'];
            $arr[] = $r['active'] == "Y" ? "Aktif" : "Tidak Aktif";
            $arr[] = '<center><a href="index.php?m=category&s=edit&idc='.$r['id_category'].'"><i class="fa fa-edit fa-2x"></i></a> | <a href="index.php?m=category&s=hapus&idc='.$r['id_category'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
   
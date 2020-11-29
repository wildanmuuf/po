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

        $sql = "SELECT*FROM tb_unit
            where 1=1 $clause ORDER BY name";
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
            $arr[] = $r['name'];
            $arr[] = $r['active'] == "Y" ? "Aktif" : "Tidak Aktif";
            $arr[] = '<center><a href="index.php?m=unit&s=edit&ids='.$r['id_unit'].'"><i class="fa fa-edit fa-2x"></i></a> | <a href="index.php?m=unit&s=hapus&ids='.$r['id_unit'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
   
<?php
    include('../fungsi/connection.php');
    try{
        $requestData = $_REQUEST;
        $output = '';
        $aktif = $_POST['aktif'];
        if(!empty($aktif)){
            $clause = " and u.status='$aktif'";
        }else{
            $clause = "";
        }

        $sql = "SELECT u.*, r.rolename FROM tb_users u
        JOIN tb_roles r ON u.id_role= r.id_role
            where 1=1 $clause ORDER BY u.username";
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
            $arr[] = $r['username'];
            $arr[] = $r['rolename'];
            $arr[] = $r['created'];
            $arr[] = $r['last_modified'];
            $arr[] = $r['status'] == "Y" ? "Aktif" : "Tidak Aktif";
            $arr[] = '<center><a href="index.php?m=users&s=edit&idu='.$r['id_user'].'"><i class="fa fa-edit fa-2x"></i></a> | <a href="index.php?m=users&s=hapus&idu='.$r['id_user'].'" onclick="return confirm(\'Yakin akan dinonaktifkan?\')"><i class="fa fa-trash fa-2x"></i></a><center>';
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
   
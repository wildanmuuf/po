<?php
    try{
        include('../../fungsi/connection.php');
        $arr_selected = isset($_POST['selected']) ? $_POST['selected'] : array();
        $selectedQuery = "";
        $in_params = array();
        if(count($arr_selected) > 0){
            $in = "";
            $i = 0;
            foreach($arr_selected as $key => $val){
                $key = ":id_goods".$key;
                $in .= "$key,";
                $in_params[$key] = $val;
            }
            $in = rtrim($in,",");
            $selectedQuery = " and id_goods NOT IN ($in)";
        }

        $sql = "SELECT *
            FROM tb_goods 
            WHERE active='Y'".$selectedQuery;
        $query = $dbcon->prepare($sql);
        foreach($in_params as $key => $val){
            $query->bindParam(''.$key, $in_params[$key], PDO::PARAM_INT);
        }
        $query->execute();
        $output = '<option value="">Pilih Barang</option>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $output .= '<option value="'.$row['id_goods'].'">'.$row['name'].'</option>';
        }
        echo $output;
    }catch(PDOException $ex){
        exit($ex->getMessage());
    }

?>
<?php
    try{
        include('../../fungsi/connection.php');
        
        $sql = "SELECT * FROM tb_suppliers WHERE active='Y'";
        $query = $dbcon->prepare($sql);
        $query->execute();
        $output = '<option value="">Pilih Suplier</option>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $output .= '<option value="'.$row['id_supplier'].'">'.$row['name'].'</option>';
        }
        echo $output;
    }catch(PDOException $ex){
        exit($ex->getMessage());
    }

?>
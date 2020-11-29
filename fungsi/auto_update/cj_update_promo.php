<?php
include("../connection.php");
try{
    $today = date('Y-m-d H:i');
    $sql = "UPDATE tb_promo SET status='Y' WHERE end_date='$today'";
    $query = $dbcon->prepare($sql);
    $query->execute();
}catch(PDOException $ex){
    print_r($ex->getMessage());
}

?>
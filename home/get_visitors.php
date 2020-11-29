<?php
    include('../fungsi/connection.php');
    try{
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $sql = "SELECT date_visit, (SELECT count(hits) FROM tb_visitor WHERE date_visit=d.date_visit) as total FROM tb_visitor d
        WHERE date(d.date_visit) BETWEEN date(:start_date) and date(:end_date) group by d.date_visit";
        $query=$dbcon->prepare($sql);
        $query->bindParam("start_date", $start_date, PDO::PARAM_STR);
        $query->bindParam("end_date", $end_date, PDO::PARAM_STR);
        $query->execute();
        $arr_date_visit = array();
        $arr_total = array();
        while($result = $query->fetch(PDO::FETCH_ASSOC)){
            $arr_date_visit[] = $result['date_visit'];
            $arr_total[] = $result['total'];
            $data['date_visit'] = $arr_date_visit;
            $data['total'] = $arr_total;
        }
        echo json_encode(
            array('date_visit' => $arr_date_visit, 'total' => $arr_total));
       
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
?>
   
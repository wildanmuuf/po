<?php
    function insertVisitor($dbcon, $ip){
        try{
            $today = date('Y-m-d');
            $time   = time();
            $sql_cek = "SELECT id_visitor FROM tb_visitor WHERE ip='$ip' AND date_visit = '$today'";
            $query = $dbcon->prepare($sql);
            $query->execute();
            if($query->rowCount() > 0){
                $sql = "UPDATE tb_visitor SET hits=hits+1, online_time='$time' WHERE ip='$ip' AND date(date_visit) = date(now())";
            }else{
                $sql = "INSERT INTO tb_visitor values (null, '$ip', date(now()), '1', '$time')";
            }
            $query = null;
            $query = $dbcon->prepare($sql);
            $query->execute();
        }catch(PDOException $ex){
            exit();
        }
    }

    function readVisitors($dbcon){
        try{
            $today = date('Y-m-d');
            $time   = time();
            $sql_today = "SELECT count(id_visitor) as today_visitors, 
                (SELECT COUNT(id_visitor) FROM tb_visitor WHERE date(date_visit) = date(NOW() - INTERVAL 1 DAY)) as yesterday_visitors FROM tb_visitor WHERE date(date_visit) = date(now()) group by ip";
            $query = $dbcon->prepare($sql_today);
            $query->execute();
            $row_visitors = $query->fetch(PDO::FETCH_ASSOC);
            $today_visitors = $row_visitors['today_visitors'] > 0 ? $row_visitors['today_visitors'] : 0;
            $yesterday_visitors = $row_visitors['yesterday_visitors'] > 0 ? $row_visitors['yesterday_visitors'] : 0;
            $query = null;

            $sql_total_visitor = "SELECT count(hits) as total, 
                (SELECT count(hits) FROM tb_visitor WHERE MONTH(date_visit) = MONTH(CURDATE())) as total_cur_month, 
                (SELECT count(hits) FROM tb_visitor WHERE MONTH(date_visit) = MONTH(CURDATE() - INTERVAL 1 MONTH)) as total_last_month 
                FROM tb_visitor";
            $query = $dbcon->prepare($sql_total_visitor);
            $query->execute();
            $row_total_visitor = $query->fetch(PDO::FETCH_ASSOC);
            $total_visitor = $row_total_visitor['total'] > 0 ? $row_total_visitor['total'] : 0;
            $total_last_month = $row_total_visitor['total_last_month'] > 0 ? $row_total_visitor['total_last_month'] : 0;
            $total_cur_month = $row_total_visitor['total_cur_month'] > 0 ? $row_total_visitor['total_cur_month'] : 0;
            $query = null;

            $limit_time = time() - 600;
            $sql_online = "SELECT id_visitor FROM tb_visitor WHERE date_visit = '$today' and online_time > $limit_time";
            $query = $dbcon->prepare($sql_online);
            $query->execute();
            $count_online_today = $query->rowCount();
            $query = null;

            $arr = array("today_visitors" => $today_visitors, 
                "yesterday_visitors" => $yesterday_visitors, 
                "total_visitors" => $total_visitor,
                "total_last_month" => $total_last_month,
                "total_cur_month" => $total_cur_month,
                "online_visitors" => $count_online_today);
            return $arr;
        }catch(PDOException $ex){
            exit();
        }
    }
?>
  
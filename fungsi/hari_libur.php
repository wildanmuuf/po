<?php
    date_default_timezone_set("Asia/Jakarta");
    $data_libur = json_decode(file_get_contents("libur_nasional/calendar.json"),true);
    $array = array();
    foreach($data_libur as $key => $value){
        $date = date("Y-m-d", strtotime($key));
        array_push($array, $date);
    }
    array_pop($array);
    echo json_encode($array);
?>
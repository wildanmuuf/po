<?php
    date_default_timezone_set("Asia/Jakarta");
    $date_str = $_POST['date'];
    $date = date('Ymd', strtotime($date_str));
    $data_libur = json_decode(file_get_contents("libur_nasional/calendar.json"),true);
    
    echo json_encode($data_libur);
?>
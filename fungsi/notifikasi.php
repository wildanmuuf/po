<?php
    function send_notifikasi($id_menu_notifikasi, $id_pegawai_sender, $id_pegawai_reciever, $url, $dbcon, $message){
        $sql_notif = "INSERT INTO tb_notifikasi VALUES 
        (null, null, :message, 1, :url, :id_pegawai_reciever , :id_pegawai_sender, :id_menu_notifikasi)";
        $query_notif = $dbcon->prepare($sql_notif);
        $query_notif->bindParam("message", $message, PDO::PARAM_STR);
        $query_notif->bindParam("url", $url, PDO::PARAM_STR);
        $query_notif->bindParam("id_menu_notifikasi", $id_menu_notifikasi, PDO::PARAM_STR);
        $query_notif->bindParam("id_pegawai_reciever", $id_pegawai_reciever, PDO::PARAM_STR);
        $query_notif->bindParam("id_pegawai_sender", $id_pegawai_sender, PDO::PARAM_STR);
        $query_notif->execute();
        $lastInsertId = $dbcon->lastInsertId();
        return $lastInsertId;
    }
?>
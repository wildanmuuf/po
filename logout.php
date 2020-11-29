<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['id_user']);
    unset($_SESSION['id_pegawai']);
    echo "<script>window.location='login.php'</script>";
?>

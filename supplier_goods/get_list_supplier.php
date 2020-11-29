<?php
    include('../fungsi/connection.php');
    $id_goods = $_POST['id_goods'];
    $sql = "SELECT s.id_supplier, s.name FROM tb_supplier_goods sg
    JOIN tb_supplier s ON s.id_supplier=sg.id_supplier
    WHERE sg.id_goods=:id_goods and s.active='Y'";
    $query = $dbcon->prepare($sql);
    $query->bindParam("id_goods", $id_goods, PDO::PARAM_STR);
    $query->execute(); // Eksekusi querynya
    if($query->rowCount() > 0){
        $html = '<option value="" disabled selected>Pilih Barang</option>';
        while($data = $query->fetch(PDO::FETCH_ASSOC)){ // Ambil semua data dari hasil eksekusi $sql
            $html .= "<option value='".$data['id_supplier']."'>".$data['name']."</option>"; // Tambahkan tag option ke variabel $html
        }
        $callback = array('list_goods'=>$html); // Masukan variabel html tadi ke dalam array $callback dengan index array : data_kota
        echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }
?>
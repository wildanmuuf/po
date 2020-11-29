<?php
function TruncateTable($table){
  include "../sambungan.php";
  $truncate = "TRUNCATE $table";
  $qry_truncate = mysqli_query($koneksi,$truncate);
}
?>

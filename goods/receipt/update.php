<?php
if(isset($_POST['simpan'])){
	try{
		$id = $_POST['idj'];
		$jabatan =$_POST['jabatan'];
		$jobdesc =$_POST['jobdesc'];
		$id_role =$_POST['id_role'];
		$aktif = !empty($_POST['aktif']) ? "Y" : "T";
		$id_devisi =$_POST['id_devisi'];
		$today = date('Y-m-d');
		$sql="SELECT*FROM tb_jabatan where id_jabatan='$id' LIMIT 1";
		$query = $dbcon->prepare($sql);
		$query->execute();
		$r = $query->fetch(PDO::FETCH_ASSOC);
		$jobdesc_awal = $r['jobdesc'];

		$sql = "INSERT INTO tb_riwayat_jobdesc VALUES (null, :jobdesc_awal, :jobdesc_akhir, :tgl_update, :id_jabatan)";
		$query = $dbcon->prepare($sql);
		$query->bindParam("jobdesc_awal", $jobdesc_awal, PDO::PARAM_STR);
		$query->bindParam("jobdesc_akhir", $jobdesc, PDO::PARAM_STR);
		$query->bindParam("tgl_update", $today, PDO::PARAM_STR);
		$query->bindParam("id_jabatan", $id, PDO::PARAM_STR);
		$query->execute();

		$sql="UPDATE tb_jabatan SET jabatan=:jabatan, id_role=:id_role, jobdesc=:jobdesc, aktif=:aktif, id_devisi=:id_devisi WHERE id_jabatan=:id";
		$query = $dbcon->prepare($sql);
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->bindParam("jabatan", $jabatan, PDO::PARAM_STR);
		$query->bindParam("id_role", $id_role, PDO::PARAM_STR);
		$query->bindParam("jobdesc", $jobdesc, PDO::PARAM_STR);
		$query->bindParam("aktif", $aktif, PDO::PARAM_STR);
		$query->bindParam("id_devisi", $id_devisi, PDO::PARAM_STR);
		$query->execute();

		
		echo "<script type='text/javascript'> document.location = 'index.php?m=jabatan'; </script>";
	}catch(PDOException $ex){
		echo "<script type='text/javascript'>alert('Update Jabatan Error!');</script>";
		print_r($query->errorInfo());
	}
}else{
	echo '<script>window.history.back()</script>';
	//echo "apa nih";
}
?>

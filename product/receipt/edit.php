<?php include "atas.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Jabatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
	<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form Ubah Jabatan</h3>
              </div>
              <!-- /.card-header -->
<?php
  $id=$_GET['idj'];
  $sql="SELECT * FROM tb_jabatan WHERE id_jabatan='$id'";
  $query = $dbcon->prepare($sql);
  $query->execute();
  $r = $query->fetch(PDO::FETCH_ASSOC)
?>
              <!-- form start -->
              <form action="?m=jabatan&s=update" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="card-body">
                  <input type="text" name="idj" class="form-control" value="<?php echo$r['id_jabatan'];?>" hidden/>
                  <div class="form-group">
                  <label for="id_devisi">Divisi</label>
                  <select id="id_devisi" name="id_devisi" class="form-control" required>
                    <option value="" disabled selected>Pilih Divisi</option>
                    <?php 
                      try{
                        $sql1="SELECT * FROM tb_devisi where aktif='Y'";
                        $query1 = $dbcon->prepare($sql1);
                        $query1->execute();
                        while($r1 = $query1->fetch(PDO::FETCH_ASSOC)){
                          if($r['id_devisi'] == $r1['id_devisi']){
                            echo "<option selected value='".$r1['id_devisi']."' >".$r1['devisi']."</option>";
                          }else{
                            echo "<option value='".$r1['id_devisi']."' >".$r1['devisi']."</option>";
                          }
                        }
                        
                      }catch(PDOException $ex){
                        exit($ex->getMessage());
                      }
                    ?>
                  </select>
                </div>
                  <div class="form-group">
                    <label for="Jabatan">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" id="jabatan" value="<?php echo$r['jabatan'];?>" required/>
                  </div>
                  <div class="form-group">
                    <label for="id_role">Hak Akses Sebagai</label>
                    <select id="id_role" name="id_role" class="form-control" required>
                      <option value="" disabled selected>Pilih Hak Akses</option>
                      <?php 
                        try{
                          $sql2="SELECT * FROM tb_roles where aktif='Y' and NOT rolename='Administrator'";
                          $query2 = $dbcon->prepare($sql2);
                          $query2->execute();
                          while($r2 = $query2->fetch(PDO::FETCH_ASSOC)){
                            $selected = $r['id_role'] == $r2['id_role'] ? "selected" : "";
                            echo "<option '.$selected.' value='".$r2['id_role']."' >".$r2['rolename']."</option>";
                          }
                          
                        }catch(PDOException $ex){
                          exit($ex->getMessage());
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="Jabatan">Job Desc</label>
                    <textarea class="textarea" placeholder="Place some text here" name="jobdesc"
                          style="width: 100%; height: 150; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $r['jobdesc'];?></textarea>
                  </div>
                  <div class="form-group">
                    <div class="form-check-inline">
                      <input class="form-check-input" id="aktif" <?php if($r['aktif']=='Y') echo "checked";?> value="Y" name="aktif" type="checkbox">
                      <label for="aktif" class="form-check-label">Aktif</label>
                    </div>
                  </div>
                <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="simpan" class="btn btn-primary float-right">Simpan</button>
                  </div>
              </form>
            </div>
        </div>
      </div>
    </div>
  </section>
    <!-- /.content -->
    <script type="text/javascript">
    	function onlynumber(e){
    		var numChar = (e.which) ? e.which : event.keyCode
    		if(numChar > 31 && (numChar < 48 || numChar > 57))
    		return false;
    	return true;
    	}
    </script>
<?php include "bawah.php"; ?>

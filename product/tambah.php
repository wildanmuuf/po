<div class="x_panel">
	<div class="x_title">
		<h2>Form Produk</h2>
		<ul class="nav navbar-right panel_toolbox">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Settings 1</a>
					<a class="dropdown-item" href="#">Settings 2</a>
				</div>
			</li>
			<li><a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
<?php
$action = "";
if(isset($_GET['s'])){
	$action = $_GET['s'];
}	
$id_product = "";
if($action == "edit"){
	$id_product = $_GET['idp'];
}

if($id_product <> ""){
	$sql = "SELECT product_name, price, active, group_product, id_category FROM tb_product WHERE id_product=$id_product";
	$query = $dbcon->prepare($sql);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);
	$id_kategori = $row['id_category'];
	$group_product = $row['group_product'];
	$produk = $row['product_name'];
	$harga = $row['price'];
	$aktif = $row['active'];
}else{
	$produk = "";
	$aktif = "";
	$harga = 0;
	$group_product = "";
}
?>
		<br />
		<form method="POST" action="?m=product&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
			<div class="form-row">
				<div class="form-group col-md-4 pl-4">
					<label for="produk">Kategori <span class="required">*</span>
					</label>
					<select class="form-control" required name="kategori">
						<option value=''>Pilih Kategori Produk</option>
						<?php
							$sql = "SELECT id_category, category_name FROM tb_category where active='Y' ";
							$query=$dbcon->prepare($sql);
							$query->execute();
							while($row = $query->fetch(PDO::FETCH_ASSOC)){
								$selected = $id_kategori == $row['id_category'] ? "selected" : "";
								echo '<option '.$selected.' value="'.$row['id_category'].'">';
								echo $row['category_name'];
								echo '</option>';
							}
						?>
					</select>
				</div>
				<div class="form-group col-md-4 pl-4">
					<label for="produk">Nama Produk <span class="required">*</span>
					</label>
					<input type="text" id="produk" name="produk" value="<?php echo $produk?>" required="required" class="form-control ">
				</div>
				<div class="form-group col-md-4 pl-4">
					<label for="harga">Harga <span class="required">*</span>
					</label>
					<input type="text" id="harga" name="harga" value="Rp <?php echo $harga?>" required="required" class="form-control ">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4 pl-4">				
					<label for="group_product">Grup Produk <span class="required">*</span>
					</label>
					<select class="form-control" id="group_product" required name="group_product">
						<option value=''>Pilih Grup</option>
						<option <?php echo $group_product == 1 ? "selected"  : ""?> value='1'>Produk Buatan/Masakan</option>
						<option <?php echo $group_product == 2 ? "selected"  : ""?> value='2'>Produk Jadi</option>
					</select>
					<span style="display: block; font-style: bold; color:red;">* Produk Jadi adalah Produk tanpa diolah</span>
					<span style="display: block; font-style: bold; color:red;">* Produk Buatan/Masakan adalah Produk yang harus diolah terlebih dahulu</span>
				</div>
				<div class="form-group col-md-4 pl-4">				
					<label class="pr-2" for="aktif">Status <span class="required">*</label>
					<div class="pt-3">
						<p>
						Aktif <input type="radio" class="flat" name="aktif" <?php echo $aktif == "Y" ? "checked" : ""; ?> id="aktify" value="Y"  required /> &nbsp;
						Tidak Aktif <input type="radio" class="flat" <?php echo $aktif == "T" ? "checked" : ""; ?> name="aktif" id="aktifx" value="T" />
						</p>
					</div>
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="item form-group">
				<div class="col-md-6 col-sm-6 offset-md-9">
					<button class="btn btn-primary" type="reset">Reset</button>
					<input type="hidden" id="id_product" name="id_product" value="<?php echo $id_product;?>"/>
					<button type="submit" id="save" name="simpan" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>

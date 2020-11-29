<div class="x_panel">
	<div class="x_title">
		<h2>Form Resep Produk <?php echo $product_name?></h2>
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
if(isset($_GET['p'])){
	$action = $_GET['p'];
}
$id_receipt = "";	
if($action == "edit"){
	$id_receipt = $_GET['idrp'];
}
if($id_receipt <> ""){
	$sql = "SELECT r.id_goods, r.quantity, r.cost,
	CASE WHEN g.fixed_price > 0 THEN g.fixed_price
	ELSE g.price_estimate
	END price FROM tb_receipt r
	JOIN tb_goods g ON g.id_goods = r.id_goods
	WHERE r.id_receipt=:id_receipt";
	$query = $dbcon->prepare($sql);
	$query->bindParam("id_receipt",$id_receipt, PDO::PARAM_INT);
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);
	$id_goods = $row['id_goods'];
	$quantity = $row['quantity'];
	$cost = $row['cost'];
	$price = $row['price'];
}else{
	$id_goods = "";
	$quantity = 0;
	$cost = 0;
	$price = 0;
}
?>
		<br />
		<form method="POST" action="?m=product&s=receipt&p=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
			<div class="form-row">
				<div class="form-group col-md-3 pl-4">
					<label  for="id_goods">Bahan Baku <span class="required">*</span>
					</label>
					<select class="form-control" id="id_goods" required name="id_goods">
						<option value=''>Pilih Bahan Baku</option>
						<?php
							$sql = "SELECT g.id_goods, g.name,
							CASE WHEN g.fixed_price > 0 THEN g.fixed_price
							ELSE g.price_estimate
							END price
							, u.name as unit, g.quantity_unit as uquantity FROM tb_goods g 
							JOIN tb_unit u ON g.id_unit = u.id_unit where g.active='Y'";
							if($action != "edit"){
								$sql .= " and 
								g.id_goods NOT IN (SELECT id_goods FROM tb_receipt WHERE id_product=:id_product)";
								$query=$dbcon->prepare($sql);
								$query->bindParam("id_product",$id_product, PDO::PARAM_INT);
								$query->execute();
							}else{
								$query=$dbcon->prepare($sql);
								$query->execute();
							}
							while($row = $query->fetch(PDO::FETCH_ASSOC)){
								$selected = $id_goods == $row['id_goods'] ? "selected" : "";
								echo '<option '.$selected.' data-unit="'.$row['unit'].'" data-price="'.$row['price'].'" data-uquantity="'.$row['uquantity'].'" value="'.$row['id_goods'].'">';
								echo $row['name'];
								echo '</option>';
							}
						?>
					</select>
				</div>
				<div class="form-group col-md-3 pl-4">
					<label  for="quantity">Kuantitas <span class="required">*</span>
					</label>
					<input type="text" id="quantity" name="quantity" value="<?php echo $quantity?>" required="required" class="form-control ">
					<span class="mt-1" id="v-unit" style="display: block; font-size:larger; color:red;">* Satuan Bahan Baku</span>
					<span id="v-unit" style="display: block; color:red;">* Mohon diperhatikan kuantitas yang dimasukkan</span>
				</div>
				<div class="form-group col-md-3 pl-4">
					<label  for="price">Harga Satuan <span class="required">*</span>
					</label>
					<input type="text" readonly id="price" name="price" required="required" value="<?php echo "Rp " . number_format($price, 0, ',', '.'); ?>" class="form-control ">
				</div>
				<div class="form-group col-md-3 pl-4">
					<label  for="cost">Biaya <span class="required">*</span>
					</label>
					<input type="text" readonly id="cost" name="cost" value="<?php echo "Rp " . number_format($cost, 0, ',', '.'); ?>" required="required" class="form-control ">
					<span class="mt-1" style="display: block; color:red;">* Rumus Cost/Biaya (Harga Satuan/Satuan)xKuantitas</span>
				</div>
			</div>
			<div class="ln_solid"></div>
			<div class="item form-group">
				<div class="col-md-6 col-sm-6 offset-md-9">
					<button class="btn btn-primary" type="reset">Reset</button>
					<input type="hidden" id="id_product" name="id_product" value="<?php echo $id_product;?>"/>
					<input type="hidden" id="id_receipt" name="id_receipt" value="<?php echo $id_receipt;?>"/>
					<button type="submit" id="save" name="simpan" class="btn btn-success">Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>

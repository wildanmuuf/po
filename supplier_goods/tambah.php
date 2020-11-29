<div class="x_panel">
						<div class="x_title">
							<h2>Form Suplier</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
              $id_supplier_goods = "";
              if($action == "edit"){
                $id_supplier_goods = $_GET['idsg'];
              }

              if($id_supplier_goods <> ""){
                $sql = "SELECT id_supplier, id_goods, price, active FROM tb_supplier_goods WHERE id_supplier_goods=$id_supplier_goods";
                $query = $dbcon->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $id_supplier = $row['id_supplier'];
                $id_goods = $row['id_goods'];
                $price = $row['price'];
                $aktif = $row['active'];
              }else{
                $id_supplier = "";
				$aktif = "";
				$id_goods = "";
				$price = "";
              }
            ?>
									<br />
									<form method="POST" action="?m=supplier_goods&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="id_goods">Barang <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6">
												<select class="form-control" id="id_goods" required name="id_goods">
													<option value=''>Pilih Barang</option>
													<?php
														$sql = "SELECT * FROM tb_goods WHERE active='Y'";
														$query = $dbcon->prepare($sql);
														$query->execute();
														while($row = $query->fetch(PDO::FETCH_ASSOC)){
															$selected = $row['id_goods'] == $id_goods ? "selected" : "";
															echo "<option $selected value='$row[id_goods]' data-price='$row[price_estimate]'>$row[name]</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="id_supplier">Suplier <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6">
												<select class="form-control" id="id_supplier" required name="id_supplier">
													<option value=''>Pilih Suplier</option>
													<?php
														$sql = "SELECT * FROM tb_suppliers WHERE active='Y'";
														$query = $dbcon->prepare($sql);
														$query->execute();
														while($row = $query->fetch(PDO::FETCH_ASSOC)){
															$selected = $row['id_supplier'] == $id_supplier ? "selected" : "";
															echo "<option $selected value='$row[id_supplier]'>$row[name]</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="price">Harga <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="price" name="price" maxlength="17" value="<?php echo $price?>" required="required" class="form-control ">
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-9">
                        <button class="btn btn-primary" type="reset">Reset</button>
												<input type="hidden" id="id_supplier_goods" name="id_supplier_goods" value="<?php echo $id_supplier;?>"/>
												<button type="submit" name="simpan" id="save" class="btn btn-success">Submit</button>
											</div>
										</div>

									</form>
								</div>
					</div>
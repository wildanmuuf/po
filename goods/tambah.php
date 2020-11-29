<div class="x_panel">
						<div class="x_title">
							<h2>Form Bahan Baku</h2>
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
              $id_goods = "";
              if($action == "edit"){
                $id_goods = $_GET['idg'];
              }

              if($id_goods <> ""){
                $sql = "SELECT name, quantity_unit, price_estimate, id_unit, id_role, active FROM tb_goods WHERE id_goods=$id_goods";
                $query = $dbcon->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $goods = $row['name'];
                $price_estimate = $row['price_estimate'];
                $aktif = $row['active'];
                $id_unit = $row['id_unit'];
                $id_role = $row['id_role'];
                $quantity_unit = $row['quantity_unit'];
              }else{
                $goods = "";
				$aktif = "";
				$price_estimate = "";
				$id_unit = "";
				$id_role = "";
				$quantity_unit = 0;
              }
            ?>
									<br />
									<form method="POST" action="?m=goods&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="form-row">
											<div class="form-group col-md-4 pl-4">
												<label  for="goods">Barang <span class="required">*</span>
												</label>
												<input type="text" id="goods" name="goods" value="<?php echo $goods?>" required="required" class="form-control ">
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="price_estimate">Harga Estimasi <span class="required">*</span>
												</label>
												<input type="text" id="price_estimate" name="price_estimate" maxlength="17" value="<?php echo $price_estimate?>" required="required" class="form-control ">
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="unit">Satuan <span class="required">*</span>
												</label>
												<select class="form-control" id="unit" required name="unit">
													<option value=''>Pilih Satuan</option>
													<?php
														$sql = "SELECT * FROM tb_unit WHERE active='Y'";
														$query = $dbcon->prepare($sql);
														$query->execute();
														while($row = $query->fetch(PDO::FETCH_ASSOC)){
															$selected = $row['id_unit'] == $id_unit ? "selected" : "";
															echo "<option $selected value='$row[id_unit]'>$row[name]</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="form-row">
											<div class="form-group col-md-4 pl-4">
												<label  for="quantity">Kuantitas <span class="required">*</span>
												</label>
												<input type="text" onkeypress="return onlynumber(this)" id="quantity" name="quantity" value="<?php echo $quantity_unit?>" required="required" class="form-control ">
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="id_group">Group <span class="required">*</span>
												</label>
												<select class="form-control" id="id_group" required name="id_group">
													<option value=''>Pilih Group</option>
													<?php
														$sql = "SELECT * FROM tb_roles WHERE active='Y'";
														$query = $dbcon->prepare($sql);
														$query->execute();
														while($row = $query->fetch(PDO::FETCH_ASSOC)){
															$selected = $row['id_role'] == $id_role ? "selected" : "";
															echo "<option $selected value='$row[id_role]'>$row[rolename]</option>";
														}
													?>
												</select>
											</div>
											<div class="form-group col-md-4 pl-4">
												<label >Status <span class="required">*</label>
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
												<input type="hidden" id="id_goods" name="id_goods" value="<?php echo $id_goods;?>"/>
												<button type="submit" name="simpan" class="btn btn-success">Submit</button>
											</div>
										</div>

									</form>
								</div>
					</div>

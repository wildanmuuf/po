<div class="x_panel">
						<div class="x_title">
							<h2>Form Kategori</h2>
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
              $id_category = "";
              if($action == "edit"){
                $id_category = $_GET['idc'];
              }

              if($id_category <> ""){
                $sql = "SELECT category_name, active FROM tb_category WHERE id_category=$id_category";
                $query = $dbcon->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $kategori = $row['category_name'];
                $aktif = $row['active'];
              }else{
                $kategori = "";
                $aktif = "";
              }
            ?>
									<br />
									<form method="POST" action="?m=category&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kategori <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="kategori" name="kategori" value="<?php echo $kategori?>" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="produk">Kategori <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6">
												<select class="form-control" required name="grup_kategori">
													<option value=''>Pilih Group Kategori</option>
													<option value='1'>Makanan</option>
													<option value='2'>Minuman</option>
												</select>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Status <span class="required">*</label>
											<div class="form-inline col-md-6 col-sm-6 mt-2">
												<div class="form-check">
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
												<input type="hidden" id="id_category" name="id_category" value="<?php echo $id_category;?>"/>
												<button type="submit" name="simpan" class="btn btn-success">Submit</button>
											</div>
										</div>

									</form>
								</div>
					</div>
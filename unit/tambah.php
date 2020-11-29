<div class="x_panel">
						<div class="x_title">
							<h2>Form Satuan</h2>
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
              $id_unit = "";
              if($action == "edit"){
                $id_unit = $_GET['ids'];
              }

              if($id_unit <> ""){
                $sql = "SELECT name, active FROM tb_unit WHERE id_unit=$id_unit";
                $query = $dbcon->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $unit = $row['name'];
				$aktif = $row['active'];
				
              }else{
                $unit = "";
				$aktif = "";
              }
            ?>
									<br />
									<form method="POST" action="?m=unit&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="unit">Satuan <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="unit" name="unit" value="<?php echo $unit?>" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Status <span class="required">*</label>
											<div class="form-inline col-md-6 col-sm-6">
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
												<input type="hidden" id="id_unit" name="id_unit" value="<?php echo $id_unit;?>"/>
												<button type="submit" name="simpan" class="btn btn-success">Submit</button>
											</div>
										</div>

									</form>
								</div>
					</div>
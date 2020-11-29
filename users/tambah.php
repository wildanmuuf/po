<div class="x_panel">
						<div class="x_title">
							<h2>Form Users</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
              $id_user = "";
              if($action == "edit"){
                $id_user = $_GET['idu'];
              }

              if($id_user <> ""){
                $sql = "SELECT username, status, id_role FROM tb_users WHERE id_user=$id_user";
                $query = $dbcon->prepare($sql);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                $username = $row['username'];
                $id_role = $row['id_role'];
				$reqpassword = "";
				$aktif = $row['status'];
				$phpassword = "Kosongkan jika password tidak diganti";
              }else{
                $username = "";
				$aktif = "";
				$reqpassword = "required";
                $id_role = "";
				$password = "";
				$phpassword = "Password";
			}
            ?>
									<br />
									<form method="POST" action="?m=users&s=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Users <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="username" name="username" value="<?php echo $username?>" required="required" class="form-control ">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
        										<input type="password" name="password" <?php echo $reqpassword;?> placeholder="<?php echo $phpassword;?>" class="form-control" id="password"/>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="group_user">Grup Users <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6">
												<select class="form-control" id="group_user" required name="grup_user">
													<option value=''>Pilih Group Users</option>
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
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Status <span class="required">*</label>
											<div class="form-inline col-md-6">
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
												<input type="hidden" id="id_user" name="id_user" value="<?php echo $id_user;?>"/>
												<button type="submit" name="simpan" class="btn btn-success">Submit</button>
											</div>
										</div>

									</form>
								</div>
					</div>
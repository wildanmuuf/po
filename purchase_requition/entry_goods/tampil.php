<?php include("atas.php");?>
<?php
  $idpr = isset($_GET['idpr']) ? $_GET['idpr'] : "";
  $category = "";
  $trx_date = "";
  $total = 0;
  $due_date = "";
  if($idpr != ""){
    $sql = "SELECT category, trx_date, due_date,total FROM tb_purchase_requition WHERE id_purchase_requition = :id";
    $query = $dbcon->prepare($sql);
    $query->bindParam('id', $idpr, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $category = $result['category'];
    $trx_date = date('d/m/Y', strtotime($result['trx_date']));
    $due_date = $result['due_date'];
    $total = $result['total'];
  }
?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Purchase Order</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div id="title" class="x_title">
                    <h2>Form Barang Masuk <b><?php echo $idpr; ?></b> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="collapse-link"><a><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-md-12">
                            <div class="card-box table-responsive">
                              <form method="POST" action="?m=purchase_requition&s=entry_goods&p=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item">
													<input type='hidden' class="form-control" id="id_purchase_requition" name="idpr" value="<?php echo $idpr?>"/>

                      <div class="form-group col-md-4 ">
												<label  for="unit">Kategori PO <span class="required">*</span>
												</label>
												<select class="form-control" disabled id="category" required name="category">
													<option value=''>Pilih Kategori PO</option>
                          <option <?php 
                          echo $category == 1 ? 'selected' : ""; ?> value='1'>PO 1 : Beli</option>
													<option <?php echo $category == 2 ? 'selected' : ""; ?>  value='2'>PO 2 : PO</option>
												</select>
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="purchase_requition">Tanggal Transaksi <span class="required">*</span>
												</label>
                        <div class='input-group date' id='trx_date'>
													<input type='text' class="form-control" disabled value="<?php echo $trx_date;?>" name="trx_date" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="due_date">Tanggal Jatuh Tempo <span class="required">*</span>
                        </label>
                        <div class='input-group date' id='due_date'>
													<input type='text' class="form-control" name="due_date" value="<?php echo $due_date;?>"" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="ln_solid"></div>
                    <div class="row">
                      <div class="col-md-4 align-self-start pl-4 pr-4">
                        <label  for="id_group">Suplier 
                        </label>
                        <select class="form-control" id="filter_supplier">
                          <option value=''>Semua</option>
                          <?php
                            $sql = "SELECT s.* FROM tb_suppliers s
                              JOIN tb_detail_pr_item dpr ON dpr.id_supplier = s.id_supplier 
                              WHERE s.active='Y' and dpr.id_purchase_requition = :idpr
                              GROUP BY s.id_supplier";
                            $query = $dbcon->prepare($sql);
                            $query->bindParam('idpr', $idpr, PDO::PARAM_STR);
                            $query->execute();
                            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                              echo "<option value='$row[id_supplier]'>$row[name]</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th width='200'>Bahan Baku</th>
                          <th width='80'>Diminta</th>
                          <th width='50'>Satuan</th>
                          <th width='150'>Suplier</th>
                          <th width='140'>Diterima</th>
                          <th width='170'>Keterangan</th>
                          <th width='140'>Harga Satuan (Saat Ini)</th>
                          <th width='140'>Harga Satuan (Update)</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="7" style="text-align:right">Total :</th>
                          <th><span id="total"><?php echo "Rp " . number_format($total, 0, ',', '.');;?></span><input type="hidden" id="total_po" name="total_po" value="<?php echo $total;?>"/></th>
                        </tr>
                      </tfoot>
                    </table>
                    <br>
										<div class="ln_solid"></div>
                    <div class="item">
                      <div class="form-group col-md-12 text-right">
                          <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
											</div>
										</div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php include("bawah.php");?>
<script>
  $(document).ready(function() {
    var idpr = $('#id_purchase_requition').val();
    var id_supplier= $("#filter_supplier option:selected").val();
    $('#due_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#trx_date').datetimepicker({
        format: 'DD/MM/YYYY',
        defaultDate : moment()
    });
    $('#due_date').data("DateTimePicker").disable();

    $('#category').change(function(){
      var category = this.value;
      if(category == 2){
        $('#due_date').data("DateTimePicker").enable();
      }else{
        $('#due_date').data("DateTimePicker").disable();
        $('#due_date').data("DateTimePicker").clear();
      }
    });

    $('#filter_supplier').change(function() {
      id_supplier = $(this).val();
      table_categories.destroy();
      initTable(id_supplier, idpr);
    });

    initTable(id_supplier, idpr);
    var table_categories;
    function initTable(id_supplier, idpr){
      table_categories = $("#categories").DataTable({
        "autoWidth": true,
        "responsive": true,
        dom: 'tip',
        "responsive": true,
        "paging": true,
        "processing": true,
        "ordering": false,
        "serverSide": true,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Semua"]],
        "ajax" : {
          url : "purchase_requition/entry_goods/get_entry_goods.php",
          type : "post",
          data:{id_supplier:id_supplier, idpr:idpr}
        }
      });
    }
  });
</script>
        <!-- page content -->

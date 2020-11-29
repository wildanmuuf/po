<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Barang Masuk</h3>
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
                    <h2>Form Barang Masuk</b> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="collapse-link"><a><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
										<div class="item">
                    <div class="form-group col-md-4 pl-4">
												<label  for="purchase_requition">Tanggal Penerimaan <span class="required">*</span>
												</label>
                        <div class='input-group date' id='trx_date'>
													<input type='text' class="form-control" name="trx_date" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
                      <div class="col-md-4 align-self-start pl-4 pr-4">
                        <label  for="id_group">Suplier 
                        </label>
                        <select class="form-control" id="filter_supplier">
                          <option value=''>Semua</option>
                          <?php
                            $sql = "SELECT s.* FROM tb_suppliers s
                              WHERE s.active='Y'";
                            $query = $dbcon->prepare($sql);
                            $query->execute();
                            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                              echo "<option value='$row[id_supplier]'>$row[name]</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                      <div class="row">
                          <div class="col-md-12">
                            <div class="card-box table-responsive">
                    
										<div class="ln_solid"></div>
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th width='150'>Kode PO</th>
                          <th width='80'>Tanggal</th>
                          <th width='100'>Bahan Baku</th>
                          <th width='80'>Qty Diterima</th>
                          <th width='50'>Satuan</th>
                          <th width='150'>Suplier</th>
                          <th width='100'>Harga Satuan (Update)</th>
                          <th width='130'>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                      </tfoot>
                    </table>
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
    $('#trx_date').datetimepicker({
        format: 'DD/MM/YYYY',
        defaultDate : moment()
    });
    var id_supplier= $("#filter_supplier option:selected").val();
    var trx_date= $("#trx_date").data("DateTimePicker").date()._i;
   
    var table_categories;
    $('#filter_supplier').change(function() {
      id_supplier = $(this).val();
      table_categories.destroy();
      initTable(id_supplier, trx_date);
    });

    $('#trx_date').on('dp.change',function(e) {
      trx_date = e.date._i;
      console.log(trx_date);
      table_categories.destroy();
      initTable(id_supplier, trx_date);
    });

    $('#trx_date').datetimepicker({
        format: 'DD/MM/YYYY',
        defaultDate : moment()
    });


    initTable(id_supplier, trx_date);
    function initTable(id_supplier, trx_date){
      table_categories = $("#categories").DataTable({
        "autoWidth": true,
        "responsive": true,
        dom: 'ftip',
        "responsive": true,
        "paging": true,
        "processing": true,
        "ordering": false,
        "serverSide": true,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Semua"]],
        "ajax" : {
          url : "hist_entry_goods/get_hist_entry_goods.php",
          type : "post",
          data:{id_supplier:id_supplier, trx_date:trx_date}
        }
      });
    }
  });
</script>
        <!-- page content -->

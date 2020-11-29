<?php include("atas.php");?>
<?php
  $idpr = isset($_GET['idpr']) ? $_GET['idpr'] : "";
  $category = "";
  $trx_date = "";
  $total = 0;
  $due_date = "";
  $status = "";
  $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Cetak Nota Pengajuan", "Ditransfer", "Proses Beli", "Pembayaran Suplier", "Selesai");
  if($idpr != ""){
    $sql = "SELECT category, trx_date, due_date, status, total FROM tb_purchase_requition WHERE id_purchase_requition = :id";
    $query = $dbcon->prepare($sql);
    $query->bindParam('id', $idpr, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $category = $result['category'];
    $trx_date = date('d/m/Y', strtotime($result['trx_date']));
    $due_date = date('d/m/Y', strtotime($result['due_date']));
    $total = $result['total'];
    $status = $result['status'];
    
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
                    <h2>Detail Purchase Order <b><?php echo $idpr; ?></b></h2>
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
										<div class="item">
													<input type='hidden' class="form-control" id="idpr" name="idpr" value="<?php echo $idpr?>"/>
                      <div class="form-group col-md-3 ">
												<label  for="unit">Kategori PO <span class="required">*</span>
												</label>
												<select class="form-control" id="category" disabled required name="category">
													<option value=''>Pilih Kategori PO</option>
                          <option <?php 
                          echo $category == 1 ? 'selected' : ""; ?> value='1'>PO 1 : Beli</option>
													<option <?php echo $category == 2 ? 'selected' : ""; ?>  value='2'>PO 2 : PO</option>
												</select>
											</div>
											<div class="form-group col-md-3 pl-4">
												<label  for="purchase_requition">Tanggal Transaksi <span class="required">*</span>
												</label>
                        <div class='input-group date' id='trx_date'>
													<input type='text' disabled class="form-control" value="<?php echo $trx_date;?>" name="trx_date" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
											<div class="form-group col-md-3 pl-4">
												<label  for="due_date">Tanggal Jatuh Tempo <span class="required">*</span>
                        </label>
                        <div class='input-group date' id='due_date'>
													<input type='text' disabled class="form-control" name="due_date" value="<?php echo $due_date;?>" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
                      <div class="form-group col-md-3 pl-4">
												<label  for="status">Status <span class="required">*</span>
                        </label>
                        <input type='text' class="form-control" disabled id="status" value="<?php echo $arr_status[$status];?>" required="required"/>
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
                      <?php if($status == 1){?>
                      <div class="col-md-2 pl-4 pt-4 pr-4">
                        <button id="approve" class="btn btn-success btn-block">
                          Setujui
                        </button>
                      </div>
                      <div class="col-md-2 pl-4 pt-4 pr-4">
                        <button id="reject" class="btn btn-danger btn-block">
                          Tolak
                        </button>
                      </div>
                      <div class="col-md-2 pl-4 pt-4 pr-4">
                      </div>
                      <div class="col-md-2 pl-4 pt-4 pr-4">
                        <button id="print_po" class="btn btn-info btn-block">
                          Cetak PO
                        </button>
                      </div>
                      <?php } else if($status == 2){?>
                      <div class="col-md-3 pl-4 pt-4 pr-4">
                        <button data-toggle="modal" data-target="#print_modal" class="btn btn-success btn-block" data-id="<?php echo $idpr;?>">
                          Cetak Nota Transfer
                        </button>
                      </div>
                      <div class="modal fade" id="print_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method="POST" action="?m=purchase_requition&s=detail_po&p=save_account" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="modal-body">
                                <div class="form-group">
													      <input type='hidden' class="form-control" id="id_purchase_requition" name="idpr" value="<?php echo $idpr?>"/>
                                  <label for="method" class="col-form-label">Cara Pembayaran:</label>
                                  <select class="form-control" id="method" name="method">
                                    <option value="1">Cash</option>
                                    <option value="2">Transfer</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="list_account" class="col-form-label">Daftar Rekening :</label>
                                  <select disabled class="form-control" id="list_account" name="cur_account">
                                    <option value="0">Pilih Rekening</option>
                                    <?php
                                      $id_user = $_SESSION['id_user'];
                                      $sql = "SELECT * FROM tb_account WHERE created_by = :id_user";
                                      $query = $dbcon->prepare($sql);
                                      $query->bindParam('id_user', $id_user, PDO::PARAM_INT);
                                      $query->execute();
                                      while($result = $query->fetch(PDO::FETCH_ASSOC)){
                                        echo '<option value="'.$result['id_account'].'">'.$result['behalf'].' | '.$result['account'].'</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="behalf" class="col-form-label">Atas Nama :</label>
                                  <input type="text" disabled class="form-control" name="behalf" id="behalf">
                                </div>
                                
                                <div class="form-group">
                                  <label for="account_bank" class="col-form-label">Nama Bank :</label>
                                  <input type="text" disabled class="form-control" name="account_bank" id="account_bank">
                                </div>
                                <div class="form-group">
                                  <label for="account" class="col-form-label">Rekening :</label>
                                  <input type="text" disabled class="form-control" name="account" id="account">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" name="simpan" class="btn btn-primary">Cetak Nota</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      
                      <?php } else if($status == 4){
                        $sql = "SELECT method FROM tb_payment WHERE id_purchase_requition=:idpr";
                        $query = $dbcon->prepare($sql);
                        $query->bindParam('idpr', $idpr, PDO::PARAM_STR);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_ASSOC);
                        $method_payment = $result['method'];
                        if($method_payment == 1){?>
                          <div class="col-md-2 pl-4 pt-4 pr-4">
                            <button id="buy-proccess" class="btn btn-info btn-block">
                              Proses Beli
                            </button>
                          </div>
                        <?php }else if($method_payment == 2){?>
                        <div class="col-md-3 pl-4 pt-4 pr-4">
                          <button id="transfer" class="btn btn-info btn-block">
                            Ditransfer
                          </button>
                        </div>
                      <?php 
                        }
                          if($category == 2){
                        ?>
                        <div class="col-md-3 pl-4 pt-4 pr-4">
                          <button id="print_po_supplier" class="btn btn-warning btn-block">
                            Cetak PO Suplier
                          </button>
                        </div>
                        <?php } ?>
                      
                      <?php } else if($status == 5){ ?>
                      <div class="col-md-2 pl-4 pt-4 pr-4">
                        <button id="buy-proccess" class="btn btn-info btn-block">
                          Proses Beli
                        </button>
                      </div>
                      <?php } else if($status == 6){ ?>
                      <div class="col-md-3 pl-4 pt-4 pr-4">
                        <button id="entry_goods" class="btn btn-info btn-block">
                          Validasi Barang
                        </button>
                      </div>
                      <?php } else if($status == 7){ ?>
                        <div class="col-md-3 pl-4 pt-4 pr-4">
                          <button id="payment_supplier" class="btn btn-warning btn-block">
                            Pembayaran Supplier
                          </button>
                        </div>
                      <?php } ?>
                    </div>
										<div class="ln_solid"></div>
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th width='10'>No</th>
                          <th width='80'>Stok Saat Ini</th>
                          <th width='200'>Bahan Baku</th>
                          <th width='80'>Qty</th>
                          <th width='50'>Satuan</th>
                          <th width='170'>Suplier</th>
                          <th width='170'>Harga Estimasi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="6" style="text-align:right; color:red;"><b>Total : </b></th>
                          <th style="color:red;"><span id="total"></span><input type="hidden" id="total_po" name="total_po" value="<?php echo $total;?>"/></th>
                        </tr>
                      </tfoot>
                    </table>
                    <br>
										<div class="ln_solid"></div>
                    <div class="item">
                      <div class="form-group col-md-12 text-right">
											</div>
										</div>

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
    var id_supplier= $("#filter_supplier option:selected").val();
    var idpr= $("#idpr").val();
    var total = $('#total_po').val();

    $('#due_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('#trx_date').datetimepicker({
        format: 'DD/MM/YYYY'
    });


    $('#method').change(function() {
      var method = $(this).val();
      if(method == 2){
        $('#list_account').prop('disabled', false);
        $('#behalf').prop('disabled', false);
        $('#account').prop('disabled', false);
        $('#account_bank').prop('disabled', false);
      }else{
        $('#list_account option[value=0]').attr('selected', 'selected');
        $('#behalf').val('');
        $('#account').val('');
        $('#account_bank').val('');

        $('#list_account').prop('disabled', true);
        $('#behalf').prop('disabled', true);
        $('#account').prop('disabled', true);
        $('#account_bank').prop('disabled', true);
      }
    });

    $('#list_account').change(function() {
      var account = $(this).val();
      if(account == 0){
        $('#behalf').prop('disabled', false);
        $('#account').prop('disabled', false);
        $('#account_bank').prop('disabled', false);
      }else{
        $('#behalf').val('');
        $('#account').val('');
        $('#account_bank').val('');

        $('#behalf').prop('disabled', true);
        $('#account').prop('disabled', true);
        $('#account_bank').prop('disabled', true);
      }
    });


    $('#filter_supplier').change(function() {
      id_supplier = $(this).val();
      table_categories.destroy();
      initTable(id_supplier, idpr);
    });

    $('#approve').click(function() {
      verify(2, idpr);
    });

    $('#print_po').click(function() {
      var links ='index.php?m=purchase_requition&s=print_po&idpr='+idpr;
      window.open(links);
    });

    $('#entry_goods').click(function() {
      var links ='index.php?m=purchase_requition&s=entry_goods&idpr='+idpr;
      window.location = links;
    });

    $('#reject').click(function() {
      verify(3, idpr);
    });

    $('#transfer').click(function() {
      verify(5, idpr);
    });

    $('#buy-proccess').click(function() {
      verify(6, idpr);
    });

    $('#payment_supplier').click(function() {
      verify(8, idpr);
    });

    $('#print_po_supplier').click(function() {
      var links ='index.php?m=purchase_requition&s=print_po_supplier&idpr='+idpr;
      if(id_supplier > 0){
        var link = links+'&ids='+id_supplier;
        window.open(link);
      }else{
        $('#filter_supplier option').each(function(){
          var ids = $(this).val();
          if(ids > 0){
            var link = links+'&ids='+ids;
            window.open(link);
          }
        });
      }
      
    });

    function verify(status, idpr){
      $.ajax({
          type : 'POST',
          data : {status:status, idpr:idpr},
          dataType : 'json',
          url  : "purchase_requition/validate.php",
          success : function(data){
            location.reload();
          }                    // pass existing options
      });
    }

    initTable(id_supplier, idpr);
    function initTable(id_supplier, idpr){
      var filename = $("#title").find('h2').text();
      table_categories = $("#categories").DataTable({
          "responsive": true,
          "paging": true,
          "processing": true,
          "ordering": false,
          "serverSide": true,
          "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Semua"]],
          "ajax" : {
            url : "purchase_requition/detail_po/get_detail_po.php",
            type : "post",
            data:{id_supplier:id_supplier, idpr:idpr}
          },
          "oLanguage": {
            "sSearch": "Cari Suplier"
          },
          "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\Rp.]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
  
              // Total over all pages
              // Total over this page
              pageTotal = api
                  .column( 6, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
  
              // Update footer
              $( api.column( 6 ).footer() ).html(
                  '<b>Rp '+formatRupiah(pageTotal.toString()) +
                  ' ( Rp '+ formatRupiah(total.toString()) +' total)</b>'
              );
          },
          dom: "<'row'<'col-md-4'l><'col-md-4'f><'col-md-4 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
          buttons:  [{
                  extend: 'pdfHtml5',
                  title: filename,
                  footer: true,
                  exportOptions: {
                      columns: "thead th:not(.noExport)"
                  }
              },{
                  extend: 'excelHtml5',
                  title: filename,
                  footer: true,
                  exportOptions: {
                      columns: "thead th:not(.noExport)"
                  }
              }, {
                  extend: 'csvHtml5',
                  title: filename,
                  footer: true,
                  exportOptions: {
                      columns: "thead th:not(.noExport)"
                  }
              }
          ]
      });
    }
  
    $('#print_modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('Form Transfer PO ' + id)
    })
  });
</script>
        <!-- page content -->

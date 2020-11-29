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
                    <h2>Form Purchase Order</h2>
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
                              <form method="POST" action="?m=purchase_requition&s=input_po&p=simpan" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item">
													<input type='hidden' class="form-control" id="id_purchase_requition" name="idpr" value="<?php echo $idpr?>"/>

                      <div class="form-group col-md-4 ">
												<label  for="unit">Kategori PO <span class="required">*</span>
												</label>
												<select class="form-control" id="category" required name="category">
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
													<input type='text' class="form-control" value="<?php echo $trx_date;?>" name="trx_date" required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
											<div class="form-group col-md-4 pl-4">
												<label  for="due_date">Tanggal Jatuh Tempo <span class="required">*</span>
                        </label>
                        <div class='input-group date' id='due_date'>
													<input type='text' class="form-control" name="due_date" <?php echo $due_date;?> required="required"/>
													<span class="input-group-addon">
														<span class="fa fa-calendar-alt"></span>
													</span>
												</div>
											</div>
										</div>
										<div class="ln_solid"></div>
                    <table id="table_input" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th width='30'></th>
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
                        <?php
                          $sql = "SELECT dpr.*, g.id_goods, g.quantity_unit, g.stock,
                            CASE WHEN g.fixed_price > 0 THEN g.fixed_price
                            ELSE g.price_estimate
                            END price,
                            u.name as unit FROM tb_detail_pr_item dpr
                            JOIN tb_goods g ON g.id_goods=dpr.id_goods
                            JOIN tb_unit u ON u.id_unit=g.id_unit
                            WHERE dpr.id_purchase_requition = :id";
                          $query = $dbcon->prepare($sql);
                          $query->bindParam('id', $idpr, PDO::PARAM_STR);
                          $query->execute();
                          $counter = 0;
                          while($row = $query->fetch(PDO::FETCH_ASSOC)){
                            $price = $row['quantity']/$row['quantity_unit']*$row['price'];
                            $counter++;
                            echo '<tr>';
                            echo '<td><center><button type="button" id="del_'.$counter.'" class="btn btn-danger btn-sm del-row"><i class="fa fa-times"></i></button></center></td>';
                            echo '<td>'.$counter.'</td>';
                            echo '<td><input name="cur_stock[]" value="'.$row['stock'].'" disabled id="cur_stock_'.$counter.'" class="form-control" placeholder=""></td>';
                            echo '<td><select required name="goods[]" class="form-control goods" id="goods_'.$counter.'" >';
                            $id_goods = $row['id_goods'];
                            $sql2 = "SELECT g.id_goods, g.name, g.quantity_unit, 
                            CASE WHEN g.fixed_price > 0 THEN g.fixed_price
                            ELSE g.price_estimate
                            END price FROM tb_goods g WHERE g.active='Y' 
                            and id_goods = :id_goods OR id_goods NOT IN (SELECT id_goods FROM tb_detail_pr_item WHERE id_purchase_requition = :idpr)";
                            $query2 = $dbcon->prepare($sql2);
                            $query2->bindParam('id_goods', $id_goods, PDO::PARAM_STR);
                            $query2->bindParam('idpr', $idpr, PDO::PARAM_STR);
                            $query2->execute();
                            echo '<option value="">Pilih Barang</option>';
                            while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
                              $selected = $row['id_goods'] == $row2['id_goods'] ? "selected" : "";
                              echo '<option data-quantity_unit='.$row2['quantity_unit'].' data-price='.$row2['price'].' '.$selected.' value="'.$row2['id_goods'].'">'.$row2['name'].'</option>';
                            }
                            '</select></td>';
                            echo '<td><input required name="qty[]" id="qty_'.$counter.'" value="'.$row['quantity'].'" class="form-control qty" placeholder=""></td>';
                            echo '<td><input disabled id="unit_'.$counter.'" class="form-control" value="'.$row['unit'].'" placeholder=""></td>';
                            echo '<td><select required name="suppliers[]" class="form-control" id="supplier_'.$counter.'" >';
                            $sql2 = "SELECT * FROM tb_suppliers WHERE active='Y'";
                            $query2 = $dbcon->prepare($sql2);
                            $query2->execute();
                            echo '<option value="">Pilih Suplier</option>';
                            $id_supplier = $row['id_supplier'];
                            while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
                              $selected = $row['id_supplier'] == $row2['id_supplier'] ? "selected" : "";
                              echo '<option '.$selected.' value="'.$row2['id_supplier'].'">'.$row2['name'].'</option>';
                            }
                            echo '</select></td>';
                            
                            echo '<td><input disabled name="harga[]" value="'."Rp " . number_format($price, 0, ',', '.').'" id="price_'.$counter.'" class="form-control price-item" placeholder=""></td>';
                            echo '</tr>';
                          }
                        ?>
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
    var id = $('#id_purchase_requition').val();
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

    function populateSupplier(selector){
      $.ajax({
          type : 'POST',
          url  : "purchase_requition/input_po/get_select_supplier.php",
          success : function(data){
            $(selector).empty();
            $(selector).append(data);
          }                    // pass existing options
      });
    }

    function populate(selector){
      var arr = [];
      $('.goods').each(function(){
        var selected = $(this).find(':selected').val();
        arr.push(selected);
      });
      $.ajax({
        type : 'POST',
        url  : "purchase_requition/input_po/get_select_goods.php",
        data:{selected:arr},
        success : function(data){
          $(selector).empty();
          $(selector).append(data);
        }                    // pass existing options
      });
    }

    function getDataSelected(id, counter){
      $.ajax({
            type : 'POST',
            url  : "purchase_requition/input_po/get_selected_goods.php",
            data:{id:id},
            success : function(data){
              var data_arr = JSON.parse(data);
              $('#unit_'+counter).val(data_arr.unit);
              $('#goods_'+counter+' option:not(:selected)').removeAttr('data-quantity_unit');
              $('#goods_'+counter).find('option:selected').attr('data-quantity_unit',data_arr.quantity_unit);

              $('#goods_'+counter+' option:not(:selected)').removeAttr('data-price');
              $('#goods_'+counter).find('option:selected').attr('data-price',data_arr.price);
              var val = $('#qty_'+counter).val();
              var total = (val/data_arr.quantity_unit)*data_arr.price;
              $('#price_'+counter).val('Rp '+formatRupiah(total.toString()));
              $('#cur_stock_'+counter).val(data_arr.stock);

              getTotal();

            }                    // pass existing options
        });
    }

    var table_input = $("#table_input").DataTable({
      "autoWidth": true,
      "responsive": true,
      dom: 'Btip',
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
        total = api
            .column( 7 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
      },
      buttons: [
        {
          text: '+',
          className : 'btn btn-info add-button',
          action: function ( e, dt, node, config ) {
            var counter = table_input.rows().count() + 1;
            var cur_stock = '<input name="cur_stock[]" readonly id="cur_stock_'+counter+'" class="form-control" placeholder="">';
            var barang = '<select required name="goods[]" class="form-control goods" id="goods_'+counter+'" ></select>';
            var qty = '<input required name="qty[]" id="qty_'+counter+'" class="form-control qty" placeholder="">';
            var unit = '<input disabled id="unit_'+counter+'" class="form-control" placeholder="">';
            var supplier = '<select required name="suppliers[]" class="form-control" id="supplier_'+counter+'" ></select>';
            var price = '<input disabled name="harga[]" id="price_'+counter+'" class="form-control price-item" placeholder="">';
            var btn_delete = ' <center><button type="button" id="del_'+counter+'" class="btn btn-danger btn-sm del-row"><i class="fa fa-times"></i></button></center>'
            var initVal = $('#goods_'+(counter-1)).val();
            if(initVal != ''){
              getTotal();
              table_input.row.add( [
                btn_delete,
                counter, 
                cur_stock,
                barang,
                qty,
                unit,
                supplier,
                price
              ] ).draw( false );
              populate('#goods_'+counter);
              populateSupplier('#supplier_'+counter);

              $('.goods').each(function(index){
                var counter = index + 1;
                $('#goods_'+counter).change(function(){
                  var val = $(this).val();
                  if(val != ""){
                    getDataSelected(val, counter);
                  }
                });
              });
              
              $('.del-row').each(function(){
                $(this).click(function(){
                  table_input
                  .row( $(this).parents('tr') )
                  .remove()
                  .draw();
                });
              });
              
              $('.qty').each(function(index){
                var counter = index + 1;
                $('#qty_'+counter).change(function(){
                  var val = $('#qty_'+counter).val();
                  var price = $('#goods_'+counter).find(':selected').data('price');
                  var uqty = $('#goods_'+counter).find(':selected').data('quantity_unit');
                  var total = (val/uqty)*price;
                  $('#price_'+counter).val('Rp '+formatRupiah(total.toString()));
                  getTotal();
                });
              });
            }else{
              alert('Pilih barang terlebih dahulu untuk menambahkan baris baru');
            }
          }
        }
      ]
    });

    if(id == ""){
      table_input.buttons('.add-button').nodes().click();
    }
    
    $('.goods').each(function(index){
      var counter = index + 1;
      $('#goods_'+counter).change(function(){
        var val = $(this).val();
        if(val != ""){
          getDataSelected(val, counter);
        }
      });
    });
    
    $('.del-row').each(function(){
      $(this).click(function(){
        table_input
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      });
    });

    $('.qty').each(function(index){
      var counter = index + 1;
      $('#qty_'+counter).change(function(){
        var val = $('#qty_'+counter).val();
        var price = $('#goods_'+counter).find(':selected').data('price');
        var uqty = $('#goods_'+counter).find(':selected').data('quantity_unit');
        var total = (val/uqty)*price;
        $('#price_'+counter).val('Rp '+formatRupiah(total.toString()));
        getTotal();
      });
    });
    var counter = 0;
    
    function getTotal(){
      var total = 0;
      $('.price-item').each(function(){
        var totalstr = $(this).val();
        totalstr = totalstr.replace(/[\Rp.]/g, '')*1 ;
        total += totalstr;
        $('#total').html('Rp '+formatRupiah(total.toString()));
        $('#total_po').val(total);
      });
    }
  });
</script>
        <!-- page content -->

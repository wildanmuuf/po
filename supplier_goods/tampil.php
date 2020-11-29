<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Suplier</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
              <?php include("tambah.php");?>
                <div class="x_panel">
                  <div id="title" class="x_title">
                    <h2>Daftar Suplier</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="collapse-link"><a><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Barang</th>
                          <th>Suplier</th>
                          <th>Harga Suplier</th>
                          <th>Harga Estimasi</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
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
  var table_categories;
  initTable();
  function initTable(){
    var filename = $("#title").text();
    table_categories = $("#categories").DataTable({
        "autoWidth": true,
        "responsive": true,
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax" : {
          url : "supplier_goods/get_suppliers.php",
          type : "post"
        },
        dom: 'Bfrtip',
        buttons:  [{
                extend: 'pdfHtml5',
                title: filename,
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },{
                extend: 'excelHtml5',
                title: filename,
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }, {
                extend: 'csvHtml5',
                title: filename,
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }
        ]
    });
  }
  $('#id_goods').change(function(event){
    var price = $('#id_goods').find(':selected').data('price').toString();
    price = formatRupiah(price);
    $('#price').val('Rp '+price);
  });
  $('#id_supplier').change(function(event){
    var id_supplier = $('#id_supplier').val();
    var id_goods = $('#id_goods').val();
    $.ajax({
      type:'POST',
      url:"supplier_goods/check_exist.php",
      dataType: 'json',
      data: {id_supplier:id_supplier, id_goods:id_goods},
      success: function(data){
        if(data.exist == 1){
          event.target.setCustomValidity('Barang ini sudah ada di Supplier');
          var price = formatRupiah(data.price);
          $('#price').val('Rp '+price);
          setCurrentPrice(data.price);
          $('#id_supplier_goods').val(data.id_supplier_goods);
        }else{
          event.target.setCustomValidity('');
          var price = $('#id_goods').find(':selected').data('price').toString();
          price = formatRupiah(price);
          $('#price').val('Rp '+price);
          $('#id_supplier_goods').val('');
        }
      }
    });
  });

  var rupiah = document.getElementById("price");
  rupiah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, "Rp ");
  });
  
  window.onload = function(e){
    var id = document.getElementById('id_supplier_goods').value;
    if(id > 0 && id != ""){
      rupiah.value = formatRupiah(rupiah.value, "Rp ");
    }
  }

  var current_price = 0;
  function setCurrentPrice(cur_price){
    current_price = cur_price;
  }
  $('#save').on('click', function(){
    var inprice = $('#price').val();
    var price2 = inprice.replace(".", "");
    price2 = price2.replace("Rp ", "");
    if(current_price != price2){
      console.log(current_price+" "+price2);
      document.getElementById('demo-form2').noValidate = true;
    }
  });

  
</script>
        <!-- /page content -->

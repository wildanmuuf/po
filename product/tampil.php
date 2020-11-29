<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Produk</h3>
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
                    <h2>Daftar Produk</h2>
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
                            <div class="row">
                              <div class="col-md-4 align-self-start pl-4">
                                <label  for="id_group">Kategori <span class="required">*</span>
                                </label>
                                <select class="form-control" id="filter_category">
                                  <option value=''>Semua</option>
                                  <?php
                                    $sql = "SELECT * FROM tb_category WHERE active='Y'";
                                    $query = $dbcon->prepare($sql);
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
                                      echo "<option value='$row[id_category]'>$row[category_name]</option>";
                                    }
                                  ?>
                                </select>
                              </div>
											        <div class="col-md-2 offset-sm-5">
                                <label>Status</label>
                                <div class="pt-3">
                                  <p>
                                  Aktif <input type="radio" checked class="flat filter" name="filter_active" id="filter-aktifY" value="Y"  required /> &nbsp;
                                  Tidak Aktif <input type="radio" class="flat filter" name="filter_active" id="filter-aktifT" value="T" />
                                  </p>
                                </div>
                              </div>
                            </div>
                    <table id="products" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Produk</th>
                          <th>Kategori</th>
                          <th>Grup Produk</th>
                          <th>Harga</th>
                          <th>Total Cost</th>
                          <th>Status</th>
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
  var aktif= $("input[name='filter_active']:checked").val();
  var category = 0;
  $('.filter').on("ifChecked",function(event) {
    aktif = $(this).val();
    console.log("aktif = "+aktif);
    table_categories.destroy();
    initTable(aktif, category);
  });

  $('#filter_category').change(function() {
    category = $(this).val();
    table_products.destroy();
    initTable(aktif, category);
  });

  var table_products;
  initTable(aktif, category);
  function initTable(aktif, category){
    var filename = $("#title").text();
    table_products = $("#products").DataTable({
        "responsive": true,
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax" : {
          url : "product/get_products.php",
          type : "post",
          data:{aktif:aktif, category:category}
        },
        dom: 'Bfrtip',
        dom: "<'row'<'col-4'l><'col-4'f><'col-4 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
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
 
  var rupiah = document.getElementById("harga");
  rupiah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, "Rp ");
  });
</script>
        <!-- /page content -->

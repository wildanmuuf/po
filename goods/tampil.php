<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Bahan Baku</h3>
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
                    <h2>Daftar Bahan Baku</h2>
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
                                <label  for="id_group">Group 
                                </label>
                                <select class="form-control" id="filter_group">
                                  <option value=''>Semua</option>
                                  <?php
                                    $sql = "SELECT * FROM tb_roles WHERE active='Y'";
                                    $query = $dbcon->prepare($sql);
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
                                      echo "<option $selected value='$row[id_role]'>$row[rolename]</option>";
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
                            
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Barang</th>
                          <th>Qty Satuan</th>
                          <th>Satuan</th>
                          <th>Harga Estimasi</th>
                          <th>Stok</th>
                          <th>Harga</th>
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
  $(document).ready(function() {
  
  var aktif= $("input[name='filter_active']:checked").val();
  var group = 0;
  $('.filter').on("ifChecked",function(event) {
    aktif = $(this).val();
    console.log("aktif = "+aktif);
    table_categories.destroy();
    initTable(aktif, group);
  });

  $('#filter_group').change(function() {
    group = $(this).val();
    table_categories.destroy();
    initTable(aktif, group);
  });

  var table_categories;
  initTable(aktif, group);
  function initTable(aktif, group){
    var filename = $("#title").find('h2').text();
    table_categories = $("#categories").DataTable({
        "responsive": true,
        "paging": true,
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[10, 20, 50, 0], [10, 20, 50, "Semua"]],
        "ajax" : {
          url : "goods/get_goods.php",
          type : "post",
          data:{aktif:aktif, group:group}
        },
        dom: "<'row'<'col-4'l><'col-4'f><'col-4 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
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

  var rupiah = document.getElementById("price_estimate");
  rupiah.addEventListener("keyup", function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value, "Rp. ");
  });
});
</script>
        <!-- page content -->

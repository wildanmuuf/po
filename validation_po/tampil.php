<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Purchase Request</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <a href="index.php?m=purchase_requition&s=input_po" class="btn btn-success btn-block">
                      Buat Purchase Order
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div id="title" class="x_title">
                    <h2>Daftar Purchase Request</h2>
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
                                <div class="col-md-4 align-self-start pl-4 pr-4">
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
                                <div class="col-md-4">
                                  <label>Status</label>
                                  <select class="form-control" id="filter_category">
                                    <option value=''>Semua</option>
                                    <option value='1'>PO 1 : Beli</option>
                                    <option value='2'>PO 2 : PO</option>
                                  </select>
                                </div>
                                <div class="col-md-4 pl-4 pr-4">
                                  <label>Status</label>
                                  <select class="form-control" id="filter_status">
                                    <option value=''>Semua</option>
                                    <?php
                                      $arr_status = array("Batal", "Proses Verifikasi","Disetujui", "Ditolak", "Proses Antar", "Proses Verifikasi Barang", "Pembayaran", "Proses Bayar", "Selesai");
                                      $i = 0;
                                      while($i < count($arr_status)){
                                        echo "<option value='$i'>$arr_status[$i]</option>";
                                        $i++;
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>
										<div class="ln_solid"></div>

                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th width='130'>Kode PO</th>
                          <th width='80'>Kategori</th>
                          <th>Tanggal Transaksi</th>
                          <th width='80'>Tanggal Jatuh Tempo</th>
                          <th>Divisi</th>
                          <th width='150'>Total</th>
                          <th width='100'>Status</th>
                          <th width='100'>Opsi</th>
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
  
  var status= $("#filter_status option:selected").val();
  var category= $("#filter_category option:selected").val();
  var group = 0;
  // $('.filter').on("ifChecked",function(event) {
  //   aktif = $(this).val();
  //   console.log("aktif = "+aktif);
  //   table_categories.destroy();
  //   initTable(aktif, group);
  // });

  $('#filter_status').change(function() {
    status = $(this).val();
    table_categories.destroy();
    initTable(status, group, category);
  });

  $('#filter_group').change(function() {
    group = $(this).val();
    table_categories.destroy();
    initTable(status, group, category);
  });

  $('#filter_category').change(function() {
    category = $(this).val();
    table_categories.destroy();
    initTable(status, group, category);
  });

  var table_categories;
  initTable(status, group, category);
  function initTable(status, group, category){
    var filename = $("#title").find('h2').text();
    table_categories = $("#categories").DataTable({
        "responsive": true,
        "paging": true,
        "processing": true,
        "ordering": false,
        "serverSide": true,
        "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Semua"]],
        "ajax" : {
          url : "purchase_requition/get_purchase_requitions.php",
          type : "post",
          data:{status:status, group:group, category:category}
        },
        "oLanguage": {
          "sSearch": "Cari Kode PO"
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

});
</script>
        <!-- page content -->

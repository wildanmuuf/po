<?php include("atas.php");?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users</h3>
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
                    <h2>Daftar Users</h2>
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
                            <div class="item form-group">
                              <label class="col-form-label col-md-9 col-sm-9 label-align">Status</label>
                              <div class="col-md-3 col-sm-3">
                                <div class="btn-group" id="filters" data-toggle="buttons">
                                  <label class="btn btn-secondary filter-y" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="active" id="aktif_y" value="Y" class="join-btn"> &nbsp; Aktif &nbsp;
                                  </label>
                                  <label class="btn btn-primary filter-t" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                    <input type="radio" name="active" id="aktif_t" value="T" class="join-btn"> Tidak Aktif
                                  </label>
                                </div>
                              </div>
                            </div>
                    <table id="categories" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Users</th>
                          <th>Group</th>
                          <th>Ditambahkan</th>
                          <th>Diupdate</th>
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
  var aktif="";
  console.log("aktif = "+aktif);

  $(".filter-y").click(function(){
    aktif = $(".filter-y").find('#aktif_y').val();
    console.log("aktif = "+aktif);
    table_categories.destroy();
    initTable(aktif);
  });
  $(".filter-t").click(function(){
    aktif = $(".filter-t").find('#aktif_t').val();
    console.log("aktif = "+aktif);
    table_categories.destroy();
    initTable(aktif);
  });

  var table_categories;
  initTable(aktif);
  function initTable(aktif){
    var filename = $("#title").text();
    table_categories = $("#categories").DataTable({
        "autoWidth": true,
        "responsive": true,
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax" : {
          url : "users/get_users.php",
          type : "post",
          data:{aktif:aktif}
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
</script>
        <!-- /page content -->

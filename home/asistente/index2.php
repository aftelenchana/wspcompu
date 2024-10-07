<?php
ob_start();
include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();
      if (empty($_SESSION['active'])) {
        header('location:/');

      }else {

      }
       $iduser= $_SESSION['id'];
       $query_config = mysqli_query($conection, "SELECT * FROM configuraciones");
        $result_config = mysqli_fetch_array($query_config);
        if (!empty($result_config['foto_representativa'])) {
          $foto_representativa = $result_config['foto_representativa'];
        }else {
          $foto_representativa ='subir.png';
        }

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mis Clientes</title>

  <link rel="icon" href="/img/guibis.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/ricrey/theme_responsive/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/ricrey/theme_responsive/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/ricrey/theme_responsive/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/ricrey/theme_responsive/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/ricrey/theme_responsive/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="/ricrey/theme_responsive/plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">

  <?php
$id_user= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $id_user");
$result = mysqli_fetch_array($query);
$mi_leben = $result['mi_leben'];
 ?>
 <?php include "../scripts/menu-superior.php"; ?>

 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0">Mis Clientes</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="/">Inicio</a></li>
             <li class="breadcrumb-item active">Mis Clientes</li>
           </ol>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Todos los Clientes Detallados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div style="margin: 20px;padding: 15px;" class="histial_bancario_general">
                    <div class="">
                      <table id="productos" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Imagen</th>
                          <th>Qr</th>
                          <th>ID</th>
                          <th>Nombres</th>
                          <th>Email</th>
                          <th>Dirección</th>
                          <th>Celular</th>
                          <th>Acción</th>
                        </tr>
                        </thead>
                          <tbody>
                        <?php

                        $query_lista = mysqli_query($conection,"SELECT * FROM clientes where clientes.estatus = '1' AND clientes.iduser = '$iduser' ");
                        $result_lista= mysqli_num_rows($query_lista);
                          if ($result_lista > 0) {
                                while ($data_lista=mysqli_fetch_array($query_lista)) {
                                  $foto = 'img/clientes/'.$data_lista['foto'];
                         ?>
                         <tr id="fila_cliente<?php echo $data_lista['id'];?>">
                            <td><img onclick="javascript:this.width=300;this.height=300" ondblclick="javascript:this.width=80;this.height=80" src="<?php echo "$foto"; ?>" width="80"></td>
                            <td><img onclick="javascript:this.width=300;this.height=300" ondblclick="javascript:this.width=80;this.height=80" src="img/qr/<?php echo $data_lista['qr'] ?>" width="80px;"></td>
                            <td ><?php echo $data_lista['id'];?></td>
                            <td ><?php echo $data_lista['nombres']; ?>  </td>
                            <td ><a href="mailto:<?php echo $data_lista['mail']; ?> "><?php echo $data_lista['mail']; ?> </a>   </td>
                            <td ><?php echo $data_lista['direccion']; ?>  </td>
                            <td ><?php echo $data_lista['celular']; ?>  </td>
                            <td >
                              <a style="color:blue;" href="ver_producto.php?producto=<?php echo $data_lista['id'];?>"><i class="fa-solid fa-eye"></i></a>
                              <a style="color:red;" id="prut<?php echo $data_lista['id'];?>"  class="prut<?php echo $data_lista['id'];?> eliminar_cliente" cliente="<?php echo $data_lista['id'];?>" href="#"><i class="fa-solid fa-trash-can"></i></a>
                            </td>

                         </tr>
                                  <?php
                                  }
                                  }
                              ?>
                      </table>
                    </div>
                  </div>

                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
        <footer class="main-footer">
          <?php
              require "../scripts/footer.php";
           ?>
        </footer>
</div>

<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/ricrey/theme_responsive/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/ricrey/theme_responsive/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="/ricrey/theme_responsive/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/jszip/jszip.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/ricrey/theme_responsive/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="/ricrey/theme_responsive/dist/js/adminlte.min.js"></script>
<script src="/ricrey/theme_responsive/dist/js/demo.js"></script>
<script src="/ricrey/theme_responsive/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="jquery_empresa/clientes.js"></script>
<script type="text/javascript">
  $(function () {
    $('#productos').DataTable( {
        "responsive": true,
        "language": {
                "emptyTable":           "No hay datos disponibles en la tabla.",
                "info":                 "Del _START_ al _END_ de _TOTAL_ ",
                "infoEmpty":            "Mostrando 0 registros de un total de 0.",
                "infoFiltered":         "(filtrados de un total de _MAX_ registros)",
                "infoPostFix":          "(actualizados)",
                "lengthMenu":           "Mostrar _MENU_ registros",
                "loadingRecords":       "Cargando...",
                "processing":           "Procesando...",
                "search":               "Buscar:",
                "searchPlaceholder":    "Dato para buscar",
                "zeroRecords":          "No se han encontrado coincidencias.",
                "paginate": {
                "first":                "Primera",
                "last":                 "Última",
                "next":                 ">>",
                "previous":             "<<",
                "colvis":               "Columnas"
                },

            },

        lengthMenu: [[5, 10, 25, 100,-1], [5, 10, 25, 100, "Todos"]],
        pageLength:  10,
        dom: '<l>Bfrtip',
        "order": [[ 2, "desc" ]],
        "ordering": true,

        "buttons": [
            {
                extend: 'colvis',
                text:      '<span>Columnas <i span class="fa fa-columns"></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },

            {
                extend: 'print',
                text:      '<span>Imprimir <span class="fas fa-print"></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copyHtml5',
                text:      '<span>Copiar <i span class="fa fa-copy"></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                text:      '<span>Excel <i span class="fas fa-file-excel"></span>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text:      '<span>PDF <i class="fas fa-file-pdf"></span>',
                exportOptions: {
                    columns: ':visible'
                }
            }
          ],
        columnDefs: [ {
            targets: -1,
            visible: true
        } ]
    } );
} );

</script>
</body>
</html>
<?php
ob_end_flush();
?>

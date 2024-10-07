<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
session_start();
$iduser= $_SESSION['id'];
 if ($_POST['action'] == 'calificar_1_estrella')  {
   $producto = $_POST['producto'];

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_usuario = '$iduser' AND id_producto='$producto'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      // YA HA CALIFICADO
      $query_insert=mysqli_query($conection,"UPDATE estrellas SET estrella='1'
        WHERE id_usuario = '$iduser' AND id_producto='$producto' ");
        $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
        WHERE id_producto='$producto'");
        $data_estrella=mysqli_fetch_array($sql_estrella);
        $numero_calificaciones =  $data_estrella['numero_calificaciones'];
        $estrellas_totales =  $data_estrella['estrellas_totales'];
        $calificacion = round($estrellas_totales/$numero_calificaciones);
        if ($calificacion == 1) {
          // code...
          echo '  <div class="result_estrellas">
          <div class="star-icon">
          <form class="" action="index.html" method="post">
            <label for="rating1" class="fa fa-star estrella_pintada"></label>
            <label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label>
            <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
          </form>
          </div>
          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>
          ';
        }
        if ($calificacion == '2') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>
                <label  for="rating2" class="fa fa-star estrella_pintada"></label>
                <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>
            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>
            ';
        }
        if ($calificacion == '3') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>
            ';
        }
        if ($calificacion == '4') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '5') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label  for="rating5" class="fa fa-star estrella_pintada"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }


    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO estrellas(id_usuario,id_producto,estrella)
      VALUES('$iduser','$producto','1')");
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$producto'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
      if ($calificacion == 1) {
        // code...
        echo '  <div class="result_estrellas">
        <div class="star-icon">
        <form class="" action="index.html" method="post">
          <label for="rating1" class="fa fa-star estrella_pintada"></label>

          <label  for="rating2" class="fa fa-star "></label>

          <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
        </form>
        </div>

        </div>        <div class="">
                  <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
                </div>';
      }
      if ($calificacion == '2') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '3') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '4') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '5') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label  for="rating5" class="fa fa-star estrella_pintada"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }




    }


 }

 //dos estresllas
 if ($_POST['action'] == 'calificar_2_estrella')  {
   $producto = $_POST['producto'];

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_usuario = '$iduser' AND id_producto='$producto'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      // YA HA CALIFICADO
      $query_insert=mysqli_query($conection,"UPDATE estrellas SET estrella='2'
        WHERE id_usuario = '$iduser' AND id_producto='$producto' ");
        $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
        WHERE id_producto='$producto'");
        $data_estrella=mysqli_fetch_array($sql_estrella);
        $numero_calificaciones =  $data_estrella['numero_calificaciones'];
        $estrellas_totales =  $data_estrella['estrellas_totales'];
        $calificacion = round($estrellas_totales/$numero_calificaciones);
        if ($calificacion == 1) {
          echo "$calificacion";
          // code...
          echo '  <div class="result_estrellas">
          <div class="star-icon">
          <form class="" action="index.html" method="post">
            <label for="rating1" class="fa fa-star estrella_pintada"></label>
            <label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label>
            <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
          </form>
          </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
        }
        if ($calificacion == '2') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>
                <label  for="rating2" class="fa fa-star estrella_pintada"></label>
                <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '3') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '4') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '5') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label  for="rating5" class="fa fa-star estrella_pintada"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }


    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO estrellas(id_usuario,id_producto,estrella)
      VALUES('$iduser','$producto','2')");
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$producto'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
      if ($calificacion == 1) {
        // code...
        echo '  <div class="result_estrellas">
        <div class="star-icon">
        <form class="" action="index.html" method="post">
          <label for="rating1" class="fa fa-star estrella_pintada"></label>

          <label  for="rating2" class="fa fa-star "></label>

          <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
        </form>
        </div>

        </div>
        <div class="">
          <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
        </div>';
      }
      if ($calificacion == '2') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '3') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '4') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '5') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label  for="rating5" class="fa fa-star estrella_pintada"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }




    }


 }
 //tres estrellass
 if ($_POST['action'] == 'calificar_3_estrella')  {
   $producto = $_POST['producto'];

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_usuario = '$iduser' AND id_producto='$producto'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      // YA HA CALIFICADO
      $query_insert=mysqli_query($conection,"UPDATE estrellas SET estrella='3'
        WHERE id_usuario = '$iduser' AND id_producto='$producto' ");
        $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
        WHERE id_producto='$producto'");
        $data_estrella=mysqli_fetch_array($sql_estrella);
        $numero_calificaciones =  $data_estrella['numero_calificaciones'];
        $estrellas_totales =  $data_estrella['estrellas_totales'];
        $calificacion = round($estrellas_totales/$numero_calificaciones);
        if ($calificacion == 1) {
          echo "$calificacion";
          // code...
          echo '  <div class="result_estrellas">
          <div class="star-icon">
          <form class="" action="index.html" method="post">
            <label for="rating1" class="fa fa-star estrella_pintada"></label>
            <label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label>
            <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
          </form>
          </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
        }
        if ($calificacion == '2') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>
                <label  for="rating2" class="fa fa-star estrella_pintada"></label>
                <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '3') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '4') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '5') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label  for="rating5" class="fa fa-star estrella_pintada"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }


    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO estrellas(id_usuario,id_producto,estrella)
      VALUES('$iduser','$producto','3')");
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$producto'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
      if ($calificacion == 1) {
        // code...
        echo '  <div class="result_estrellas">
        <div class="star-icon">
        <form class="" action="index.html" method="post">
          <label for="rating1" class="fa fa-star estrella_pintada"></label>

          <label  for="rating2" class="fa fa-star "></label>

          <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
        </form>
        </div>

        </div>
        <div class="">
          <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
        </div>';
      }
      if ($calificacion == '2') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '3') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '4') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '5') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label  for="rating5" class="fa fa-star estrella_pintada"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }




    }


 }


 if ($_POST['action'] == 'calificar_4_estrella')  {
   $producto = $_POST['producto'];

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_usuario = '$iduser' AND id_producto='$producto'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      // YA HA CALIFICADO
      $query_insert=mysqli_query($conection,"UPDATE estrellas SET estrella='4'
        WHERE id_usuario = '$iduser' AND id_producto='$producto' ");
        $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
        WHERE id_producto='$producto'");
        $data_estrella=mysqli_fetch_array($sql_estrella);
        $numero_calificaciones =  $data_estrella['numero_calificaciones'];
        $estrellas_totales =  $data_estrella['estrellas_totales'];
        $calificacion = round($estrellas_totales/$numero_calificaciones);
        if ($calificacion == 1) {
          echo "$calificacion";
          // code...
          echo '  <div class="result_estrellas">
          <div class="star-icon">
          <form class="" action="index.html" method="post">
            <label for="rating1" class="fa fa-star estrella_pintada"></label>
            <label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label>
            <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
          </form>
          </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
        }
        if ($calificacion == '2') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>
                <label  for="rating2" class="fa fa-star estrella_pintada"></label>
                <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '3') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '4') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '5') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label  for="rating5" class="fa fa-star estrella_pintada"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }


    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO estrellas(id_usuario,id_producto,estrella)
      VALUES('$iduser','$producto','4')");
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$producto'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
      if ($calificacion == 1) {
        // code...
        echo '  <div class="result_estrellas">
        <div class="star-icon">
        <form class="" action="index.html" method="post">
          <label for="rating1" class="fa fa-star estrella_pintada"></label>

          <label  for="rating2" class="fa fa-star "></label>

          <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
        </form>
        </div>

        </div>
        <div class="">
          <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
        </div>';
      }
      if ($calificacion == '2') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '3') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '4') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '5') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label  for="rating5" class="fa fa-star estrella_pintada"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }




    }


 }


 //cinco estrellass
 if ($_POST['action'] == 'calificar_5_estrella')  {
   $producto = $_POST['producto'];

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_usuario = '$iduser' AND id_producto='$producto'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      // YA HA CALIFICADO
      $query_insert=mysqli_query($conection,"UPDATE estrellas SET estrella='5'
        WHERE id_usuario = '$iduser' AND id_producto='$producto' ");
        $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
        WHERE id_producto='$producto'");
        $data_estrella=mysqli_fetch_array($sql_estrella);
        $numero_calificaciones =  $data_estrella['numero_calificaciones'];
        $estrellas_totales =  $data_estrella['estrellas_totales'];
        $calificacion = round($estrellas_totales/$numero_calificaciones);
        if ($calificacion == 1) {
          echo "$calificacion";
          // code...
          echo '  <div class="result_estrellas">
          <div class="star-icon">
          <form class="" action="index.html" method="post">
            <label for="rating1" class="fa fa-star estrella_pintada"></label>
            <label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label>
            <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
            <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
          </form>
          </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
        }
        if ($calificacion == '2') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>
                <label  for="rating2" class="fa fa-star estrella_pintada"></label>
                <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>
                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '3') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '4') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }
        if ($calificacion == '5') {
          echo '  <div class="result_estrellas">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label>

                <label  for="rating2" class="fa fa-star estrella_pintada"></label>

                <label  for="rating3" class="fa fa-star estrella_pintada"></label>

                <label  for="rating4" class="fa fa-star estrella_pintada"></label>

                <label  for="rating5" class="fa fa-star estrella_pintada"></label>
              </form>
              </div>

            </div>
            <div class="">
              <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
            </div>';
        }


    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO estrellas(id_usuario,id_producto,estrella)
      VALUES('$iduser','$producto','5')");
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$producto'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
      if ($calificacion == 1) {
        // code...
        echo '  <div class="result_estrellas">
        <div class="star-icon">
        <form class="" action="index.html" method="post">
          <label for="rating1" class="fa fa-star estrella_pintada"></label>

          <label  for="rating2" class="fa fa-star "></label>

          <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

          <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
        </form>
        </div>

        </div>
        <div class="">
          <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
        </div>';
      }
      if ($calificacion == '2') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating3" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '3') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating4" class="fa fa-star"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '4') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }
      if ($calificacion == '5') {
        echo '  <div class="result_estrellas">
            <div class="star-icon">
            <form class="" action="index.html" method="post">
              <label for="rating1" class="fa fa-star estrella_pintada"></label>

              <label  for="rating2" class="fa fa-star estrella_pintada"></label>

              <label  for="rating3" class="fa fa-star estrella_pintada"></label>

              <label  for="rating4" class="fa fa-star estrella_pintada"></label>

              <label  for="rating5" class="fa fa-star estrella_pintada"></label>
            </form>
            </div>

          </div>
          <div class="">
            <p>Promedio de <span style="color: #FF5733;font-size: 20px;font-weight: bold;"> '.$numero_calificaciones.'</span> calificaciones de este producto</p>
          </div>';
      }




    }


 }
  ?>

   <?php
   session_start();
   require '../QR/phpqrcode/qrlib.php';
   $dir = '../QR/codigosproductos/';
   $iduser= $_SESSION['id'];
     include "../../coneccion.php";


   if ($_POST['action'] == 'infoproducto') {
     $producto = $_POST['producto'];

     $query = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
       producto_venta.foto,producto_venta.porcentaje,producto_venta.qr, subcategorias.nombre as 'subcategorias', ciudad.nombre as 'ciudad', usuarios.nombre_empresa,
       usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp, usuarios.img_logo,usuarios.id, producto_venta.fecha_producto,producto_venta.tipo_servicio
          FROM producto_venta
         INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
         INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
         INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
         WHERE idproducto = $producto AND estatus = 1 ");
       $data = mysqli_fetch_assoc($query);
       echo json_encode($data,JSON_UNESCAPED_UNICODE);
       exit;

     // code...
   }





         if ($_POST['action'] == 'eiminar_servicios') {
            $idproducto   =  $_POST['idproducto'];
           $query_delete=mysqli_query($conection,"UPDATE producto_venta SET estatus= 0  WHERE idproducto='$idproducto' ");

           if ($query_delete) {
             $arrayName = array('idproducto' =>$idproducto);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }else {

             }
             exit;

           // code...
         }








         if ($_POST['action'] == 'editt_editar_servicio') {
           $nombre_producto   =  $_POST['nombre_producto'];
           $idproducto   =  $_POST['idproducto'];
           $fotoactual   =  $_POST['fotoactual'];
           $precio            =  $_POST['precio'];
           $descripcion       =  $_POST['descripcion'];
           $provincia         =  $_POST['provincia'];
           $ciudad         =  $_POST['ciudad'];
           $tipo              =  $_POST['tipo'];
           $porcentaje        =  $_POST['porcentaje'];
           $id_user           =  $_SESSION['id'];
           $precio_total      =  $precio + ($precio*$porcentaje)/100;
           //Foto
           $foto           =    $_FILES['foto'];
           $nombre_foto    =    $foto['name'];
           $type 					 =    $foto['type'];
           $url_temp       =    $foto['tmp_name'];

           $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
           if ($nombre_foto != '') {
            $destino = '../img/uploads/';
            $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
            $imgProducto = $img_nombre.'.jpg';

            $src = $destino.$imgProducto;
           }

           if ($nombre_foto != "") {
             $query_insert=mysqli_query($conection,"UPDATE producto_venta SET
               nombre='$nombre_producto',precio='$precio_total',descripcion='$descripcion',foto='$imgProducto'
               ,ciudad='$ciudad',provincia='$provincia',porcentaje='$porcentaje',ganancias_totales='$precio_total',tipo_servicio='$tipo'  WHERE idproducto='$idproducto' ");

            if ($query_insert) {
                if ($nombre_foto != '') {
                  move_uploaded_file($url_temp,$src);
                }

                $query = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $idproducto");
                  $data = mysqli_fetch_assoc($query);
                  echo json_encode($data,JSON_UNESCAPED_UNICODE);


              }else {
                $arrayName = array('Error' =>'error_insertar');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
             // code.
           }else {
             $query_insert=mysqli_query($conection,"UPDATE producto_venta SET
               nombre='$nombre_producto',precio='$precio_total',descripcion='$descripcion',foto='$fotoactual'
               ,ciudad='$ciudad',provincia='$provincia',porcentaje='$porcentaje',ganancias_totales='$precio_total',tipo_servicio='$tipo'  WHERE idproducto='$idproducto' ");

            if ($query_insert) {
                $query = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $idproducto");
                  $data = mysqli_fetch_assoc($query);
                  echo json_encode($data,JSON_UNESCAPED_UNICODE);


              }else {
                $arrayName = array('Error' =>'error_insertar');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }
             // code.
           }



         }



    ?>

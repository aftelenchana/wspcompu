<?php
session_start();
  include "../../coneccion.php";
    mysqli_set_charset($conection, 'utf8'); //linea a colocar

        $perfil = $_POST['perfil'];
        $query = mysqli_query($conection, "SELECT usuarios.nombres,usuarios.apellidos,usuarios.nombre_empresa,usuarios.facebook,
          usuarios.instagram,usuarios.tiktok,
          usuarios.whatsapp,usuarios.img_logo,usuarios.img_perfil,
          usuarios.img_qr, COUNT(*) as  'productos', usuarios.id, usuarios.ruc,usuarios.mi_leben,usuarios.celular
            FROM usuarios INNER JOIN producto_venta ON producto_venta.id_usuario = usuarios.id WHERE usuarios.id =$perfil");
$query2 = mysqli_query($conection, "SELECT  COUNT(*) as  'vendidos' From ventas
	INNER JOIN producto_venta on producto_venta.idproducto = ventas.idp
    INNER JOIN usuarios on usuarios.id = producto_venta.id_usuario
WHERE producto_venta.id_usuario = $perfil");
$result2 = mysqli_fetch_array($query2);
$vendidos = $result2['vendidos'];

$query3 = mysqli_query($conection, "SELECT  COUNT(*) as  'favoritos' From tienda_favorita
WHERE tienda_favorita.id_usuario = $perfil");
$result3 = mysqli_fetch_array($query3);
$favoritos = $result3['favoritos'];


$result = mysqli_fetch_array($query);
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];
$facebook = $result['facebook'];
$instagram = $result['instagram'];
$whatsapp = $result['whatsapp'];
$tiktok = $result['tiktok'];
$img_logo = $result['img_logo'];
$img_perfil = $result['img_perfil'];
$img_qr = $result['img_qr'];
$mi_leben = $result['mi_leben'];
$productos = $result['productos'];
$id = $result['id'];
$ruc = $result['ruc'];
$celular = $result['celular'];

            if ($img_logo != "") {
                 $nombre_salida = "";
              // code...
            }else {
              $n_1 = $nombres[0];
              $n_2 = $apellidos[0];
              $nombre_salida = "$n_1$n_2";
              // code...
            }
            if ($favoritos == '') {
              $favoritos = 0;
              // code...
            }

$arrayName = array('nombre_opcional' =>$nombre_salida,'nombres' =>$nombres,'apellidos' =>$apellidos,'nombre_empresa' =>$nombre_empresa,'facebook' =>$facebook,'tiktok' =>$tiktok,'instagram' =>$instagram,'whatsapp' =>$whatsapp,'img_logo' =>$img_logo,
'img_perfil' =>$img_perfil,'img_qr' =>$img_qr,'productos' =>$productos,'id' =>$id,'ruc' =>$ruc,'celular' =>$celular,
'vendidos' =>$vendidos,'mi_leben' =>$mi_leben,'favoritos' =>$favoritos );
echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 ?>

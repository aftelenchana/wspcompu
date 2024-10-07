<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    if (isset($_POST['fecha_analisis']) && $_POST['fecha_analisis'] !== 'all') {
        $fecha_seleccionada = $_POST['fecha_analisis'];
        $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' midnight'));
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' tomorrow midnight'));

        // Queries relacionadas con la fecha seleccionada
        $sql_facturas = mysqli_query($conection, "SELECT COUNT(*) as facturas FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000' AND comprobante ='factura' AND estado ='COMPLETADO'");
        $result_facturas = mysqli_fetch_array($sql_facturas);
        $total_facturas = $result_facturas['facturas'];

        $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as tikets FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
        $total_result_notas_venta = $result_notas_venta['tikets'];

        $query_ganancias_factura = mysqli_query($conection, "SELECT SUM(comprobante_factura_final.subtotal) as 'subtotal', SUM(comprobante_factura_final.iva) as 'iva', SUM(comprobante_factura_final.total) as 'total' FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser'");
        $result_ganancia_factura = mysqli_fetch_array($query_ganancias_factura);
        $subtotal_factura  = $result_ganancia_factura['subtotal'];
        $iva_factura = $result_ganancia_factura['iva'];
        $total_factura = $result_ganancia_factura['total'];

        $query_ganancias_tiket = mysqli_query($conection, "SELECT SUM(tikets.subtotal) as 'subtotal', SUM(tikets.iva) as 'iva', SUM(tikets.total) as 'total' FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_ganancia_tiket = mysqli_fetch_array($query_ganancias_tiket);
        $subtotal_tiket = $result_ganancia_tiket['subtotal'];
        $iva_tiket = $result_ganancia_tiket['iva'];
        $total_tiket = $result_ganancia_tiket['total'];

        $total = $total_factura + $total_tiket;

        $response = array(
            'total' => $total,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'total_facturas' => $total_facturas,
            'total_result_notas_venta' => $total_result_notas_venta
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $query_fechas = mysqli_query($conection, "SELECT DISTINCT DATE(fecha) as fecha_factura FROM comprobante_factura_final WHERE comprobante_factura_final.id_emisor = '$iduser' AND comprobante ='factura' AND estado ='COMPLETADO'
        UNION
        SELECT DISTINCT DATE(fecha) as fecha_factura FROM tikets WHERE tikets.id_emisor = '$iduser'");

        $eventos = array();
        while($row = mysqli_fetch_array($query_fechas)) {
            $eventos[] = array(
                'title' => 'Venta',
                'start' => $row['fecha_factura'],
                'color' => '#f0ad4e',
                'textColor' => '#000000'
            );
        }
        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
    }

    }



    if ($_SESSION['rol'] == 'Recursos Humanos') {
     include "../sessiones/session_recursos_humanos.php";

    if (isset($_POST['fecha_analisis']) && $_POST['fecha_analisis'] !== 'all') {
        $fecha_seleccionada = $_POST['fecha_analisis'];
        $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' midnight'));
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' tomorrow midnight'));

        // Queries relacionadas con la fecha seleccionada
        $sql_facturas = mysqli_query($conection, "SELECT COUNT(*) as facturas FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000' AND comprobante ='factura' AND estado ='COMPLETADO'");
        $result_facturas = mysqli_fetch_array($sql_facturas);
        $total_facturas = $result_facturas['facturas'];

        $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as tikets FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
        $total_result_notas_venta = $result_notas_venta['tikets'];

        $query_ganancias_factura = mysqli_query($conection, "SELECT SUM(comprobante_factura_final.subtotal) as 'subtotal', SUM(comprobante_factura_final.iva) as 'iva', SUM(comprobante_factura_final.total) as 'total' FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser'");
        $result_ganancia_factura = mysqli_fetch_array($query_ganancias_factura);
        $subtotal_factura  = $result_ganancia_factura['subtotal'];
        $iva_factura = $result_ganancia_factura['iva'];
        $total_factura = $result_ganancia_factura['total'];

        $query_ganancias_tiket = mysqli_query($conection, "SELECT SUM(tikets.subtotal) as 'subtotal', SUM(tikets.iva) as 'iva', SUM(tikets.total) as 'total' FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_ganancia_tiket = mysqli_fetch_array($query_ganancias_tiket);
        $subtotal_tiket = $result_ganancia_tiket['subtotal'];
        $iva_tiket = $result_ganancia_tiket['iva'];
        $total_tiket = $result_ganancia_tiket['total'];

        $total = $total_factura + $total_tiket;

        $response = array(
            'total' => $total,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'total_facturas' => $total_facturas,
            'total_result_notas_venta' => $total_result_notas_venta
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $query_fechas = mysqli_query($conection, "SELECT DISTINCT DATE(fecha) as fecha_factura FROM comprobante_factura_final WHERE comprobante_factura_final.id_emisor = '$iduser' AND comprobante ='factura' AND estado ='COMPLETADO'
        UNION
        SELECT DISTINCT DATE(fecha) as fecha_factura FROM tikets WHERE tikets.id_emisor = '$iduser'");

        $eventos = array();
        while($row = mysqli_fetch_array($query_fechas)) {
            $eventos[] = array(
                'title' => 'Venta',
                'start' => $row['fecha_factura'],
                'color' => '#f0ad4e',
                'textColor' => '#000000'
            );
        }
        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
    }

    }


    if ($_SESSION['rol'] == 'Paciente') {
     include "../sessiones/session_paciente.php";

    if (isset($_POST['fecha_analisis']) && $_POST['fecha_analisis'] !== 'all') {
        $fecha_seleccionada = $_POST['fecha_analisis'];
        $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' midnight'));
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha_seleccionada . ' tomorrow midnight'));

        // Queries relacionadas con la fecha seleccionada
        $sql_facturas = mysqli_query($conection, "SELECT COUNT(*) as facturas FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser' AND comprobante_factura_final.codigo_interno_factura != '00000000' AND comprobante ='factura' AND estado ='COMPLETADO'");
        $result_facturas = mysqli_fetch_array($sql_facturas);
        $total_facturas = $result_facturas['facturas'];

        $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as tikets FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
        $total_result_notas_venta = $result_notas_venta['tikets'];

        $query_ganancias_factura = mysqli_query($conection, "SELECT SUM(comprobante_factura_final.subtotal) as 'subtotal', SUM(comprobante_factura_final.iva) as 'iva', SUM(comprobante_factura_final.total) as 'total' FROM comprobante_factura_final WHERE comprobante_factura_final.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND comprobante_factura_final.id_emisor = '$iduser'");
        $result_ganancia_factura = mysqli_fetch_array($query_ganancias_factura);
        $subtotal_factura  = $result_ganancia_factura['subtotal'];
        $iva_factura = $result_ganancia_factura['iva'];
        $total_factura = $result_ganancia_factura['total'];

        $query_ganancias_tiket = mysqli_query($conection, "SELECT SUM(tikets.subtotal) as 'subtotal', SUM(tikets.iva) as 'iva', SUM(tikets.total) as 'total' FROM tikets WHERE tikets.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND tikets.id_emisor = '$iduser'");
        $result_ganancia_tiket = mysqli_fetch_array($query_ganancias_tiket);
        $subtotal_tiket = $result_ganancia_tiket['subtotal'];
        $iva_tiket = $result_ganancia_tiket['iva'];
        $total_tiket = $result_ganancia_tiket['total'];

        $total = $total_factura + $total_tiket;

        $response = array(
            'total' => $total,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'total_facturas' => $total_facturas,
            'total_result_notas_venta' => $total_result_notas_venta
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        $query_fechas = mysqli_query($conection, "SELECT DISTINCT DATE(fecha) as fecha_factura FROM comprobante_factura_final WHERE comprobante_factura_final.id_emisor = '$iduser' AND comprobante ='factura' AND estado ='COMPLETADO'
        UNION
        SELECT DISTINCT DATE(fecha) as fecha_factura FROM tikets WHERE tikets.id_emisor = '$iduser'");

        $eventos = array();
        while($row = mysqli_fetch_array($query_fechas)) {
            $eventos[] = array(
                'title' => 'Venta',
                'start' => $row['fecha_factura'],
                'color' => '#f0ad4e',
                'textColor' => '#000000'
            );
        }
        echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
    }

    }



?>

<?php
    include "../../coneccion.php";
      mysqli_set_charset($conection, 'utf8'); //linea a colocar
         session_start();
         $iduser= $_SESSION['id'];
         echo "$iduser";
        $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);
          exit;





 ?>

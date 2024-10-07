
            <?php
            $cont=0;
            // ciclo para recorrer el array de imagenes

              foreach ($_FILES["img_extra"]["name"] as $key => $value) {

                //Obtenemos la extensión del archivo
                $ext = explode('.', $_FILES["img_extra"]["name"][$key]);

                //Generamos un nuevo nombre del archivo, esto para no duplicar el nombre del archivo y que se sobreescriba.
                $renombrar = sha1($_FILES["img_extra"]["name"]).$cont.time();
                $nombre_final = $renombrar.".".$ext[1];

                //Se copian los archivos de la carpeta temporal del servidor a su ubicación final
                move_uploaded_file($_FILES["img_extra"]["tmp_name"][$key], "img/".$nombre_final);
                $cont++;
              }
            ?>

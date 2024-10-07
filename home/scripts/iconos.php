<div id="sidebar" class="users p-chat-user showChat">
    <div class="had-container">
        <div class="card card_main p-fixed users-main">
            <div class="user-box">
                <div class="chat-inner-header">
                    <div class="">
                        <div class="right-icon-control">
                            <input type="text" class="form-control search-text" placeholder="Search Friend" id="search-friends" />
                            <div class="form-icon">
                                <i class="icofont icofont-search"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-friend-list">
                  <?php
                 mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                  $query_lista = mysqli_query($conection,"SELECT *
              FROM `clientes` WHERE iduser = '$iduser'");
                      $result_lista= mysqli_num_rows($query_lista);
                    if ($result_lista > 0) {
                          while ($data_lista=mysqli_fetch_array($query_lista)) {
                            $url_img_upload_cliente     = $data_lista['url_img_upload'];
                            $foto_cliente               = $data_lista['foto'];

                   ?>
                    <div class="media userlist-box sacar_informacion_chat" codigo="<?php echo $data_lista['id'] ?>"  data-id="<?php echo $data_lista['id'] ?>" data-status="online" data-username="<?php echo $data_lista['nombres'] ?>" data-toggle="tooltip" data-placement="left" title="<?php echo $data_lista['nombres'] ?>">
                        <a class="media-left" href="#!">
                            <img class="media-object img-radius img-radius" src="<?php echo $url_img_upload_cliente ?>/home/img/uploads/<?php echo $foto_cliente ?>" alt="<?php echo $foto_cliente ?>" />
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="f-13 chat-header"><?php echo $data_lista['nombres'] ?></div>
                        </div>
                    </div>
                    <?php
                    }
                    }
                ?>



              </div>
          </div>
      </div>
    </div>
    </div>

<div class="showChat_inner ">
  <div class="media chat-inner-header">
      <a class="back_chatBox"> <i class="feather icon-chevron-left"></i> <span class="resultado_usuario_buscar_nombres" >Alex</span> </a>
  </div>
  <div class="resultado_mensajes_result">

  </div>
  <style media="screen">
    .resultado_mensajes_result {
      max-height: 300px; /* Ajusta según tus necesidades */
      overflow-y: auto;
      width: 90%;
    }
  </style>


  <div class="chat-reply-box p-b-20" style="/*! padding: 10px; */margin-bottom: 10px;">
    <form action="" method="post" name="agregar_datos_chat" id="agregar_datos_chat" onsubmit="event.preventDefault(); sendData_agregar_chat();">
          <div class="right-icon-control">
              <input type="text" class="form-control search-text" placeholder="Enviar Mensaje" name="mensaje"/>
              <input type="hidden" name="action" value="agregar_chat">
              <input type="hidden" name="usuario_ingreso" id="usuario_ingreso" value="">
              <button type="submit" class="form-icon">
                  <i class="feather icon-navigation"></i>
              </button>
          </div>
      </form>
  </div>

</div>

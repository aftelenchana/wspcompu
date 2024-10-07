
<?php

   $query=mysqli_query($conection,"SELECT * FROM `estrellas`
    WHERE id_producto='$idp'");
    $result_lista= mysqli_num_rows($query);
    if ($result_lista>0) {
      $sql_estrella = mysqli_query($conection,"SELECT COUNT(*) as  numero_calificaciones,SUM(estrellas.estrella) AS 'estrellas_totales' FROM   estrellas
      WHERE id_producto='$idp'");
      $data_estrella=mysqli_fetch_array($sql_estrella);
      $numero_calificaciones =  $data_estrella['numero_calificaciones'];
      $estrellas_totales =  $data_estrella['estrellas_totales'];
      $calificacion = round($estrellas_totales/$numero_calificaciones);
 }
       ?>
      <?php if ($result_lista == 0): ?>
        <div class="result_estrellas estrellas<?php echo $idp ?> ">
       <div class="star-icon">
       <form class="" action="index.html" method="post">
       <label style="font-weight: 1;" for="rating1" class="fa fa-star"></label><label style="font-weight: 1;"  for="rating2" class="fa fa-star"></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
       </form>
       </div>
       </div>
      <?php endif; ?>
      <?php if ($result_lista > 0): ?>
        <?php if ($calificacion == 1): ?>
          <div class="result_estrellas estrellas<?php echo $idp ?> ">
            <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;"  for="rating2" class="fa fa-star "></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
              </form>
            </div>
           </div>
          <?php endif; ?>
          <?php if ($calificacion == 2): ?>
            <div class="result_estrellas estrellas<?php echo $idp ?> ">
           <div class="star-icon">
           <form class="" action="index.html" method="post">
           <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating3" class="fa fa-star"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
           </form>
           </div>
           </div>
            <?php endif; ?>
            <?php if ($calificacion == 3): ?>
              <div class="result_estrellas estrellas<?php echo $idp ?> ">
              <div class="star-icon">
              <form class="" action="index.html" method="post">
                <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label  for="rating3" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating4" class="fa fa-star"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
            </form>
          </div>

        </div>
              <?php endif; ?>
              <?php if ($calificacion == 4): ?>
                <div class="result_estrellas estrellas<?php echo $idp ?> ">
                 <div class="star-icon">
                   <form class="" action="index.html" method="post">
                     <label for="rating1" class="fa fa-star estrella_pintada"></label><label  for="rating2" class="fa fa-star estrella_pintada"></label><label  for="rating3" class="fa fa-star estrella_pintada"></label><label  for="rating4" class="fa fa-star estrella_pintada"></label><label style="font-weight: 1;" for="rating5" class="fa fa-star"></label>
                   </form>
                 </div>
                   </div>
                <?php endif; ?>
                <?php if ($calificacion == 5): ?>
                  <div class="result_estrellas estrellas<?php echo $idp ?> ">
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
                  <?php endif; ?>


      <?php endif; ?>

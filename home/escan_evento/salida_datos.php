        <div class="titulo_datos">
            <h2 style="font-family: 'Varela Round', sans-serif;"> Bienvenido! </h2>
        </div>
        <br><br>
        <br><br>
    <div class="table-responsive">
      <table class="tabla_resultados" width="100%" cellspacing="0">                                 
        <thead>
            <tr>
              <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Código Escaneado</th> 
                <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Referencia</th>
              <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Estado</th>  
            </tr>
        </thead>
            <tbody>
            <?php 
            while ($row_expo = mysqli_fetch_array($listado_clientes)) { 
              ?>
                <tr>
                    <!--<td><?php //echo $row_expo['id'];?></td>-->
                     <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['codigo'];?></td>
                    <!--<td><?php //echo $row_expo['nombre']; ?></td>-->
                      <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['referencia'];?></td>
                   <!-- <td><?php //echo $row_expo['apellido']; ?></td>-->
                    <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['status']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
      </div>
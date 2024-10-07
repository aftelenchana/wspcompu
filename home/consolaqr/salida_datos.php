
<div class="titulo_datos">
    <h2 style="font-family: 'Varela Round', sans-serif;"> Bienvenido! </h2>
</div>
<br><br>
<br><br>
<div class="table-responsive">
<table class="tabla_resultados" width="100%" cellspacing="0">
<thead>
    <tr>
      <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Nombres:</th>
        <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Cedula:</th>
      <th style="color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;">Estado:</th>
    </tr>
</thead>
    <tbody>
    <?php
     $row_expo = mysqli_fetch_array($listado_clientes)
      ?>
        <tr>
            <!--<td><?php //echo $row_expo['id'];?></td>-->
             <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['nombres'];?> <?php echo $row_expo['apellidos'];?></td>
            <!--<td><?php //echo $row_expo['nombre']; ?></td>-->
              <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['numero_identidad'];?></td>
           <!-- <td><?php //echo $row_expo['apellido']; ?></td>-->
            <td style="text-align: center; color: #fff;font-size: 20px;font-family: 'Varela Round', sans-serif;"><?php echo $row_expo['estatdus_entrada_evento']; ?></td>
        </tr>

    </tbody>
</table>
</div>

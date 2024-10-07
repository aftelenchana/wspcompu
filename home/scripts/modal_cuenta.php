<div class="modal fade" id="modal_editar_foto_perfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Foto Perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form   method="post" name="add_form_add_logo_empresa" id="add_form_add_logo_empresa" onsubmit="event.preventDefault(); sendDataedit_add_logo_empresa();">
          <div class="resultado_imagen_upload" style="text-align: center;">
            <img style="width: 180px;"  src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo; ?>" alt="<?php echo $img_logo ?>">
          </div>


          <div class="form-group row">
               <span class="label-text col-md-2 col-form-label text-md-right">Foto Perfil</span>
               <div class="col-md-10">
                   <label class="custom-file">
                       <input type="file" name="foto" class="custom-file-input"  accept="image/png,image/jpeg" >
                       <span class="custom-file-label">Buscar</span>
                   </label>
               </div>
           </div>
            <div class="modal-footer">
              <input type="hidden" name="action" value="add_foto_logo_empresarial" required>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar Imagen</button>
            </div>

           <div class="notificacion_general_establecimiento">
           </div>
         </form>
      </div>
    </div>
  </div>
</div>

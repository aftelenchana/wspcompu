
        <div class="modal fade" id="modal_seo_imagen_temporal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel">Haz que tus clientes sientan la Navidad <?php echo $nombres ?></h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body text-center">
                <style media="screen">
                  .contenedor_imagen{
                    padding: 10px;
                    margin: 10px;
                  }
                </style>

                <div class="contenedor_imagen">
                  <div id="previewArea" style="position: relative; display: inline-block;">
                      <canvas id="logoCanvas" width="400" height="400"></canvas>
                  </div>
                  <div>
                      <label for="hatSize">Tamaño del Gorro:</label>
                      <input type="range" id="hatSize" min="0.1" max="1.0" step="0.1" value="0.4" oninput="drawImage()">
                  </div>
                  <div>
                      <label for="hatPositionX">Posición Horizontal del Gorro:</label>
                      <input type="range" id="hatPositionX" min="0" max="2" step="0.1" value="1.3" oninput="drawImage()">
                  </div>
                  <div>
                      <label for="hatPositionY">Posición Vertical del Gorro:</label>
                      <input type="range" id="hatPositionY" min="0" max="2" step="0.1" value="0.5" oninput="drawImage()">
                  </div>
              </div>


              </div>
              <div class="row">
                <div class="col" style="text-align: center;">
                  <button type="button" id="saveImage"  class="btn btn-success mobtn">Guardar</button>
                </div>
                <div class="col" style="text-align: center;">
                  <button type="button" id="no_guardar"  class="btn btn-info mobtn">No Guardar</button>
                </div>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Ver mas tarde <i class="fas fa-times-circle"></i></button>
              </div>
              <div class="notificacion_guardar_imagen_preseleccionada">

              </div>
            </div>
          </div>
        </div>

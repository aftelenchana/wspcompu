

<!-- Botón flotante -->
<div class="floating-chat-button" style="position: fixed; bottom: 20px; right: 20px; z-index: 999;">
    <button type="button" class="btn btn-primary chat-button boton_soporte_tecnico" >
        <i class="fas fa-comments" style="font-size: 24px; color: white;"></i>
    </button>
</div>



   <!-- Modal para el chat -->
   <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header" style="background-color: #FFC300;">
                   <h5 class="modal-title" id="chatModalLabel">Soporte y Ventas</h5>
                   <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                       <i class="fas fa-times"></i>
                   </button>
               </div>
               <div class="modal-body">
                   <!-- Simulación de contenido del chat -->
                   <div class="chat-messages resultado_mensajes_result">
                   <!-- Mensaje recibido -->
                   </div>

               </div>
               <div class="modal-footer">
                   <!-- Formulario para enviar mensaje -->
                   <form   class="d-flex align-items-center w-100" action="" method="post" name="mensajes_soporte" id="mensajes_soporte" onsubmit="event.preventDefault(); sendData_mensajes_soporte();">
                     <input type="hidden" name="action" value="empezar_chat">
                       <textarea class="form-control" id="mensaje_enviar_desde_cliente" name="mensaje" required placeholder="Escribe un mensaje..." style="margin-right: 10px;"></textarea>
                       <button type="submit" class="btn btn-primary">
                           <i class="fas fa-paper-plane"></i>
                       </button>
                   </form>
               </div>
           </div>
       </div>
   </div>

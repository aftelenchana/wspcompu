<?php

if ($_SESSION['rol'] == 'cuenta_empresa') {
require 'scripts/loader.php';
require 'scripts/iconos.php';
}



 if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
   require 'scripts_usuario_venta/loader.php';
 }

 if ($_SESSION['rol'] == 'Paciente') {
    require 'scripts_paciente/loader_paciente.php';
 }



 if ($_SESSION['rol'] == 'Recursos Humanos') {

   if ($_SESSION['rol_interno'] == 'Médico') {
      require 'scripts_recursos_humanos/loader_medico.php';
   }
   if ($_SESSION['rol_interno'] == 'Enfermeria') {
      require 'scripts_recursos_humanos/loader_enfermeria.php';
   }
   if ($_SESSION['rol_interno'] == 'Caja') {
      require 'scripts_recursos_humanos/loader_caja.php';
   }
   if ($_SESSION['rol_interno'] == 'Internista') {
      require 'scripts_recursos_humanos/loader_internista.php';
   }

   if ($_SESSION['rol_interno'] == 'Externista') {
      require 'scripts_recursos_humanos/loader_externista.php';
   }
   if ($_SESSION['rol_interno'] == 'Farmaceutico') {
      require 'scripts_recursos_humanos/loader_farmaceutico.php';
   }

   if ($_SESSION['rol_interno'] == 'Especialista') {
      require 'scripts_recursos_humanos/loader_especialista.php';
   }

   if ($_SESSION['rol_interno'] == 'Emergencia') {
      require 'scripts_recursos_humanos/loader_emergencia.php';
   }
  }
 ?>

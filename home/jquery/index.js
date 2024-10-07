function Actualizacion(){
  var tabla = $.ajax({
    url:'jquery/index.php',
    dataType:'text',
    async:false
  }).responseText;
  document.getElementById("miTabla").innerHTML = tabla;}
setInterval(Actualizacion, 50000);

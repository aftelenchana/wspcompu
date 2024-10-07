function calificar_1_estrella(){
  try{
    var    producto = (document.getElementById('id_producto').value) || 0;
           var action = 'calificar_1_estrella';
           $.ajax({
             url:'/home/jquery_producto/estrellas.php',
             type:'POST',
             async: true,
             data: {action:action,producto:producto},
              success: function(response){
              document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;

              },
              error:function(error){
                console.log(error);
                }

              });




  } catch (e){}
}
function calificar_2_estrella(){
  try{
    var    producto = (document.getElementById('id_producto').value) || 0;
           var action = 'calificar_2_estrella';
           $.ajax({
             url:'/home/jquery_producto/estrellas.php',
             type:'POST',
             async: true,
             data: {action:action,producto:producto},
              success: function(response){
              document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;

              },
              error:function(error){
                console.log(error);
                }

              });




  } catch (e){}
}

function calificar_3_estrella(){
  try{
    var    producto = (document.getElementById('id_producto').value) || 0;
           var action = 'calificar_3_estrella';
           $.ajax({
             url:'/home/jquery_producto/estrellas.php',
             type:'POST',
             async: true,
             data: {action:action,producto:producto},
              success: function(response){
              document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;

              },
              error:function(error){
                console.log(error);
                }

              });




  } catch (e){}
}


function calificar_4_estrella(){
  try{
    var    producto = (document.getElementById('id_producto').value) || 0;
           var action = 'calificar_4_estrella';
           $.ajax({
             url:'/home/jquery_producto/estrellas.php',
             type:'POST',
             async: true,
             data: {action:action,producto:producto},
              success: function(response){
              document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;

              },
              error:function(error){
                console.log(error);
                }

              });




  } catch (e){}
}


function calificar_5_estrella(){
  try{
    var    producto = (document.getElementById('id_producto').value) || 0;
           var action = 'calificar_5_estrella';
           $.ajax({
             url:'/home/jquery_producto/estrellas.php',
             type:'POST',
             async: true,
             data: {action:action,producto:producto},
              success: function(response){
              document.getElementById("calificacion_resultado").innerHTML = response;
              document.getElementById("calificacion_resultado2").innerHTML = response;

              },
              error:function(error){
                console.log(error);
                }

              });




  } catch (e){}
}

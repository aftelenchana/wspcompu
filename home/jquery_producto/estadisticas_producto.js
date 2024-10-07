$(document).ready(function(){
  var producto = parseFloat(document.getElementById('iproducto').value);
  var action = 'estadisticas';
    $.ajax({
      url:'jquery_producto/estadisticas_producto.php',
      type:'POST',
      async: true,
      data: {action:action,producto:producto},
       success: function(response){
         console.log(response);
         if (response != 'error') {
            var info = JSON.parse(response);
            var fecha_analisis = [];
            var cantidad_vistas = [];
            for (var i = 0; i < info.visitas.length; i++) {
              cantidad_vistas.push(info.visitas[i][0]);
              fecha_analisis.push(info.visitas[i][2]);
            }
            const ctx = document.getElementById('myChart');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fecha_analisis,
                    datasets: [{
                        label: 'Cantidad de Visistas por Fecha',
                        data: cantidad_vistas,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });



         }

       },
       error:function(error){
         console.log(error);
         }


       });


});

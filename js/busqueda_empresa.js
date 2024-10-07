document.addEventListener("DOMContentLoaded", function () {
  var campoBusqueda = document.getElementById("campo_busqueda");
  campoBusqueda.addEventListener("input", function (event) {
    var valorBusqueda = event.target.value;
    console.log("Valor de búsqueda:", valorBusqueda);
    var action = 'buscar_empresa';

    $.ajax({
      url: 'scripts/busqueda_empresa.php',
      type: 'POST',
      async: true,
      data: { action: action, valorBusqueda: valorBusqueda},
      success: function(response) {
        console.log(response);
        $('#list-prods').html(response);

      },
      error: function(error) {
        console.log(error);
      }
    });
  });
});

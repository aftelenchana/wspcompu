document.addEventListener("DOMContentLoaded", function () {
  var campoBusqueda = document.getElementById("campo_busqueda");
  var empresa = document.getElementById('empresa').value;
  campoBusqueda.addEventListener("input", function (event) {
    var valorBusqueda = event.target.value;
    console.log("Valor de búsqueda:", valorBusqueda);
      console.log("Valor de empresa:", empresa);
    var action = 'buscar_producto';

    $.ajax({
      url: 'scripts/busqueda_productos.php',
      type: 'POST',
      async: true,
        data: { action: action, valorBusqueda: valorBusqueda,empresa:empresa},
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

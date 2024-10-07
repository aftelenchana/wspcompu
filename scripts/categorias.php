<?php
  $user_in = 279;
 ?>

<nav class="menu" id="menu" style="margin: 0;padding: 0;">
  <div class="contenedor contenedor-botones-menu">
    <button id="btn-menu-barras" class="btn-menu-barras"><i class="fas fa-bars"></i></button>
    <button id="btn-menu-cerrar" class="btn-menu-cerrar"><i class="fas fa-times"></i></button>
  </div>

  <div class="contenedor contenedor-enlaces-nav">
    <div class="btn-departamentos" id="btn-departamentos">
      <p>Todos los <span>Departamentos</span></p>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="enlaces">
      <a href="/">Home</a>
      <a class="" href="https://hosting.guibis.com">Alojamiento</a>
      <a class="" href="/consulta_ruc">Api Ruc</a>
      <a class="" href="/mensajes_guibis_wsp">whatsapp Mensajes</a>
      <a class="" href="login?user_in=<?php echo $user_in ?>">Entrar</a>
      <a class="" href="regist?user_in=<?php echo $user_in ?>">Registrarte</a>
</div>
</div>

  <div class="contenedor contenedor-grid">
    <div class="grid" id="grid">
      <div class="categorias">
        <button class="btn-regresar"><i class="fas fa-arrow-left"></i> Regresar</button>
        <h3 class="subtitulo">Categorias</h3>

        <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras" data-categoria="tecnologia-y-computadoras">Tecnología y Computadoras <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=2&name=Libros" data-categoria="libros">Libros <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=3&name=Ropa y Accesorios" data-categoria="ropa-y-accesorios">Ropa y Accesorios <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=4&name=Hogar y Cocina" data-categoria="hogar-y-cocina">Hogar y Cocina <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=5&name=Juegos y Juguetes " data-categoria="juegos-y-juguetes">Juegos y Juguetes <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=6&name=Salud y Belleza " data-categoria="salud-y-belleza">Salud y Belleza <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=7&name=Alimentos y Bebidas" data-categoria="alimentos-y-bebidas">Alimentos y Bebidas <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=8&name=Eventos" data-categoria="eventos">Eventos <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=9&name=Cursos" data-categoria="cursos">Cursos <i class="fas fa-angle-right"></i></a>
        <a href="categorias.php?categorianum=10&name=Carros" data-categoria="carros">Carros <i class="fas fa-angle-right"></i></a>
      </div>

      <div class="contenedor-subcategorias">
        <div class="subcategoria " data-categoria="tecnologia-y-computadoras">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Tecnología y Computadoras</h3>
            <a href="subcategorias?subcategorianum=1&name=Laptops">Laptops</a>
            <a href="subcategorias?subcategorianum=2&name=Tablets">Tablets</a>
            <a href="subcategorias?subcategorianum=3&name=Computadoras de Escritorio">Computadoras de Escritorio</a>
            <a href="subcategorias?subcategorianum=4&name=Cuentas Digitales">Cuentas Digitales</a>
            <a href="subcategorias?subcategorianum=5&name=Celulares y Componentes"> Celulares y Componentes</a>
          </div>
          <div class="banner-subcategoria">
            <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras">
              <img src="/home/img/generales/tecnologia-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras">
              <img src="/home//img/tecnologia-galeria-1.png" alt="">
            </a>
            <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras">
              <img src="/home/img/generales/tecnologia-galeria-2.png" alt="">
            </a>
            <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras">
              <img src="/home/img/generales/tecnologia-galeria-3.png" alt="">
            </a>
            <a href="categorias.php?categorianum=1&name=Tecnología y Computadoras">
              <img src="/home/img/generales/tecnologia-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="libros">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Libros</h3>
            <a href="subcategorias?subcategorianum=6&name=Ciencia">Ciencia</a>
            <a href="subcategorias?subcategorianum=7&name=Ciencia Ficcion">Ciencia Ficcion</a>
            <a href="subcategorias?subcategorianum=8&name=Fantasia">Fantasia</a>
            <a href="subcategorias?subcategorianum=9&name=Miedo">Miedo</a>
          </div>

          <div class="banner-subcategoria">
            <a href="categorias.php?categorianum=2&name=Libros">
              <img src="/home/img/generales/libros-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="categorias.php?categorianum=2&name=Libros">
              <img src="/home/img/generales/libros-galeria-1.png" alt="">
            </a>
            <a href="categorias.php?categorianum=2&name=Libros">
              <img src="/home/img/generales/libros-galeria-2.png" alt="">
            </a>
            <a href="categorias.php?categorianum=2&name=Libros">
              <img src="/home/img/generales/libros-galeria-3.png" alt="">
            </a>
            <a href="categorias.php?categorianum=2&name=Libros">
              <img src="/home/img/generales/libros-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="ropa-y-accesorios">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Ropa y Accesorios</h3>
            <a href="subcategorias?subcategorianum=10&name=Ropa">Ropa</a>
            <a href="subcategorias?subcategorianum=11&name=Zapatos">Zapatos</a>
            <a href="subcategorias?subcategorianum=12&name=Accesorios">Accesorios</a>
            <a href="subcategorias?subcategorianum=13&name=Relojes">Relojes</a>
          </div>

          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/ropa-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home/img/generales/ropa-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/ropa-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/ropa-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/ropa-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="hogar-y-cocina">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Hogar y Cocina</h3>
            <a href="subcategorias?subcategorianum=14&name=Cocina">Cocina</a>
            <a href="subcategorias?subcategorianum=15&name=Electrodomesticos">Electrodomesticos</a>
            <a href="subcategorias?subcategorianum=16&name=Limpieza">Limpieza</a>
            <a href="subcategorias?subcategorianum=31&name=Baño">Baño</a>
            <a href="subcategorias?subcategorianum=17&name=Decoracion">Decoracion</a>
            <a href="subcategorias?subcategorianum=18&name=Arte">Arte</a>
            <a href="subcategorias?subcategorianum=19&name=Manualidades">Manualidades</a>
            <a href="subcategorias?subcategorianum=10&name=Jardin">Jardin</a>
          </div>

          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/hogar-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home/img/generales/hogar-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/hogar-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/hogar-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/hogar-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="juegos-y-juguetes">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Juegos y Juguetes</h3>
            <a href="subcategorias?subcategorianum=21&name=Juguetes">Juguetes</a>
            <a href="subcategorias?subcategorianum=22&name=Juegos de Mesa">Juegos de Mesa</a>
            <a href="subcategorias?subcategorianum=23&name=Aire Libre">Aire Libre</a>
            <a href="subcategorias?subcategorianum=24&name=Muñecas">Muñecas</a>
          </div>

          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/juegos-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home/img/generales/juegos-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/juegos-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/juegos-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/juegos-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="salud-y-belleza">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Salud y Belleza</h3>
            <a href="subcategorias?subcategorianum=25&name=Cuidado de la Piel">Cuidado de la Piel</a>
            <a href="subcategorias?subcategorianum=26&name=Maquillaje">Maquillaje</a>
            <a href="subcategorias?subcategorianum=27&name=Lociones">Lociones</a>
            <a href="subcategorias?subcategorianum=28&name=Shampoo">Shampoo</a>
          </div>

          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/belleza-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home/img/generales/belleza-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/belleza-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/belleza-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/belleza-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria" data-categoria="alimentos-y-bebidas">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Alimentos y Bebidas</h3>
            <a href="subcategorias?subcategorianum=29&name=Alimentos">Alimentos</a>
            <a href="subcategorias?subcategorianum=30&name=Bebidas">Bebidas</a>
          </div>

          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/comida-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home/img/generales/comida-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/comida-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/comida-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/comida-galeria-4.png" alt="">
            </a>
          </div>
        </div>
        <div class="subcategoria " data-categoria="eventos">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Eventos</h3>
            <a href="subcategorias?subcategorianum=32&name=Deportivos">Deportivos</a>
            <a href="subcategorias?subcategorianum=33&name=Culturales">Culturales</a>
            <a href="subcategorias?subcategorianum=34&name=Artisticos">Artisticos</a>
          </div>
          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/tecnologia-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home//img/tecnologia-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-4.png" alt="">
            </a>
          </div>
        </div>

        <div class="subcategoria " data-categoria="cursos">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Cursos</h3>
            <a href="subcategorias?subcategorianum=35&name=Informatica">Informatica</a>
            <a href="subcategorias?subcategorianum=36&name=Ciencia">Ciencia</a>
            <a href="subcategorias?subcategorianum=38&name=Ingles">Ingles</a>
              <a href="subcategorias?subcategorianum=37&name=Manualidades">Manualidades</a>
            <a href="subcategorias?subcategorianum=39&name=Casa">Casa</a>
          </div>
          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/tecnologia-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home//img/tecnologia-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-4.png" alt="">
            </a>
          </div>
        </div>
        <div class="subcategoria " data-categoria="carros">
          <div class="enlaces-subcategoria">
            <button class="btn-regresar"><i class="fas fa-arrow-left"></i>Regresar</button>
            <h3 class="subtitulo">Carros</h3>
            <a href="subcategorias?subcategorianum=40&name=Automoviles">Automoviles</a>
            <a href="subcategorias?subcategorianum=41&name=Camionetas">Camionetas</a>
            <a href="subcategorias?subcategorianum=42&name=Trups">Trups</a>
            <a href="subcategorias?subcategorianum=43&name=Bicicletas">Bicicletas</a>
          </div>
          <div class="banner-subcategoria">
            <a href="#">
              <img src="/home/img/generales/tecnologia-banner-1.png" alt="">
            </a>
          </div>

          <div class="galeria-subcategoria">
            <a href="#">
              <img src="/home//img/tecnologia-galeria-1.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-2.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-3.png" alt="">
            </a>
            <a href="#">
              <img src="/home/img/generales/tecnologia-galeria-4.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

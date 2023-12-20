<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="keywords" content="MediaMarkt, restaurante, comida, kebab, bocadillo, complementos, bebidas, pizzas, ofertas">
    <meta name="author" content="Alan Diaz">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Restaurante de MediaMarkt">
    <title>MediaMarkt Restaurante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css">
    <link href="assets/css/style_css.css" rel="stylesheet">
  </head>
  <body>
    <main>
      <section class="container mt-4">
          <section>
            <h2 class="mt-4 titulo_principal_pagina pb-4">Siéntete libre de navegar por nuestra página web</h2>
          </section>
          <section>
            <h2 class="py-3 pt-3 mb-3">Categorías destacadas</h2>
            <div class="row justify-content-between mx-0">
              <?php
                foreach ($AllCategorias as $categoria){
              ?>
              <a href=<?=url.'?controller=producto&action=productos'?> class="col-12 col-md-6 col-lg-2 border border-2 contenedor_categoria_destacada" style="background-image: url('<?=$categoria->getImagenCategoriaProducto()?>');" alt="Categorias destacadas">
                <h3 class="nombre_categoria_destacada"><?=$categoria->getNombreCategoria()?></h3>
              </a>
              <?php 
                } 
              ?>
            </div> 
          </section>
        <section>
          <h2 class="estilo_titulos_secciones py-3 mb-3">Productos destacados</h2>
          <div class="row justify-content-between mx-0">
            <?php
            foreach ($AllProductosDestacados as $producto_destacado){
            ?>
            <div class="col-12 col-md-6 col-lg-2 border border-2 contenedor_productos_destacados">
              <a href=<?=url.'?controller=producto&action=productos'?>>
                <div class="imagen_productos_destacados" style="background-image: url('<?=$producto_destacado->getImagen()?>');" alt="Productos destacados"></div>
                <div>
                  <img src="<?=$producto_destacado->getValoracion()?>" class="valoracion_producto_destacado">
                  <h3 class="titulo_producto_destacado"><?=$producto_destacado->getNombre()?></h3>
                  <p class="precio_producto_destacado"><?=$producto_destacado->getPrecio()?>€</p>
                  <p class="iva_producto_destacado">Iva inc. con envío gratis</p>
                </div>
              </a>
            </div>
            <?php 
            } 
            ?>
          </div>
        </section>
        <section>
          <div class="container my-3 pt-4">
            <div class="row justify-content-between">
              <div class="col-12 col-md-6 border border-2 rounded separacion_contenedores_individuales">
                <h2>¿Quiénes somos?</h2>
                <p>
                  Bienvenido a MediaMarkt, donde nuestra pasión por la comida nos impulsa a ofrecer lo mejor en nuestros
                  productos. En MediaMarkt, creemos que tu confianza es vital para nuestro funcionamiento. Fundada en
                  1979, nuestra empresa ha estado comprometida desde el principio en ofrecer la mejor calidad de alimentos del
                  mercado, ya que nos esforzamos constantemente por satisfacer los estómagos de nuestros clientes.
                </p>
                <p>Gracias por elegirnos.</p>
              </div>
              <div class="col-12 col-md-6 border border-2 rounded separacion_contenedores_individuales">
                <h2>Marcas con las que trabajamos</h2>
                <div class="row">
                  <div class="col-12 col-md-4" onclick="window.open('https://www.grupobimbo.com', '_blank');">
                    <div class="imagen_marcas" style="background-image: url('assets/imagenes/iconos/marcas/grupo_bimbo.svg');"></div>
                  </div>
                  <div class="col-12 col-md-4" onclick="window.open('https://empresa.nestle.es/es', '_blank');">
                    <div class="imagen_marcas" style="background-image: url('assets/imagenes/iconos/marcas/nestle.svg');"></div>
                  </div>
                  <div class="col-12 col-md-4" onclick="window.open('https://www.heinz.es', '_blank');">
                    <div class="imagen_marcas" style="background-image: url('assets/imagenes/iconos/marcas/heinz.svg');"></div>
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </section>
        <section>
          <div class="container my-3 pt-4 pb-4">
            <div class="row justify-content-between">
              <div class="col-12 col-md-6 border border-2 rounded separacion_contenedores_individuales">
                <h2>Únete a nuestra newsletter</h2>
                <form action=<?=url.'?controller=cliente&action=comprobarNewsletter'?> method="post">
                  <div class="row justify-content-center">
                    <img class="col-12 col-md-6" src="assets/imagenes/logos/logo.svg" alt="Logo del MediaMarkt">
                    <div class="col-12 col-md-6 d-flex flex-column">
                      <input class="contenedor_informacion_personal" type="email" id="email" name="email" placeholder="Tu correo" required>
                      <input class="contenedor_informacion_personal" type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    </div>
                  </div>
                  <div class="my-3 form-check-inline d-flex align-items-center">
                    <input type="checkbox" class="checkbox me-2" id="condiciones" name="condiciones" required>
                    <label for="condiciones" class="float-start">He leído y acepto las políticas de privacidad</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="boton_enviar">¡Me apunto!</button>
                  </div>
                </form>
              </div>
              <div class="col-12 col-md-6 border border-2 rounded separacion_contenedores_individuales">
                <h2>¿Tienes alguna duda?</h2>
                <div class="row dudas">
                  <div class="apartado_contacto form-check-inline p-2">
                    <img src="assets/imagenes/iconos/contacto/chat.svg" class="float-start me-2 ms-2" alt="Accede a nuestro chat">
                    <p class="texto_contacto"> Estaremos encantados de atenderte a través de nuestro chat</p>
                  </div>
                  <div class="apartado_contacto form-check-inline p-2">
                    <img src="assets/imagenes/iconos/contacto/chat.svg" class="float-start me-2 ms-2" alt="Preguntas frecuentes">
                    <p class="texto_contacto">Consulta nuestras <a class="enlaces_contacto" href="#"> Preguntas frecuentes</a></p>
                  </div>
                  <div class="apartado_contacto form-check-inline p-2">
                    <img src="assets/imagenes/iconos/contacto/archivos.svg" class="float-start me-2 ms-2" alt="Página de contacto">
                    <p class="texto_contacto">Escríbenos a través de la <a class="enlaces_contacto" href="#"> página de contacto</a></p>
                  </div>
                  <div class="apartado_contacto form-check-inline p-2">
                    <img src="assets/imagenes/iconos/contacto/archivos.svg" class="float-start me-2 ms-2" alt="Solicita tu factura aquí">
                    <p class="texto_contacto">Solicita tu factura <a class="enlaces_contacto" href="#"> aquí</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>
    </main>
  </body>
</html>
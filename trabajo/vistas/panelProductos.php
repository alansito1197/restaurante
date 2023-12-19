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
          <h2 class="mt-4 titulo_principal_pagina pb-4">Nuestra carta</h2>
        </section>
        <section class="row">
          <section class="col-12 col-sm-3">
            <hr class="my-2 col-12 col-sm-9">
            <div class="mt-1 mb-4">
              <form action="productos.php" method="POST">
                <label class="titulo_filtro mb-3 mt-2" for="categorias">Filtrar por categoría</label>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="categoriaSeleccionada" name="categoriaSeleccionada" value="Bocadillos">
                  <label class="opcion_filtro mb-3" for="bocadillos">Bocadillos</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="categoriaSeleccionada" name="categoriaSeleccionada" value="Kebabs">
                  <label class="opcion_filtro mb-3" for="kebabs">Kebabs</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="categoriaSeleccionada" name="categoriaSeleccionada" value="Pizzas">
                  <label class="opcion_filtro mb-3" for="pizzas">Pizzas</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="categoriaSeleccionada" name="categoriaSeleccionada" value="Complementos">
                  <label class="opcion_filtro mb-3" for="complementos">Complementos</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="categoriaSeleccionada" name="categoriaSeleccionada" value="Bebidas">
                  <label class="opcion_filtro mb-3" for="bebidas">Bebidas</label>
                </div>
              </form>
            </div>
            <hr class="my-2 col-12 col-sm-9">
            <div class="mt-1 mb-2">
              <form action="filtro_por_precio.php">
                <label class="titulo_filtro mb-3 mt-2" for="categorias">Filtrar por precio</label>
                <div class="col-6">
                  <div class="input-group mb-3">
                    <input type="number" class="form-control" id="desde" placeholder="Desde">
                    <div class="input-group-append">
                      <span class="input-group-text">€</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group mb-3">
                    <input type="number" class="form-control" id="hasta" placeholder="Hasta">
                    <div class="input-group-append">
                      <span class="input-group-text">€</span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="input-group">
                    <button type="submit" class="boton_enviar">Buscar</button>
                  </div>
                </div>
              </form>
            </div>
            <hr class="mb-3 my-2 col-12 col-sm-9">
            <div class="mt-1 mb-4">
              <form action="filtro_por_sabor.php">
                <label class="titulo_filtro mb-3 mt-2" for="sabor">Filtrar por sabor</label>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="salado" value="salado">
                  <label class="opcion_filtro mb-3" for="salado">Salado</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox float-start me-2" type="checkbox" id="dulce" value="dulce">
                  <label class="opcion_filtro mb-3" for="dulce">Dulce</label>
                </div>
              </form>
            </div>
            <hr class="my-2 col-12 col-sm-9">
            <div class="mt-2 mb-4">
              <form action="filtro_por_disponibilidad.php">
                <label class="titulo_filtro mb-3 mt-3" for="sabor">Filtrar por disponibilidad</label>
                <div class="filtro mb-2">
                  <input class="checkbox filtro_disponible float-start me-2" type="checkbox" id="disponible"
                    value="disponible">
                  <label class="opcion_filtro mb-3" for="disponible">Disponible</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox filtro_no_disponible float-start me-2" type="checkbox" id="no_disponible"
                    value="no_disponible">
                  <label class="opcion_filtro mb-3" for="no_disponible">No disponible</label>
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox filtro_proximamente float-start me-2" type="checkbox" id="proximamente"
                    value="proximamente">
                  <label class="opcion_filtro mb-3" for="proximamente">Próximamente</label>
                </div>
              </form>
            </div>
            <hr class="my-2 col-12 col-sm-9">
            <div class="mt-2 mb-4">
              <form action="filtro_por_valoracion.php">
                <label class="titulo_filtro mb-3 mt-3" for="sabor">Filtrar por valoración</label>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="cinco_estrellas" value="cinco_estrellas">
                  <img src="assets/imagenes/iconos/valoraciones/cinco_estrellas.svg" class="mb-3" alt="Cinco estrellas">
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="cuatro_estrellas" value="cuatro_estrellas">
                  <img src="assets/imagenes/iconos/valoraciones/cuatro_estrellas.svg" class="mb-3" alt="Cuatro estrellas">
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="tres_estrellas" value="tres_estrellas">
                  <img src="assets/imagenes/iconos/valoraciones/tres_estrellas.svg" class="mb-3" alt="Tres estrellas">
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="dos_estrellas" value="dos_estrellas">
                  <img src="assets/imagenes/iconos/valoraciones/dos_estrellas.svg" class="mb-3" alt="Dos estrellas">
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="una_estrella" value="una_estrella">
                  <img src="assets/imagenes/iconos/valoraciones/una_estrella.svg" class="mb-3" alt="Una estrella">
                </div>
                <div class="filtro mb-2">
                  <input class="checkbox" type="checkbox" id="cero_estrellas" value="cero_estrellas">
                  <img src="assets/imagenes/iconos/valoraciones/cero_estrellas.svg" class="mb-3" alt="Cero estrellas">
                </div>
              </form>
            </div>
            <hr class="mt-4 my-2 col-12 col-sm-9">
          </section>
          <section class="col-12 col-sm-9">
            <?php 
              foreach ($AllProductos as $producto){
              $color_disponibilidad = ProductoDAO::getDisponibilidad($producto->getDisponibilidad());
            ?>
            <div class="border border-2 contenedor_productos mb-4">
              <div class="row">

                <div class="col-4 mb-2 container_izquierda_producto column" style="background-image: url('<?=$producto->getImagen()?>');">
                  <h2 class="mt-2 titulo_producto"><?=$producto->getNombre()?></h2>
                  <?php
                        if (method_exists($producto, 'getTipoMasa')){
                          ?>
                          <img src="<?=$producto->getValoracion()?>" class="valoracion_producto_pizza" alt="Valoración del producto">
                          <?php
                        }else{
                          ?>
                          <img src="<?=$producto->getValoracion()?>" class="valoracion_producto" alt="Valoración del producto">
                        <?php
                        }
                      ?>
                </div>
                <div class="row col-7 flex-fill container_derecha_producto">
                  <div class="col-6">
                    <p class="titulo_apartado_producto">Sabor</p>
                    <p class="info_apartado_producto"><?=$producto->getSabor()?></p>
                    <p class="titulo_apartado_producto">Valor energético</p>
                    <p class="info_apartado_producto"><?=$producto->getValorEnergetico()?> kcal</p>
                    <p class="titulo_apartado_producto">Ingredientes</p>
                    <p class="info_apartado_producto"><?=$producto->getIngredientes()?></p>
                    <?php
                      if (method_exists($producto, 'getTipoMasa')){
                        ?>
                        <p class="titulo_apartado_producto">Tipo de masa</p>
                        <p class="info_apartado_producto"><?=$producto->getTipoMasa()?></p>
                        <?php
                      }
                    ?>
                  </div>
                  <div class="col-5 flex-fill">
                    <p class="precio_producto_productos"><?=$producto->getPrecio()?>€</p>
                    <p class="titulo_apartado_producto IVA">IVA incl. con envío gratis</p>
                    <ul class="lista_ordenada">
                      <li class="titulo_apartado_producto disponibilidad <?=$color_disponibilidad?>"><?=$producto->getDisponibilidad()?></li>
                      <p class="fecha_entrega">Entrega <?=date("d/m/Y")?></p>
                      <li class="recogida"><b>Recogida</b></li>
                      <p class="titulo_apartado_producto">Selecciona una tienda <b>Seleccionar tienda</b></p>
                    <ul>
                  </div>
                  <form action=<?=url.'?controller=producto&action=añadirCarrito'?> method='post'>
                    <div class="col-11 col-md-11 contenedor_boton row justify-content-end mt-3">
                      <button type='submit' class="boton_negro" name='id_producto' value='<?=$producto->getIdProducto();?>' > Añadir al carrito </button>
                      <div class="contenedor_megusta">
                        <img src="assets/imagenes/iconos/me_gusta.svg" alt="Me gusta">
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            <?php 
              } 
            ?>
          </section>
        </section>
      </section>
    </main>
  </body>
</html>
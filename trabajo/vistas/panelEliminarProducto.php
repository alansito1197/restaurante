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
    <main class="d-flex justify-content-center">
      <section class="container mt-4">
        <a class="enlace_registro mt-4" href=<?=url.'?controller=admin&action=solicitudGestionarProductos'?>> Volver al panel de productos</a>
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card border border-2">
              <div class="row">
                <div class="col-md-3 contenedor_producto_admin" style="background-image: url('<?=$productoActual->getImagen()?>');"></div>
                <div class="col-md-9">
                  <div class="card-body">
                    <h5 class="card-title"><?=$productoActual->getNombre()?></h5>
                    <p class="card-text">Sabor: <?=$productoActual->getSabor()?></p>
                    <p class="card-text">Valor Energético: <?=$productoActual->getValorEnergetico()?></p>
                    <p class="card-text">Precio: <?=$productoActual->getPrecio()?>€</p>
                    <p class="card-text">Disponibilidad: <?=$productoActual->getDisponibilidad()?></p>
                    <p class="card-text">Stock: <?=$productoActual->getStock()?></p>
                    <p class="card-text">Ingredientes: <?=$productoActual->getIngredientes()?></p>
                    <p class="card-text">Producto Destacado: <?=$productoActual->getProductoDestacado()?></p>
                    <?php
                      if (method_exists($productoActual, 'getTipoMasa')){
                        ?>
                          <p class="card-text">Tipo de masa: <?=$productoActual->getTipoMasa()?></p>
                        <?php
                      }
                    ?>
                    <div class="col-md-12 text-center d-flex justify-content-evenly">
                      <form action="<?=url.'?controller=admin&action=eliminarProducto'?>" method="POST">
                        <button class="boton_rojo">Eliminar producto</button>
                      </form>
                      <form action="<?=url.'?controller=admin&action=solicitudGestionarProductos'?>" method="POST">
                        <button class="boton_negro">Cancelar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>

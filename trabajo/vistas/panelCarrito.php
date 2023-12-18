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
          <h2 class="mt-4 titulo_principal_pagina pb-4">Carrito</h2>
          <?php
            include_once 'modelo/Pedido.php';
            // Calculamos la cantidad total de productos que tenemos en el carrito:
            $cantidad_productos = count($_SESSION['productosSeleccionados']);

            // Mostramos la cantidad de productos, especificamos que si es 1, aparezca la palabra "producto" y sino "productos"
            if ($cantidad_productos === 1) {
              echo "<p>1 producto</p>";
            } else {
              echo "<p>$cantidad_productos productos</p>";
            }
          ?>
        </section>
        <section class="row">
          <section class="col-12 col-sm-6">
            <?php
              $posicionPedido = 0;
              foreach ($_SESSION['productosSeleccionados'] as $pedidoSerialized) {
                $pedido = unserialize($pedidoSerialized);
            ?>
            <div class="border border-2 contenedor_productos rounded mb-4 pt-5">
              <div class="row justify-content-between">
                <div class="col-6 mb-2 imagen_producto_carrito" style="background-image: url('<?= $pedido->getProducto()->getImagen() ?>');"></div>
                  <div class="row col-6">
                    <p class="nombre_producto"><?= $pedido->getProducto()->getNombre() ?></p>
                    <p class="precio_producto_carrito"><?=number_format(calculadoraPrecios::precioProductoIndividual($pedido), 2) ?> €</p>
                    <p class="domicilio">Entrega a domicilio</p>
                    <a class="contenedor_basura" href="<?=url.'?controller=producto&action=eliminarProducto&id='.$posicionPedido?>">
                      <img src="assets/imagenes/iconos/basura.svg" alt="Eliminar producto del carrito">
                    </a>
                    <div class="editar_cantidad">
                      <form action="<?=url.'?controller=producto&action=modificarCantidad'?>" method='post'>
                        <button type="submit" name='restarCantidad' class="cantidad cantidad_restar" value=<?=$posicionPedido?>> - </button>
                        <span><?= $pedido->getCantidad()?></span>
                        <button type="submit" name='sumarCantidad' class="cantidad cantidad_sumar" value=<?=$posicionPedido?>> + </button>
                      </form>
                    </div>
                  </div>
              </div>
              <div class="row col-11 contenedor_opcion_comer">
                <form action="<?=url.'?controller=producto&action=personalizarPedido'?>" method='post'>
                  <h3 class="pregunta">Personaliza tu pedido</h3>
                  <div class="opcion_comer mb-2">
                    <input class="checkbox me-2 float-start" type="checkbox" name="opcionComer[]" value="causa_benefica">
                    <label for="tienda" class="texto_opcion mb-0">Donar para una causa benéfica</label>
                    <p class="precio_opcion mb-0">1€</p>
                  </div>
                  <div class="opcion_comer mb-2">
                    <input class="checkbox me-2 float-start" type="checkbox" name="opcionComer[]" value="xxl">
                    <label for="llevar" class="texto_opcion mb-0">Hacer mi producto XXL (50% más grande)</label>
                    <p class="precio_opcion mb-0">+ 2€</p>
                  </div>
                  <div class="opcion_comer mb-2">
                    <input class="checkbox me-2 float-start" type="checkbox" name="opcionComer[]" value="sin_personalizacion">
                    <label for="casa" class="texto_opcion mb-0">No deseo personalizar mi pedido</label>
                    <p class="precio_opcion mb-0">Gratis</p>
                  </div>
                  <div class="text-center mt-4">
                    <button type='submit' class="boton_enviar_carrito" name='producto_personalizado'> Enviar </button>
                  </div>
                </form>
              </div>
            </div>
            <?php
              $posicionPedido++;
              }
            ?>
            <div class="border border-2 rounded mb-4">
              <div class="row col-sm-11 contenedor_opcion_comer">
                <form action="<?=url.'?controller=producto&action=lugarConsumo'?>" method='post'>
                  <h3 class="pregunta">¿Dónde vas a comer?</h3>
                  <div class="opcion_comer mb-2">
                    <input type="radio" class="checkbox float-start me-2" type="checkbox" name="opcionComer" value="Gratis">
                    <label for="tienda" class="texto_opcion mb-0">Consumir en la tienda</label>
                    <p class="precio_opcion mb-0">Gratis</p>
                  </div>
                  <div class="opcion_comer mb-2">
                    <input type="radio" class="checkbox float-start me-2" type="checkbox" name="opcionComer" value="0,25€">
                    <label for="llevar" class="texto_opcion mb-0">El pedido es para llevar</label>
                    <p class="precio_opcion mb-0">+0,25€</p>
                  </div>
                  <div class="opcion_comer mb-2">
                    <input type="radio" class="checkbox float-start me-2" type="checkbox" name="opcionComer" value="5,25€">
                    <label for="casa" class="texto_opcion mb-0">Tráemelo a casa</label>
                    <p class="precio_opcion mb-0">+5,25€</p>
                  </div>
                  <div class="text-center mt-3">
                    <button type='submit' class="boton_enviar_carrito" name='seleccionarDondeConsumir'> Enviar </button>
                  </div>
                </form>
              </div>
            </div>
          </section>
          <section class="col-12 col-sm-4">
            <div class="fondo_resumen">
              <div class="margenes_laterales_resumen">
                <div class="col-12 margen_superior_resumen">
                  <h3 class="texto_resumen_total">Resumen</h3>
                  <p class="texto_cupones">Los cupones se pueden añadir durante el proceso de pago</p>
                  <hr class="col-12 col-sm-12">
                  <div class="contenedor_subtotal">
                    <p class="subtotal float-start me-3">Subtotal</p>
                    <p class="precio_subtotal"><?=number_format(calculadoraPrecios::precioSubtotalPedido($_SESSION['productosSeleccionados']), 2)?>€</p>
                  </div>
                  <div class="contenedor_precio_envio">
                    <p class="texto_producto_envio float-start">Coste de envío</p>
                    <?php
                      if (isset($_SESSION['opcionLugarConsumir'])) {
                        echo "<p class='precio_productos_envio'>".$_SESSION['opcionLugarConsumir']."</p>";
                      } else {
                        echo "<p class='precio_productos_envio'>Por definir</p>";
                      }
                    ?>
                  </div>
                  <hr class="col-12 col-sm-12 hr_sin_margin">
                  <div class="contenedor_precio_total mt-2">
                    <p class="texto_resumen_total">Total<p>
                    <?php
                      if (isset($_SESSION['precioTotalCarrito'])) {
                        echo "<p class='precio_total'>".number_format($_SESSION['precioTotalCarrito'], 2)."€</p>";
                      } else {
                        echo "<p class='precio_total'>Por definir</p>";
                      }
                    ?>
                  </div>
                  <p class="IVA">IVA incluido</p>
                  <div class="contenedor_tramitar_pedido">
                    <form action="<?=url.'?controller=pedido&action=tramitarPedido'?>" method='post'>
                      <button type="submit" class="tramitar_pedido" alt="Tramitar pedido">Tramitar pedido</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </section>
      </section>
    </main>
  </body>
</html>
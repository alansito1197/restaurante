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
    <main class="d-flex justify-content-center align-items-center">
      <section class="container mt-4">
        <a class="enlace_registro mt-4 " href="<?=url.'?controller=user&action=comprobarUsuario'?>">Volver al panel principal</a>
        <div class="row mt-4">
          <?php
            foreach ($AllPedidos as $pedidos) {
          ?>
            <div class="col-md-6 d-flex justify-content-center align-items-center"">
              <div class="card border border-2 p-2">
                <div class="card-body">
                  <h3 class="card-title-pedidos">Información del pedido con ID: <?=$pedidos->getIdPedido()?></h3>
                  <p class="card-text info_apartado_producto">ID del cliente: <?=$pedidos->getIdCliente()?></p>
                  <p class="card-text info_apartado_producto">Tipo de usuario que realiza la compra: <?=$pedidos->getTipoUsuario()?></p>
                  <p class="card-text info_apartado_producto">Precio total del pedido: <?=$pedidos->getPrecioTotal()?>€</p>
                  <p class="card-text info_apartado_producto">Fecha: <?=$pedidos->getFecha()?></p>
                  <p class="card-text info_apartado_producto">Estado: <?=$pedidos->getEstado()?></p>
                  <form class="mt-4" action="<?=url.'?controller=admin&action=gestionarPedido'?>" method='post'>
                    <div class="text-center">
                      <button type="submit" class="boton_negro_pedidos mb-2" name="modificar" value="<?=$pedidos->getIdPedido()?>">Modificar pedido</button>
                      <button type="submit" class="boton_rojo_pedidos mb-2" name="eliminar" value="<?=$pedidos->getIdPedido()?>">Eliminar pedido</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php 
            }
          ?>
        </div>
      </section>
    </main>
  </body>
</html>
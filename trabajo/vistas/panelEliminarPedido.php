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
    <main class="container mt-4">
      <h3 class="pb-2">¿Seguro que quieres eliminar el pedido?</h3>
      <a class="enlace_registro mt-4" href=<?=url.'?controller=admin&action=solicitudGestionarPedidos'?>> Volver al panel de pedidos</a>
      <div class="row mt-4 d-flex justify-content-center align-items-center">
        <div class="col-md-6">
          <div class="card border border-2">
            <div class="row">
              <div class="col-md-9">
                <div class="card-body">
                  <h3 class="card-title-pedidos mt-4">Ficha técnica del pedido</h3>
                  <p class="card-text info_apartado_producto">ID del pedido: <?=$pedidoActual->getIdPedido()?></p>
                  <p class="card-text info_apartado_producto">ID del cliente: <?=$pedidoActual->getIdCliente()?></p>
                  <p class="card-text info_apartado_producto">Tipo de usuario que ha realizado la compra: <?=$pedidoActual->getTipoUsuario()?></p>
                  <p class="card-text info_apartado_producto">Precio total del pedido: <?=$pedidoActual->getPrecioTotal()?>€</p>
                  <p class="card-text info_apartado_producto">Fecha: <?=$pedidoActual->getFecha()?></p>
                  <p class="card-text info_apartado_producto">Estado: <?=$pedidoActual->getEstado()?></p>
                  <div class="col-md-12 text-center">
                    <form class=" d-flex justify-content-center align-items-center" action="<?=url.'?controller=admin&action=eliminarPedidoSeleccionado'?>" method="POST" class="row">
                      <div class="col-md-6">
                        <input type="hidden" name="idPedido" value="<?=$pedidoActual->getIdPedido()?>">
                        <button type="submit" class="boton_rojo_eliminar_pedido btn-block" name="eliminar" value="<?=$pedidoActual->getIdPedido()?>">Eliminar pedido</button>
                      </div>
                      <div class="col-md-6">
                        <button type="submit" class="boton_negro_eliminar_pedido btn-block" name="cancelar">Cancelar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>

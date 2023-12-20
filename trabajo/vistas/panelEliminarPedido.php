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
        <div class="col-md-6 d-flex justify-content-center align-items-center"">
              <div class="card border border-2 p-2">
                <div class="card-body">
                  <h3 class="card-title-pedidos">Información del pedido con ID: <?=$pedidoActual->getIdPedido()?></h3>
                  <p class="card-text info_apartado_producto">ID del cliente: <?=$pedidoActual->getIdCliente()?></p>
                  <p class="card-text info_apartado_producto">Tipo de usuario que realiza la compra: <?=$pedidoActual->getTipoUsuario()?></p>
                  <p class="card-text info_apartado_producto">Precio total del pedido: <?=$pedidoActual->getPrecioTotal()?>€</p>
                  <p class="card-text info_apartado_producto">Fecha de tramitación: <?=$pedidoActual->getFecha()?></p>
                  <p class="card-text info_apartado_producto">Estado: <?=$pedidoActual->getEstado()?></p>
                  <form class="mt-4" action="<?=url.'?controller=admin&action=eliminarPedidoSeleccionado'?>" method='post'>
                    <div class="text-center">
                      <input type="hidden" name="idPedido" value="<?=$pedidoActual->getIdPedido()?>">  
                      <button type="submit" class="boton_rojo_pedidos mb-2" name="eliminar" value="<?=$pedidoActual->getIdPedido()?>">Eliminar pedido</button>
                      <button type="submit" class="boton_negro_pedidos mb-2" name="cancelar">Cancelar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
      </div>
    </main>
  </body>
</html>

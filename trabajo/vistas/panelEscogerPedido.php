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
    <style>
      /* Estilo adicional para los pedidos */
      .pedido_individual {
        background-color: #f8f9fa;
        border: 1px solid #dc3545;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 8px;
      }

      .info_pedido {
        margin: 5px 0;
      }
    </style>
  </head>
  <body>
    <main class="d-flex justify-content-center">
      <section class="container mt-4">
        <a class="enlace_registro pb-3 mt-4" href="<?=url.'?controller=user&action=comprobarUsuario'?>">Volver a mi panel de usuario</a>
        <div class="row">
        <?php
              $pedidos = $_SESSION['pedidos'] ?? [];
              foreach ($pedidos as $pedido) {
            ?>
            <div class="col-md-6">
              <div class="card border border-2">
                <div class="card-body">
                  <h5 class="card-title">ID del pedido: <?= $pedido['id_pedido'] ?></h5>
                  <p class="card-text">ID del cliente: <?= $pedido['id_cliente'] ?></p>
                  <p class="card-text">Tipo de usuario que realiza la compra: <?= $pedido['tipo_usuario'] ?></p>
                  <p class="card-text">Precio total del pedido: <?= number_format($pedido['precio_total'], 2) ?>€</p>
                  <p class="card-text">Fecha: <?= $pedido['fecha'] ?></p>
                  <p class="card-text">Estado: <?= $pedido['estado'] ?></p>
                  <form action="<?=url.'?controller=admin&action=gestionarPedido'?>" method='post'>
                    <div class="text-center">
                      <button type="submit" class="boton_negro mb-2" name="modificar" value="<?= $pedido['id_pedido'] ?>">Modificar pedido</button>
                      <button type="submit" class="boton_rojo mb-2" name="eliminar" value="<?= $pedido['id_pedido'] ?>">Eliminar pedido</button>
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

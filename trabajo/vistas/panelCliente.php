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
  <?php
      include_once 'modelo/PedidoDAO.php';
      $usuario_id = $_SESSION['usuario_id'];
      $tipo_usuario = $_SESSION['tipo_usuario'];
      $precioUltimoPedido = null;

      if (isset($_COOKIE['CookieUltimoPedido_' . $usuario_id . '_' . $tipo_usuario])) {
        $precioUltimoPedido = $_COOKIE['CookieUltimoPedido_' . $usuario_id . '_' . $tipo_usuario];
      }

      if ($precioUltimoPedido !== null) {
        $mensajeUltimoPedido = "Tu último pedido fue de " . number_format($precioUltimoPedido, 2) . "€";
      } else {
        $mensajeUltimoPedido = "Todavía no has realizado ningún pedido.";
      }
    ?>
    <main>
      <section class="container mt-4 d-flex justify-content-center align-items-center">
        <div class="container col-12 col-sm-6">
          <div class="row d-flex justify-content-center align-items-center">
            <h3 class="pregunta_login">¡Bienvenido!</h3>
            <p class="beneficios_login mt-3">Has iniciado sesión como <?= $_SESSION['usuario_nombre'] ?></p>
            <p><b><?= $mensajeUltimoPedido ?></b></p>
            <h1 class="pregunta_user">¿Qué quieres hacer?</h2> 
            <div class="row">
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=index&action=index'?>" method="POST">
                  <button class="boton_negro">Ir a la página principal</button>
                </form>
              </div>
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=producto&action=productos'?>" method="POST">
                  <button class="boton_negro">Empezar mi compra</button>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=cliente&action=solicitudModificacionCuenta'?>" method="POST">
                  <button class="boton_rojo">Modificar mi cuenta</button>
                </form>
              </div>
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=pedido&action=mostrarPedidosUsuario'?>" method="POST">
                  <button class="boton_rojo">Ver mis pedidos</button>
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=user&action=logout'?>" method="POST">
                  <button class="boton_rojo">Cerrar sesión</button>
                </form>
              </div>
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=cliente&action=solicitudEliminacionCuenta'?>" method="POST">
                  <button class="boton_rojo">Eliminar mi cuenta</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>

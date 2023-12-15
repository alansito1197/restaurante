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
        <div class="container col-12 col-sm-4">
          <div class="row">
            <h3 class="pregunta_login">¡Modifica el producto!</h3>
            <p class="beneficios_login mt-3">Siéntete libre de modificar el producto a tu gusto.</p>
            <a class="enlace_registro pb-3 mb-3" href="<?=url.'?controller=admin&action=solicitudGestionarProductos'?>"> Volver al panel de productos</a>
            <div class="row">
              <div class="col-md-6 text-center">
                <form action="<?= url.'?controller=admin&action=actualizarProductoSeleccionado'?>" method="POST">
                  <input type="text" class="contenedor_informacion_login" required name="nombre" value="<?=$productoActual->getNombre() ?>">
                  <input type="text" class="contenedor_informacion_login" required name="sabor" value="<?=$productoActual->getSabor() ?>">
                  <input type="text" class="contenedor_informacion_login"  required name="valor_energetico" value="<?=$productoActual->getValorEnergetico() ?>">
                  <input type="number" class="contenedor_informacion_login" required name="precio" value="<?=$productoActual->getPrecio() ?>">
                  <input type="text" class="contenedor_informacion_login" required name="disponibilidad" value="<?=$productoActual->getDisponibilidad() ?>">
                  <input type="number" class="contenedor_informacion_login" required name="stock" value="<?=$productoActual->getStock() ?>">
                  <input type="file" class="contenedor_informacion_login"  name="imagen" >
                  <input type="text" class="contenedor_informacion_login" required name="ingredientes" value="<?=$productoActual->getIngredientes() ?>">
                  <input type="number" class="contenedor_informacion_login" required name="producto_destacado" value="<?=$productoActual->getProductoDestacado() ?>">
                  <input type="password" class="contenedor_informacion_login" required placeholder="Contraseña para confirmar cambios" name="password">              
                  <button type="submit" class="iniciar_sesion mb-4" name="modificar_producto">Modificar producto</button>
                </form>
              </div>
              <?php if (isset($_SESSION['mensaje_acierto']) && !empty($_SESSION['mensaje_acierto'])): ?>
                <p class="mensaje_exito"><?php echo $_SESSION['mensaje_acierto']; ?></p>
                <?php unset($_SESSION['mensaje_acierto']); ?>
              <?php endif; ?>
              <?php if (isset($_SESSION['mensaje_error']) && !empty($_SESSION['mensaje_error'])): ?>
                <p class="mensaje_error"><?php echo $_SESSION['mensaje_error']; ?></p>
                <?php unset($_SESSION['mensaje_error']); ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
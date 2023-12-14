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
            <a class="enlace_registro pb-3" href="<?=url.'?controller=admin&action=solicitudGestionarProducto'?>"> Volver al panel de productos</a>
            <div class="row">
              <div class="col-md-6 text-center">
                <form action="<?= url.'?controller=admin&action=actualizarProductoSeleccionado'?>" method="POST">
                  <input type="text" class="contenedor_informacion_login" required name="nombre" value="<?=$productoActual['nombre']?>">
                  <input type="text" class="contenedor_informacion_login" required name="sabor" value="<?=$productoActual['sabor']?>" >
                  <input type="text" class="contenedor_informacion_login"  required name="valor_energetico" value="<?=$productoActual['valor_energetico']?>">
                  <input type="number" class="contenedor_informacion_login" required name="precio" value="<?=$productoActual['precio']?>">
                  <input type="text" class="contenedor_informacion_login" required name="disponibilidad" value="<?=$productoActual['disponibilidad']?>">
                  <input type="number" class="contenedor_informacion_login" required name="stock" value="<?=$productoActual['stock']?>">
                  <input type="file" class="contenedor_informacion_login"  name="imagen" value="<?=$productoActual['imagen']?>">
                  <input type="text" class="contenedor_informacion_login" required name="ingredientes" value="<?=$productoActual['ingredientes']?>">
                  <input type="number" class="contenedor_informacion_login" required name="producto_destacado" value="<?=$productoActual['producto_destacado']?>">
                  <input type="password" class="contenedor_informacion_login" required placeholder="Contraseña para confirmar cambios" name="password">              
                  <button type="submit" class="iniciar_sesion mb-4" name="modificar_producto">Modificar producto</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
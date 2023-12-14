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
        <a class="enlace_registro pb-3 mt-4" href=<?=url.'?controller=user&action=comprobarUsuario'?>> Volver a mi panel de usuario</a>
        <div class="row">
          <?php
            $productos = $_SESSION['productos'] ?? [];
            foreach ($productos as $producto) {
          ?>
            <div class="col-md-12">
              <div class="card border border-2">
                <div class="row">
                  <div class="col-md-3 contenedor_producto_admin" style="background-image: url('<?= $producto['imagen'] ?>');"></div>
                    <div class="col-md-9">
                      <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text">Sabor: <?= $producto['sabor'] ?></p>
                        <p class="card-text">Valor Energético: <?= $producto['valor_energetico'] ?></p>
                        <p class="card-text">Precio: <?= number_format($producto['precio'], 2) ?>€</p>
                        <p class="card-text">Disponibilidad: <?= $producto['disponibilidad'] ?></p>
                        <p class="card-text">Stock: <?= $producto['stock'] ?></p>
                        <p class="card-text">Ingredientes: <?= $producto['ingredientes'] ?></p>
                        <p class="card-text">Producto Destacado: <?= $producto['producto_destacado'] ? 'Sí' : 'No' ?></p>
                        <form action=<?=url.'?controller=admin&action=gestionarProducto'?> method='post'>
                          <div class="text-center">
                            <button type="submit" class="boton_negro mb-2" name="modificar" value="<?= $producto['id_producto'] ?>">Modificar producto</button>
                            <button type="submit" class="boton_rojo mb-2" name="eliminar" value="<?= $producto['id_producto'] ?>">Eliminar producto</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
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
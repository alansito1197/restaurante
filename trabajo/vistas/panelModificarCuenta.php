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
          <div class="row d-flex justify-content-center align-items-center">
            <h3 class="pregunta_login">¡Modifica tu cuenta!</h3>
            <p class="beneficios_login mt-3">Siéntete libre de modificar tus datos a tu gusto.</p>
            <a class="enlace_registro pb-3" href=<?=url.'?controller=user&action=comprobarUsuario'?>> Volver al panel principal</a>
            <div class="row">
              <div class="col-md-6 text-center">
                <form action="<?= url.'?controller=cliente&action=modificacionCuenta'?>" method="POST">
                  <input type="text" class="contenedor_informacion_login" name="nombre" value="<?=$cliente->getNombre() ?>">
                  <input type="text" class="contenedor_informacion_login" name="apellidos" value="<?=$cliente->getApellidos() ?>">
                  <input type="text" class="contenedor_informacion_login" name="direccion" value="<?=$cliente->getDireccion() ?>">
                  <input type="email" class="contenedor_informacion_login" name="email" value="<?=$cliente->getEmail() ?>">
                  <input type="number" class="contenedor_informacion_login" name="telefono" value="<?=$cliente->getTelefono() ?>">
                  <input type="password" class="contenedor_informacion_login" required placeholder="Contraseña para confirmar cambios" name="password">              
                  <button type="submit" class="iniciar_sesion mb-4" name="modificarCliente">¡Modifícame!</button>
                </form>
              </div>
              <?php if (isset($mensajeAcierto) && !empty($mensajeAcierto)): ?>
                <p class="mensaje_acierto"><?php echo $mensajeAcierto; ?></p>
              <?php endif; ?>
              <?php if (isset($mensajeError) && !empty($mensajeError)): ?>
                <p class="mensaje_error"><?php echo $mensajeError; ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
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
      <section class="container mt-4 d-flex justify-content-center align-items-center">
        <div class="container col-12 col-sm-4">
          <div class="row d-flex justify-content-center align-items-center">
            <h3 class="pregunta_login">¿Ya has iniciado sesión?</h3>
          <p class="beneficios_login mt-3 pb-3">Inicia sesión para aprovecharte de todos los beneficios de la cuenta de cliente de MediaMarkt. ¿Nuevo cliente? <a class="enlace_registro" href=<?=url.'?controller=cliente&action=solicitudRegistro'?>> Al registro</a></p>
          <div class="row">
            <div class="col-md-8">
              <form action=<?=url.'?controller=user&action=comprobarUsuario'?> method="POST">
                <input type="email" class="contenedor_informacion_login" placeholder="Correo electrónico" name="usuario" required>
                <input type="password" class="contenedor_informacion_login" placeholder="Contraseña" name="password" required >
                <p class="olvidar_contraseña pb-2 pt-1">¿Olvidaste tu contraseña?</p>
                <button type="submit" class="iniciar_sesion">Iniciar sesión</button>
              </form>
              <?php if (isset($mensajeError) && !empty($mensajeError)): ?>
                <p class="mensaje_error"><?php echo $mensajeError; ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        </div>
      </section>
    </main>
  </body>
</html>
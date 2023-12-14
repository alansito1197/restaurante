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
        <div class="container col-12 col-sm-5">
          <div class="row">
          <?php if (isset($mensaje_error)){ ?>
                <h3 class="pregunta_login"><?php echo $mensaje_error; ?></h3>
          <?php }else { ?>
            <h3 class="pregunta_login">¿Ya has iniciado sesión?</h3>
            <?php } ?>
          <p class="beneficios_login mt-3 pb-3">Inicia sesión para aprovecharte de todos los beneficios de la cuenta de cliente de MediaMarkt. ¿Nuevo cliente? <a class="enlace_registro" href=<?=url.'?controller=cliente&action=solicitudRegistro'?>> Al registro</a></p>
          <div class="row">
            <div class="col-md-8 text-center justify-content-center">
              <form action=<?=url.'?controller=user&action=comprobarUsuario'?> method="POST">
                <input type="email" class="contenedor_informacion_login" required placeholder="Correo electrónico" name="usuario">
                <input type="password" class="contenedor_informacion_login" required placeholder="Contraseña" name="password">
                <p class="olvidar_contraseña pb-3 pt-1">¿Olvidaste tu contraseña?</p>
                <button type="submit" class="iniciar_sesion mb-5">Iniciar sesión</button>
              </form>
              
            </div>
          </div>
        </div>
        </div>
      </section>
    </main>
  </body>
</html>
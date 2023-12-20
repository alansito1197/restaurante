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
        <div class="container col-12 col-md-5">
          <div class="row d-flex justify-content-center align-items-center">
            <h3 class="pregunta_login">¿Aún no te has registrado?</h3>
            <p class="beneficios_login mt-3">Registrate para aprovecharte de todos los beneficios de la cuenta de cliente de MediaMarkt.</p>
            <a class="enlace_registro pb-3" href=<?=url.'?controller=user&action=login'?>> Volver a inicio de sesión</a>
            <div class="row">
              <div class="col-md-8">
                <form action=<?=url.'?controller=cliente&action=registrarCliente'?> method="POST">
                  <input type="text" class="contenedor_informacion_login" required placeholder="Nombre" name="nombre">
                  <input type="text" class="contenedor_informacion_login" required placeholder="Apellidos" name="apellidos">
                  <input type="text" class="contenedor_informacion_login" required placeholder="Direccion" name="direccion">
                  <input type="email" class="contenedor_informacion_login" required placeholder="Correo electrónico" name="email">
                  <input type="number" class="contenedor_informacion_login" required placeholder="Teléfono" name="telefono">
                  <input type="password" class="contenedor_informacion_login" required placeholder="Contraseña" name="password">
                  <input type="password" class="contenedor_informacion_login" required placeholder="Confirma la contraseña" name="confirmacionPassword">
                  <button type="submit" class="iniciar_sesion mb-4">¡Allá vamos!</button>
                </form>  
              </div>
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
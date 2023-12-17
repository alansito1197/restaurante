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
        <div class="container col-12 col-sm-6">
          <div class="row">
            <h3 class="pregunta_login">¡Sentimos mucho que te vayas!</h3>
            <h2>¿Seguro que quieres eliminar tu cuenta?</h2> 
            <div class="row">
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=cliente&action=eliminacionCuenta'?>" method="POST">
                  <button class="boton_rojo">Eliminar mi cuenta</button>
                </form>
              </div>
              <div class="col-sm-6 mb-2">
                <form action="<?=url.'?controller=user&action=comprobarUsuario'?>" method="POST">
                  <button class="boton_negro">Me lo he pensado mejor</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>
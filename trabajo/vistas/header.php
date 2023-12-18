<!DOCTYPE html>
<html lang="es">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?=url.'?controller=producto&action=index'?>">
                    <img src="assets/imagenes/logos/logo_header.png" class="logo_header">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="justify-content-evenly collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link ir_a_la_carta" aria-current="page" href="<?=url.'?controller=producto&action=productos'?>">Ir a la carta</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control fs-5 input-lg border-radius-10" type="search" placeholder="¿Tienes hambre?" aria-label="Search">
                    </form>
                    <div class="mt-1">
                        <a class="navbar-brand estilo_carrito_login" href="<?=url.'?controller=producto&action=carrito'?>">
                            <img src="assets/imagenes/iconos/header/carrito.svg" class="contorno_icono">
                            <?php
                            
                                // Verificamos si la variable existe, es un array y su valor es 0 antes de contar los productos en el carrito:
                                $cantidadProductos = isset($_SESSION['productosSeleccionados']) ? count($_SESSION['productosSeleccionados']) : 0;

                                // Si hay productos en el carrito, mostramos la cantidad en el ícono del carrito:
                                if ($cantidadProductos > 0) {
                                    echo "<span>$cantidadProductos</span>";
                                }
                            ?>
                        </a>
                        <a class="navbar-brand estilo_carrito_login" href="<?=url.'?controller=user&action=login'?>">
                            <img src="assets/imagenes/iconos/header/usuario.svg" class="contorno_icono">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <section>
            <div class="container-fluid bg-black text-light border-2">
                <div class="row d-flex justify-content-center align-items-center">
                    <p class="col-4 text-center contenedor_negro mb-2 margen_izquierda">Sólo trabajamos con marcas reconocidas</p>
                    <p class="col-4 text-center contenedor_negro mb-2">Seriedad garantizada</p>
                    <p class="col-4 text-center contenedor_negro mb-2 margen_derecha">100% Comprometidos contigo</p>
                </div>
            </div>
        </section>
    </header>
</html>

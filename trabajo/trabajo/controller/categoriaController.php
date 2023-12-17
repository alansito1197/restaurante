<?php

    include_once 'config/dataBase.php';
    include_once 'modelo/CategoriaDAO.php';

    class CategoriaController {

        public function index() {

            include_once 'vistas/header.php';

            // Obtenemos todas las categorías llamando al metodo que las obtiene:
            $allCategorias = CategoriaDAO::getAllCategorias();

            // Verificaremos si se ha seleccionado una categoría
            if (isset($_POST['categoriaSeleccionada'])) {
                $categoriaSeleccionada = $_POST['categoriaSeleccionada'];

                // Obtendremos los productos de la categoría seleccionada
                //$productosPorCategoria = ProductoDAO::getProductosPorCategoria($categoriaSeleccionada);

                // Llamamos a la vista y le pasamos los productos filtrados
                include_once 'vistas/filtro_por_categoria.php';

            } else {
                // Llamamos a la vista principal con todas las categorías
                include_once 'vistas/principal.php';
            }

            include_once 'vistas/footer.php';
        }
    }
?>
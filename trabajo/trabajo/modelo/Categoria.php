<?php
    class Categoria {

        protected $id_categoria_producto;
        protected $nombre_categoria;
        protected $imagen_categoria_producto;


        public function __construct (){
        }

        public function getIdCategoriaProducto(){
                return $this->id_categoria_producto;
        }

        public function setIdCategoriaProducto($id_categoria_producto){
                $this->id_categoria_producto = $id_categoria_producto;
                return $this;
        }

        public function getNombreCategoria(){
                return $this->nombre_categoria;
        }

        public function setNombreCategoria($nombre_categoria){
                $this->nombre_categoria = $nombre_categoria;
                return $this;
        }

        public function getImagenCategoriaProducto(){
                return $this->imagen_categoria_producto;
        }

        public function setImagenCategoriaProducto($imagen_categoria_producto){
                $this->imagen_categoria_producto = $imagen_categoria_producto;
                return $this;
        }
}
?>
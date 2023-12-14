<?php
    class Producto {
        protected $id_producto;
        protected $id_empleado;
        protected $id_categoria_producto;
        protected $nombre;
        protected $sabor;
        protected $valor_energetico;
        protected $precio;
        protected $disponibilidad;
        protected $stock;
        protected $imagen;
        protected $ingredientes;
        protected $valoracion;
        public function __construct (){
                
        }

        public function getIdProducto(){
                return $this->id_producto;
        }

        public function setIdProducto($id_producto): self{
                $this->id_producto = $id_producto;
                return $this;
        }

        public function getIdEmpleado(){
                return $this->id_empleado;
        }

        public function setIdEmpleado($id_empleado): self{
                $this->id_empleado = $id_empleado;
                return $this;
        }

        public function getNombre(){
                return $this->nombre;
        }

        public function setNombre($nombre): self{
                $this->nombre = $nombre;
                return $this;
        }

        public function getSabor(){
                return $this->sabor;
        }

        public function setSabor($sabor): self{
                $this->sabor = $sabor;
                return $this;
        }

        public function getValorEnergetico(){
                return $this->valor_energetico;
        }

        public function setValorEnergetico($valor_energetico): self{
                $this->valor_energetico = $valor_energetico;
                return $this;
        }

        public function getPrecio(){
                return $this->precio;
        }

        public function setPrecio($precio): self{
                $this->precio = $precio;
                return $this;
        }

        public function getDisponibilidad(){
                return $this->disponibilidad;
        }

        public function setDisponibilidad($disponibilidad): self{
                $this->disponibilidad = $disponibilidad;
                return $this;
        }

        public function getStock(){
                return $this->stock;
        }

        public function setStock($stock): self{
                $this->stock = $stock;
                return $this;
        }

        public function getImagen(){
                return $this->imagen;
        }

        public function setImagen($imagen): self{
                $this->imagen = $imagen;
                return $this;
        }

        public function getIngredientes(){
                return $this->ingredientes;
        }

        public function setIngredientes($ingredientes): self{
                $this->ingredientes = $ingredientes;
                return $this;
        }

        public function getValoracion(){
                return $this->valoracion;
        }

        public function setValoracion($valoracion): self{
                $this->valoracion = $valoracion;
                return $this;
        }

        }
?>
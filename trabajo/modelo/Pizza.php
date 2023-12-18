<?php
    class Pizza extends Producto {
        
        protected $tipo_masa;
        public function __construct (){
                
        }

        public function getTipoMasa(){
                return $this->tipo_masa;
        }


        public function setTipoMasa($tipo_masa){
                $this->tipo_masa = $tipo_masa;
                return $this;
        }
}
?>
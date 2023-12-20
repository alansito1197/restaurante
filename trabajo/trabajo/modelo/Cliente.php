<?php
    class Cliente {
        
                protected $id_cliente;
                protected $nombre;
                protected $apellidos;
                protected $direccion;
                protected $email;
                protected $telefono;
                public function __construct (){
                        
                }

                public function getIdCliente(){
                        return $this->id_cliente;
                }

                public function setIdCliente($id_cliente){
                        $this->id_cliente = $id_cliente;
                        return $this;
                }

                public function getNombre(){
                        return $this->nombre;
                }

                public function setNombre($nombre){
                        $this->nombre = $nombre;
                        return $this;
                }

                public function getApellidos(){
                        return $this->apellidos;
                }

                public function setApellidos($apellidos){
                        $this->apellidos = $apellidos;
                        return $this;
                }

                public function getDireccion(){
                        return $this->direccion;
                }

                public function setDireccion($direccion){
                        $this->direccion = $direccion;
                        return $this;
                }

                public function getEmail(){
                        return $this->email;
                }

                public function setEmail($email){
                        $this->email = $email;
                        return $this;
                }

                public function getTelefono(){
                        return $this->telefono;
                }

                public function setTelefono($telefono){
                        $this->telefono = $telefono;
                        return $this;
                }

        }
?>
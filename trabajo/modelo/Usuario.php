<?php
    class Usuario {

        protected $id_usuario;
        protected $nombre;
        protected $apellidos;
        protected $direccion;
        protected $email;
        protected $telefono;

        public function __construct (){
      
        }

        public function getIdUsuario(){
                return $this->id_usuario;
        }

        public function setIdUsuario($id_usuario): self{
                $this->id_usuario = $id_usuario;
                return $this;
        }

        public function getNombre(){
                return $this->nombre;
        }

        public function setNombre($nombre): self{
                $this->nombre = $nombre;
                return $this;
        }

        public function getApellidos(){
                return $this->apellidos;
        }

        public function setApellidos($apellidos): self{
                $this->apellidos = $apellidos;
                return $this;
        }

        public function getDireccion(){
                return $this->direccion;
        }

        public function setDireccion($direccion): self{
                $this->direccion = $direccion;
                return $this;
        }

        public function getEmail(){
                return $this->email;
        }

        public function setEmail($email): self{
                $this->email = $email;
                return $this;
        }

        public function getTelefono(){
                return $this->telefono;
        }

        public function setTelefono($telefono): self{
                $this->telefono = $telefono;
                return $this;
        }
    }
?>
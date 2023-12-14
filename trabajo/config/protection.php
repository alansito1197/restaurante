<?php
    
    // Evitaremos intentar iniciar una nueva sesión si ya existe una sesión activa:
    
    if (session_status() == PHP_SESSION_NONE) {

        // Si no está iniciada, iniciaremos la sesión:
        session_start();
    }

    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre']) || !isset($_SESSION['password'])) {
        
        // Si el usuario no ha iniciado sesión previamente, no le permitiremos ver por ejemplo el carrito, le redirigiremos
        // a la página del login para que inicie sesión:

        header('Location:'.url.'?controller=user&action=login');
        exit(); // Asegurar que el script se detiene después de redirigir
    }
?>
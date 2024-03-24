<?php
//Abrimos la sesión, la destruimos y redirigimos al login de la aplicación
    session_start();
    session_destroy();
    header('Location: /Informatica/MilaE/Proyecto/index.php');
    ?>
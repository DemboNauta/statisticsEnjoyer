<?php
    $conn=new mysqli("localhost","root","1234","EstadisticasMilaE");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>
<?php
    $conn = new mysqli("localhost", "root", "1234", "EstadisticasMilaE");

    // Verificar la conexión
    include("../baseDatos/bbdd.php");

    $usuario=$_GET['usuario'];
    $nuevoNombre=$_GET['nombre'];
    $contrasena=$_GET['contrasena'];
    $contrasena=password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET usuario = ?, contrasena = ? WHERE usuario = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $nuevoNombre, $contrasena, $usuario);
    
        if ($stmt->execute()) {
            echo "Usuario actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
    
    // Cerrar la conexión
    $conn->close();

    header('Location: http://cifp1cuenca.ddns.net:81/Informatica/MilaE/Proyecto/administrador/gestionUsuarios.php');

    ?>
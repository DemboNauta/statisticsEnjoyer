<?php
if (isset($_GET['usuario'])) {
    $conn = new mysqli("localhost", "root", "1234", "EstadisticasMilaE");

    include("../baseDatos/bbdd.php");


    $sql = "DELETE FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $_GET['usuario']);

    if ($stmt->execute()) {
        echo "El usuario ha sido eliminado correctamente.";
    } else {
        echo "Error al intentar eliminar el usuario.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de usuario no válido.";
}

header('Location: http://cifp1cuenca.ddns.net:81/Informatica/MilaE/Proyecto/administrador/gestionUsuarios.php');
?>

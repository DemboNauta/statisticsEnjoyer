<?php
    session_start();
    if(isset($_POST['usuario'])){
        include("./baseDatos/bbdd.php");

        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        // Consulta preparada para evitar inyección SQL
        $consulta = $conn->prepare("SELECT * FROM usuarios WHERE usuario=?");
        $consulta->bind_param("s", $usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            // Verificar la contraseña con password_verify
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['contrasena'] = $usuario['contrasena'];
                if($usuario['perfil'] == "administrador") {
                    $_SESSION['admin'] = "si";
                    header('Location: /Informatica/MilaE/Proyecto/administrador/');
                } else {
                    header('Location: /Informatica/MilaE/Proyecto/usuario/');
                }
            } else {
                header('Location: /Informatica/MilaE/Proyecto/index.php?error=error');
            }
        } else {
            header('Location: /Informatica/MilaE/Proyecto/index.php?error=error');
        }

        $conn->close();
    }
    ?>



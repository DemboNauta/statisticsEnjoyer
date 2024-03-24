<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Enjoyer</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <script>
        window.onload = function() {
            
            function CookiesActivadas() {
                // Intentar crear una cookie
                document.cookie = "testcookie";
                var cookieEnabled = document.cookie.indexOf("testcookie") !== -1;
                // Eliminar la cookie de prueba
                document.cookie = "testcookie=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
                return cookieEnabled;
            }

            // Verificar si las cookies están habilitadas
            if (!CookiesActivadas()) {
                // Si las cookies no están habilitadas, mostrar un mensaje de alerta
                alert("Las cookies están desactivadas. Por favor, habilite las cookies en su navegador para continuar.");
            }
        }
    </script>
</head>
<body>
    <?php
        include("cabecera.php");
        if(isset($_GET['error'])){
            echo "<div id='formError'>Usuario y/o contraseña incorrecto</div>";
        }
    ?>
    <div class="container mt-4">
        <div class="formulario">
            <form action="validar_login.php" method="POST">
                <label for="usuario">Nombre de usuario o DNI: </label><br>
                <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario"><br>
                <label for="contraseña">Contraseña: </label><br>
                <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña"><br>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>
</body>
</html>

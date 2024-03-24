<pre>
<?php
include("./baseDatos/bbdd.php");
$tableName = "usuarios";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows > 0;

if (!$tableExists) {
    $sql = "CREATE TABLE $tableName (
        usuario VARCHAR(255) PRIMARY KEY,
        contrasena VARCHAR(255),
        perfil VARCHAR(255)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "La tabla $tableName ha sido creada correctamente ✅";
    } else {
        echo "Error al crear la tabla: $tableName" . $conn->error . "❌";
    }
    $tableName = "usuarios";
    $admin1 = "admin1";
    $password1 = "1234";
    $hashedPassword1 = password_hash($password1, PASSWORD_DEFAULT);
    $perfil1 = "administrador";

    $usuario1 = "usuario1";
    $password2 = "1234";
    $hashedPassword2 = password_hash($password2, PASSWORD_DEFAULT);
    $perfil2 = "usuario";

    // Insertar usuario 1
    $sqladmin1 = "INSERT INTO $tableName (usuario, contrasena, perfil) VALUES ('$admin1', '$hashedPassword1', '$perfil1')";

    $conn->query($sqladmin1);

    // Insertar usuario 2
    $sqlUsuario1 = "INSERT INTO $tableName (usuario, contrasena, perfil) VALUES ('$usuario1', '$hashedPassword2', '$perfil2')";

    $conn->query($sqlUsuario1);
    $conn->close();
} else {
    echo "La tabla $tableName ya existe.✅";
}




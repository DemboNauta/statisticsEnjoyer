<?php
session_start();
$usuario = $_SESSION['usuario'];
$admin= $_SESSION['admin'];
if(is_null($usuario)){
    header('Location: /Informatica/MilaE/Proyecto/');
}else if(is_null($admin)){
    header('Location: /Informatica/MilaE/Proyecto/');

}
include("../baseDatos/bbdd.php");

    if(isset($_POST["btnAñadir"])){
            $sql = "INSERT INTO usuarios (usuario, contrasena, perfil) VALUES (?, ?, 'usuario')";
            $stmt = $conn->prepare($sql);
            $nombreUsuario = trim($_POST["nombreUsuario"]);
            $contrasenaUsuario = $_POST["contrasenaUsuario"];
            $contrasenaCifrada = password_hash($contrasenaUsuario, PASSWORD_DEFAULT); 
        
            // Bind de los parámetros y ejecución de la consulta
            $stmt->bind_param("ss", $nombreUsuario, $contrasenaCifrada);
            $stmt->execute();
    
    }

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Enjoyer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/gestionUsuarios.css">
    <script src="../js/gestionUsuarios.js"></script>
    <script src="../js/script.js"></script>

</head>
<body>
    <?php
        include("cabecera.php");
    ?>

    <main class="container-fluid m-0 p-0">
        <div class="row">
            <div class="cabecera col-2">
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
                    <button id="sidebarCollapse"><i class="bi bi-caret-left-fill"></i></button>
                    <div class="position-sticky" id="textoSidebar">
                        <div class="list-group list-group-flush">
                        <a href="index.php" class="list-group-item list-group-item-action py-2 ripple">
                                <i class="fas fa-chart-line fa-fw me-3"></i><span>Generar Estadísticas</span>
                            </a>

                            <a href="compararEstadisticas.php"
                                class="list-group-item list-group-item-action py-2 ripple "><i
                                    class="fas fa-chart-line fa-fw me-3"></i><span>Comparar Estadísticas</span></a>
                                    
                            <a href="subirCSV.php" class="list-group-item list-group-item-action py-2 ripple">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Subir/Crear CSV</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                                <i class="fas fa-chart-line fa-fw me-3"></i><span>Gestión de Usuarios</span>
                            </a>
                            
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-10 d-flex justify-content-between">
                <div class="gestion w-75">
                    <div class="p-4">
                        <h2 class="text-center mb-4">Usuarios</h2>
                        <div class="table-responsive">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Contraseña</th>
                                        <th scope="col">Perfil</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                $conn=new mysqli("localhost","root","1234","EstadisticasMilaE");
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM usuarios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['usuario'] . "</td>";
                        echo "<td><input type='password' readonly value='".$row['contrasena'] . "' class='border-0 text-center contrasenaMost mx-3'/><button id='show_password' class='btn colorCIFP text-white' type='button' onclick='mostrarPassword(this)'> <span class='fa fa-eye-slash icon'></span> </button></td>";
                        echo "<td>" . $row['perfil'] . "</td>";
                        echo "<td>";
                        echo "<button class='px-3 btn btn-sm border border-black me-1 btn-editar' data-bs-toggle='modal' data-bs-target='#modificaModal' dataNom='".$row['usuario']."'>Editar</button>";
                        echo "<a href='../modificaUsuarios/borrarUsuario.php?usuario=" . $row['usuario'] . "' class='px-3 btn btn-danger btn-sm btn-borrar'>Borrar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No se encontraron usuarios.";
                }

                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn colorCIFP text-white " data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">+ Añadir Usuario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarUsuarioLabel">Añadir Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nombreUsuario" placeholder="Nombre/DNI">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="contrasenaUsuario" placeholder="Contraseña">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-boton text-white " data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn fondoNaranja text-white" name="btnAñadir">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    <div class="modal fade" id="modificaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-bordered">
    <div class="modal-content borde-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editando el usuario: <strong><span id="nomUsuEdi"></span></strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center gap-2">
        <input type="text" id="nuevoNomUsuario" placeholder="Nombre de usuario">
        <input type="text" id="nuevaContrasena" placeholder="Contraseña nueva">
      </div>
      <div class="modal-footer">
            <button type="button" class="btn bg-boton text-white " data-bs-dismiss="modal">Cerrar</button>
            <a id="enviarBtn" class="btn fondoNaranja text-white" href="#">Enviar</a>
        </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

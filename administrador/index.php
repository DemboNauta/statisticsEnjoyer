<?php
session_start();
$usuario = $_SESSION['usuario'];
$admin= $_SESSION['admin'];
if(is_null($usuario)){
    header('Location: /Informatica/MilaE/Proyecto/');
}else if(is_null($admin)){
    header('Location: /Informatica/MilaE/Proyecto/');
}
?>
<!DOCTYPE html>
<html lang="es-ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Enjoyer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/generarEstadisticas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="../js/generarEstadisticas.js"></script>
    <script src="../js/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    

</head>

<?php
    include("cabecera.php");
    include("../baseDatos/bbdd.php");

    
?>

<body>
    <main class="container-fluid p-0">
        <div class="row">
            <div class="cabecera col-2">
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar">
                <button id="sidebarCollapse"><i class="bi bi-caret-left-fill"></i></button>
                    <div class="position-sticky" id="textoSidebar">
                        <div class="list-group list-group-flush">
                            <a href="index.php"
                                class="list-group-item list-group-item-action py-2 ripple active"><i
                                    class="fas fa-chart-line fa-fw me-3"></i><span>Generar Estadísticas</span></a>
                            <a href="compararEstadisticas.php"
                                class="list-group-item list-group-item-action py-2 ripple "><i
                                    class="fas fa-chart-line fa-fw me-3"></i><span>Comparar Estadísticas</span></a>
                            <a href="subirCSV.php" class="list-group-item list-group-item-action py-2 ripple">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Subir/Crear CSV</span>
                            </a>
                            <a href="gestionUsuarios.php" class="list-group-item list-group-item-action py-2 ripple "><i
                                    class="fas fa-lock fa-fw me-3"></i><span>Gestión de Usuarios</span></a>

                        </div>
                    </div>

                </nav>

            </div>
            <div class="col-8 d-grid gap-3">
                <form action="generarEstadisticas2.php" class="w-75 mx-auto">
                    <div class="d-flex justify-content-between  mb-4">
                        <button type="button" id="generarInforme" value="informe" class="btn btn-lg colorCIFP text-white">Generar informe Completo</button>
                        <button type="sumbit" value="Generar" class="btn btn-lg colorCIFP text-white">Generar</button>
                    </div>
                    <div class="row opciones gap-3 genFamilia">
                        <div class="col">
                            <h5>Generar estadísticas por <strong>familia</strong></h5>
                            <select name="selectFamilia[]" id="selectFamilia" class="js-example-basic-multiple"
                                multiple="multiple">
                                <?php
                                $sql="SELECT DISTINCT FAMILIA FROM `tablaModulosEnlaces`;";
                                $result = $conn->query($sql);
                                if($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['FAMILIA']."'>".$row['FAMILIA']."</option>";
                                    }
                                }
                            ?>
                            </select><br>



                        </div>
                        <div class="col">
                            <h5>Generar estadísticas por <strong>grado</strong></h5>

                            <select name="selectGrado[]" id="selectGrado" class="js-example-basic-multiple"
                                multiple="multiple">
                                <?php
                                $sql="SELECT DISTINCT GRADO FROM `Plantilla`;";
                                $result = $conn->query($sql);
                                if($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['GRADO']."'>".$row['GRADO']."</option>";
                                    }
                                }
                            ?>
                            </select>
                            <br>

                        </div>
                        <div class="col">
                            <h5>Generar estadísticas por <strong>ciclo</strong></h5>

                            <select name="selectCiclo[]" id="selectCiclo" class="js-example-basic-multiple"
                                multiple="multiple">
                                <?php
                                $sql="SELECT DISTINCT CICLO FROM `tablaModulosEnlaces` ORDER BY FAMILIA, CURSO;";
                                $result = $conn->query($sql);
                                if($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['CICLO']."'>".$row['CICLO']."</option>";
                                    }
                                }
                            ?>
                            </select><br>

                        </div>
                    </div>
                    <div class="row opciones gap-3 mt-3">
                        <div class="col">
                            <h5>Generar estadísticas por <strong>Curso</strong></h5>

                            <select name="selectCurso[]" id="selectCurso" class="js-example-basic-multiple"
                                multiple="multiple">
                                <?php
                                $sql="SELECT DISTINCT CURSO FROM `tablaModulosEnlaces` ORDER BY CURSO;";
                                $result = $conn->query($sql);
                                print_r($result);
                                if($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['CURSO']."'>".$row['CURSO']."</option>";
                                    }
                                }
                            ?>
                            </select><br>

                        </div>
                        <div class="col-7">
                            <h5>Generar estadísticas por <strong>Módulo</strong></h5>

                            <select name="selectModulo[]" id="selectModulo" class="js-example-basic-multiple"
                                multiple="multiple">
                                <?php
                                $sql="SELECT DISTINCT modulo FROM `Plantilla` ORDER BY FAMILIA, CURSO;";
                                $result = $conn->query($sql);
                                if($result->num_rows>0){
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['modulo']."'>".$row['modulo']."</option>";
                                    }
                                }
                            ?>
                            </select><br>
                
            </div>
        </div>
        </div>
        <div class="col">
            
        </div>
        </form>
        </div>
        </div>


    </main>


    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
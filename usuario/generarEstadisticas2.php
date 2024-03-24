<?php
session_start();
$usuario = $_SESSION['usuario'];
$admin= $_SESSION['admin'];
if(is_null($usuario)){
    header('Location: /Informatica/MilaE/Proyecto/');
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Enjoyer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/generarEstadisticas.css">
    <script src="../js/gestionUsuarios.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/script.js"></script>


    
</head>
<?php
include("../administrador/cabecera.php");
include("../baseDatos/bbdd.php");

$resultados=Array();


?>
<main class="container-fluid mt-4 p-0">
    <div class="row">
        <div class="cabecera col-2">
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
                    <button id="sidebarCollapse"><i class="bi bi-caret-left-fill"></i></button>
                    <div class="position-sticky" id="textoSidebar">
                    <div class="list-group list-group-flush">
                        <a href="index.php" class="list-group-item list-group-item-action py-2 ripple active"><i
                            class="fas fa-chart-line fa-fw me-3"></i><span>Generar Estadísticas</span></a>
                        <a href="compararEstadisticas.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Comparar Estadísticas</span>
                        </a>
                        
                    </div>
                    </div>
                </nav>
        </div>
        <div class="col-6 d-grid gap-3">

        <?php
        
        function construirConsulta()
        {
            $where = [];
            if (isset($_GET['selectFamilia'])) {
                if(count($_GET['selectFamilia'])==1){
                    $where[] = "familia = '" . $_GET['selectFamilia'][0] . "'";
                }else{
                    $where[] = "familia IN ('".implode("' , '",$_GET['selectFamilia'])."')";
                }   
            }
            if (isset($_GET['selectGrado'])) {
                if(count($_GET['selectGrado'])==1){
                    $where[] = "grado= '" . $_GET['selectGrado'][0] . "'";
                }else{
                    $where[] = "gradoIN ('".implode("' , '",$_GET['selectGrado'])."')";
                }
            }
            if (isset($_GET['selectCiclo'])) {
                if(count($_GET['selectCiclo'])==1){
                    $where[] = "ciclo IN (SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces where CICLO = '" . $_GET['selectCiclo'][0] . "')";
                }else{
                    $where[] = "ciclo IN (SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces where CICLO IN ('".implode("' , '",$_GET['selectCiclo'])."'))";
                }
            }
            if (isset($_GET['selectCurso'])) {
                if(count($_GET['selectCurso'])==1){
                    $where[] = "curso = '" . $_GET['selectCurso'][0] . "'";
                }else{
                    $where[] = "curso IN ('".implode("' , '",$_GET['selectCurso'])."')";
                } 
            }
            if (isset($_GET['selectModulo'])) {
                if(count($_GET['selectModulo'])==1){
                    $where[] = "modulo = '" . $_GET['selectModulo'][0] . "'";
                }else{
                    $where[] = "modulo IN ('".implode("' , '",$_GET['selectModulo'])."')";
                }
            }
        
            $sql = "";
          
            if (!empty($where)) {
        
                $sql .= "SELECT P37, COUNT(*) AS frecuencia
                FROM Plantilla WHERE " . implode(' AND ', $where). " GROUP BY P37";
            } else {
                $sql = "SELECT P37, COUNT(*) AS frecuencia FROM Plantilla GROUP BY P37";
            }
            
           
            return $sql;
        }
        
        // Consulta para obtener los resultados
        $result = $conn->query(construirConsulta());

        // Array para almacenar los resultados
        $data = array();
        // Procesamos los resultados de la consulta
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $numero = $row["P37"];
                $frecuencia = $row["frecuencia"];
                $data[$numero] = $frecuencia;
            }
        } else {
            echo "<div id='noResultados'>No se encontraron resultados.</div>";
        }

        // Cerramos la conexión a la base de datos
        $conn->close();
        // Convertimos el array a formato JSON
        $json_data = json_encode($data);

        // Escribimos los datos en un archivo JSON
        $archivo_json = 'json/resultados.json';
        file_put_contents($archivo_json, $json_data);

        echo "<script src='../js/generarEstadisticas2.js'></script>";
        ?>
        <p>
        <?php

if (!empty($_GET)) {
    foreach ($_GET as $parametro => $valores) {
        echo implode(', ', $valores);
        echo "<br>";
    }
}
?>
        </p>
        <canvas id="bar-chart"></canvas>
    </div>

            
                

            <div class="col-2 mx-5">
                <p class="text-center"><strong>Media aritmética</strong></p>
                <div class="media">
                    <?php
                        $json_data = file_get_contents('json/resultados.json');
                        $data = json_decode($json_data, true);

                        $sum_multiplicaciones = 0;
                        $sum_total = 0;

                        foreach ($data as $numero => $cantidad) {
                            $sum_multiplicaciones += $numero * $cantidad;
                            $sum_total += $cantidad;
                        }

                        if ($sum_total > 0) {
                            $media = $sum_multiplicaciones / $sum_total;
                        }
                        $media=round($media, 2);
                        echo "<span id='media'>$media</span>";
                        ?>
                </div>
            </div>
        </div>
    </div>

    
                    
    
    
        




</main>

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
                <a href="index.php" class="list-group-item list-group-item-action py-2 ripple"><i
                        class="fas fa-chart-line fa-fw me-3"></i><span>Generar Estadísticas</span></a>
                        <a href="compararEstadisticas.php"
                                class="list-group-item list-group-item-action py-2 ripple active"><i
                                    class="fas fa-chart-line fa-fw me-3"></i><span>Comparar Estadísticas</span></a>
                    </a>
                    
                    
                </div>
                </div>
            </nav>
        </div>
        <div class="col-6 d-grid gap-3">

        <?php
        //Contruimos la consulta diferenciando entre los distintos selects que nos pueden hacer
        function construirConsulta()
        {
            $where = [];
            if (isset($_GET['selectFamilia'])) {
                    $where = "FAMILIA AS MODIFICADOR FROM Plantilla WHERE FAMILIA IN ('".implode("' , '",$_GET['selectFamilia'])."') GROUP BY FAMILIA";
            }
            if (isset($_GET['selectGrado'])) {
                    $where = "GRADO AS MODIFICADOR FROM Plantilla WHERE GRADO IN ('".implode("' , '",$_GET['selectGrado'])."') GROUP BY GRADO";
            }
            if (isset($_GET['selectCiclo'])) {
                if(count($_GET['selectCiclo'])==1){
                    $where = "CICLO AS MODIFICADOR FROM Plantilla WHERE CICLO IN (SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces where CICLO = '" . $_GET['selectCiclo'][0] . "') GROUP BY CURSO";

                }else{
                    $where = "CICLO AS MODIFICADOR FROM Plantilla WHERE CICLO IN (SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces where CICLO IN ('".implode("' , '",$_GET['selectCiclo'])."')) GROUP BY CICLO";

                }
            }
            if (isset($_GET['selectCurso'])) {
                    $where = "CURSO AS MODIFICADOR FROM Plantilla WHERE CURSO IN ('".implode("' , '",$_GET['selectCurso'])."') GROUP BY CURSO";
            }
            if (isset($_GET['selectModulo'])) {
                    $where = "MODULO AS MODIFICADOR FROM Plantilla WHERE MODULO IN ('".implode("' , '",$_GET['selectModulo'])."') GROUP BY MODULO";
            }
        
            $sql = "";
          
            if (!empty($where)) {
                $sql .= "SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL, "  . $where;
            }
            
           
            return $sql;
        }
        
        // Consulta para obtener los resultados
        $result = $conn->query(construirConsulta());

        //Consulta de los resultados del centro en general
        $centro = $conn->query("SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL FROM Plantilla");

        if ($centro->num_rows > 0) {
            $centro_row = $centro->fetch_assoc();
            $centro_media = round($centro_row["MEDIA"], 2);
            $centro_total = $centro_row["TOTAL"];
            
            // Agregar los datos del centro al array 
            $data[] = array(
                "media" => $centro_media,
                "total" => $centro_total,
                "modificador" => "Centro" 
            );
        }
        
            
            
        
        // Procesar los resultados de la consulta
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $media = round($row["MEDIA"],2);
                $total = $row["TOTAL"];
                $modificador = $row["MODIFICADOR"];
                
                $data[] = array(
                    "media" => $media,
                    "total" => $total,
                    "modificador" => $modificador
                );
            }
        } else {
            echo "<div id='noResultados'>No se encontraron resultados.</div>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        // Convertir el array a formato JSON
        $json_data = json_encode($data);

        // Escribir los datos en un archivo JSON
        $archivo_json = 'json/comparar.json';
        file_put_contents($archivo_json, $json_data);

        echo "<script src='../js/compararEstadisticas.js'></script>";
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

            
                

        

    
                    
    
    
        



    </div>
</main>

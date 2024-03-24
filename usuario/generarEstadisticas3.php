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
      <script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
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
         <div class="col-8 d-grid gap-3 divGraficos">
            <div class="w-75 d-flex"><button id="guardaImagenes" class="btn colorCIFP btn-sm text-white mx-auto w-25 mx-auto ">Generar PDF</button></div>
            <div class="tabla w-75">
            <?php

// Función para calcular la media de un grupo
function calcularMediaGrupo($grupo, $conn, $grupoNombre) {
    $media=0;
    $stmt = $conn->prepare("SELECT AVG(P37) FROM Plantilla WHERE $grupo = ?");
    $stmt->bind_param("s", $grupoNombre);
    $stmt->execute();
    $stmt->bind_result($media);
    $stmt->fetch();
    $stmt->close();
    return round($media, 2);
}
function calcularTotalGrupo($grupo, $conn, $grupoNombre) {
    $total=0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Plantilla WHERE $grupo = ?");
    $stmt->bind_param("s", $grupoNombre);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    return $total;
}

function calcularMediaCentro($conn) {
    $media = 0;
    $stmt = $conn->prepare("SELECT AVG(P37) FROM Plantilla");
    $stmt->execute();
    $stmt->bind_result($media);
    $stmt->fetch();
    $stmt->close();
    return round($media, 2);
}

function calcularTotalCentro($conn) {
    $total = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Plantilla");
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    return $total;
}

// Obtener datos de los grupos
$grupos = ['FAMILIA', 'Grado', 'CURSO'];
$datosGrupos = [];
foreach ($grupos as $grupo) {
    $datosGrupo = [];
    $stmt = $conn->prepare("SELECT DISTINCT $grupo FROM Plantilla ORDER BY $grupo");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $grupoNombre = $row[$grupo];
        $mediaGrupo = calcularMediaGrupo($grupo, $conn, $grupoNombre);
        $total = calcularTotalGrupo($grupo, $conn, $grupoNombre);
        
        $datosGrupo[$grupoNombre] = ['total' => $total, 'media' => $mediaGrupo];
    }
    $stmt->close();
    $datosGrupos[$grupo] = $datosGrupo;
}

echo '<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: arial;
        

    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;

        
    }
    th {
        background-color: #f2f2f2;
    }
    .grupo0 {
        background-color: white;
    }
    .grupo1 {
        background-color: #fb6c2a;
    }
    .grupo2 {
        background-color: #a9cce3; 
    }
    .centro {
        background-color: #d1f2eb; 
    }
    .spanrow {
        white-space: nowrap;
        text-align: center;
        background-color: #bfbbb0; 
    }
</style>';

echo '<table id="tabla">';
echo '<tr>';
echo '<th></th>';
echo '<th></th>';
echo '<th>Total Encuesta</th>';
echo '<th>Valoración Media</th>';
echo '</tr>';
echo '<tr class="centro">';
echo '<td></td>';
echo '<td>Centro</td>';
echo '<td>' . calcularTotalCentro($conn) . '</td>';
echo '<td>' . calcularMediaCentro($conn) . '</td>';
echo '</tr>';
$contador=0;
foreach ($datosGrupos as $grupo => $datosGrupo) {
    echo '<tr>';
    echo '<td rowspan="'.count($datosGrupo).'" class="spanrow">'.$grupo.'</td>';
    foreach ($datosGrupo as $grupoNombre => $datos) {
        echo '<td class="grupo' . $contador . '">' . $grupoNombre . '</td>';
        echo '<td class="grupo' . $contador . '">' . $datos['total'] . '</td>';
        echo '<td class="grupo' . $contador . '">' . $datos['media'] . '</td>';
        echo '</tr>';
    }
    $contador++;
}

echo '</table>';


?>

            </div>
            <?php
            $centro = $conn->query("SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL FROM Plantilla");

            // Consulta por familia
            $sqlPorFamilia = "SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL ,FAMILIA FROM Plantilla GROUP BY FAMILIA;";
            $result = $conn->query($sqlPorFamilia);

            // Array para almacenar los resultados
            $data = array();

            // Procesamos los resultados del centro
            if ($centro->num_rows > 0) {
                $centro_row = $centro->fetch_assoc();
                $centro_media = round($centro_row["MEDIA"], 2);
                $centro_total = $centro_row["TOTAL"];
                
                // Agregamos los datos del centro al array $data
                $data[] = array(
                    "media" => $centro_media,
                    "total" => $centro_total,
                    "familia" => "Centro" // 
                );
            }

            // Procesamos los resultados de la consulta por familia
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $media = round($row["MEDIA"], 2);
                    $total = $row["TOTAL"];
                    $familia = $row["FAMILIA"];

                    // Agregamos los datos al array $data
                    $data[] = array(
                        "media" => $media,
                        "total" => $total,
                        "familia" => $familia
                    );
                }
            } else {
                   echo "<div id='noResultados'>No se encontraron resultados.</div>";
               }
               $json_data = json_encode($data);
               $carpeta = 'json';

                // Comprobar si la carpeta no existe
                if (!file_exists($carpeta)) {
                    // Intentar crear la carpeta
                    if (!mkdir($carpeta)) {
                        // Error al crear la carpeta
                        echo "Error al crear la carpeta $carpeta";
                    }
                }
               // Escribimos los datos en un archivo JSON
               $archivo_json = 'json/estadisticasFamilia.json';
               file_put_contents($archivo_json, $json_data);
               
               echo "<script src='../js/generarEstadisticas3.js'></script>";
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


            <div class="w-75">
               <h3 class="text-center">MEDIA POR FAMILIA PROFESIONAL</h3>
               <canvas id="bar-chartFamilia"></canvas>
            </div>
         </div>
         
      </div>

      <div class="row">
         <div class="cabecera col-2"></div>
         <div class="col-6 d-grid gap-3 divGraficos">

            <?php
                $centro = $conn->query("SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL FROM Plantilla");
                $sqlPorNivelFormacion="SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL , GRADO FROM Plantilla GROUP BY GRADO;";
                
                $result = $conn->query($sqlPorNivelFormacion);
                $data = array();

                // Procesamos los resultados del centro
                if ($centro->num_rows > 0) {
                    $centro_row = $centro->fetch_assoc();
                    $centro_media = round($centro_row["MEDIA"], 2);
                    $centro_total = $centro_row["TOTAL"];
                    
                    // Agregamos los datos del centro al array $data
                    $data[] = array(
                        "media" => $centro_media,
                        "total" => $centro_total,
                        "grado" => "Centro" 
                    );
                }
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $media = round($row["MEDIA"],2); 
                        $total = $row["TOTAL"]; 
                        $grado = $row["GRADO"]; 
                
                        // Agregamos los datos al array $data
                        $data[] = array(
                            "media" => $media,
                            "total" => $total,
                            "grado" => $grado
                        );
                    }
                } else {
                    echo "<div id='noResultados'>No se encontraron resultados.</div>";
                }
                $json_data = json_encode($data);
                
                // Escribimos los datos en un archivo JSON
                $archivo_json = 'json/estadisticasGrado.json';
                file_put_contents($archivo_json, $json_data);
                
                echo "<script src='../js/generarEstadisticas3.js'></script>";
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
                <div class="w-75">
                    <h3 class="text-center">MEDIA POR NIVEL DE FORMACIÓN</h3>
                    <canvas id="bar-chartGrado"></canvas>
                </div>
        </div>

         
      </div>

      <div class="row">
         <div class="cabecera col-2"></div>
         <div class="col-6 d-grid gap-3 divGraficos">
            <?php
                $centro = $conn->query("SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL FROM Plantilla");
                $sqlPorCurso="SELECT AVG(p37) as MEDIA, COUNT(*) as TOTAL , CURSO FROM Plantilla GROUP BY CURSO;";
                
                $result = $conn->query($sqlPorCurso);
                $data = array();

                // Procesamos los resultados del centro
                if ($centro->num_rows > 0) {
                    $centro_row = $centro->fetch_assoc();
                    $centro_media = round($centro_row["MEDIA"], 2);
                    $centro_total = $centro_row["TOTAL"];
                    
                    // Agregamos los datos del centro al array $data
                    $data[] = array(
                        "media" => $centro_media,
                        "total" => $centro_total,
                        "curso" => "Centro" // 
                    );
                }
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $media = round($row["MEDIA"],2); 
                        $total = $row["TOTAL"]; 
                        $curso = $row["CURSO"]; 
                
                        // Agregamos los datos al array $data
                        $data[] = array(
                            "media" => $media,
                            "total" => $total,
                            "curso" => $curso
                        );
                    }
                } else {
                    echo "<div id='noResultados'>No se encontraron resultados.</div>";
                }
                $json_data = json_encode($data);
                
                // Escribimos los datos en un archivo JSON
                $archivo_json = 'json/estadisticasCurso.json';
                file_put_contents($archivo_json, $json_data);
                
                echo "<script src='../js/generarEstadisticas3.js'></script>";
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
                <div class="w-75">
                    <h3 class="text-center">MEDIA POR CURSO</h3>
                    <canvas id="bar-chartCurso"></canvas>
                </div>
        </div>

         
      </div>

      <div class="row">
         <div class="cabecera col-2"></div>
         <div class="col-8 d-grid gap-3 mx-auto">
            <?php
                $sqlParFamilia="SELECT FAMILIA, COUNT(*) AS Participacion, ROUND((COUNT(*) / (SELECT COUNT(*) FROM Plantilla)) * 100, 2) AS Porcentaje FROM Plantilla GROUP BY FAMILIA;";
                $result = $conn->query($sqlParFamilia);
                $data = array();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $participacion = $row["Participacion"]; 
                        $familia = $row["FAMILIA"]; 
                        $porcentaje = $row["Porcentaje"]; 
                
                        
                        $data[] = array(
                            "participacion" => $participacion,
                            "porcentaje"=>$porcentaje,
                            "familia" => $familia
                        );
                    }
                } else {
                    echo "<div id='noResultados'>No se encontraron resultados.</div>";
                }
                $json_data = json_encode($data);
                
                // Escribimos los datos en un archivo JSON
                $archivo_json = 'json/participacionFamilia.json';
                file_put_contents($archivo_json, $json_data);
                
                echo "<script src='../js/generarEstadisticas3.js'></script>";
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
                <div class="d-flex w-75">
                    <div>
                        <h3 class="text-center">% de PARTICIPACIÓN POR FAMILIAS</h3>
                        <canvas id="pie-chartFamilia"></canvas>
                    </div>
                    <div>
                        <h3 class="text-center">% de PARTICIPACIÓN POR NIVELES</h3>
                        <canvas id="pie-chartNivel"></canvas>
                    </div>
                    
            <?php
                $sqlParNivel="SELECT GRADO, COUNT(*) AS Participacion, ROUND((COUNT(*) / (SELECT COUNT(*) FROM Plantilla)) * 100, 2) AS Porcentaje FROM Plantilla GROUP BY grado;";
                $result = $conn->query($sqlParNivel);
                $data = array();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $participacion = $row["Participacion"]; 
                        $grado = $row["GRADO"]; 
                        $porcentaje = $row["Porcentaje"]; 
                
                        
                        $data[] = array(
                            "participacion" => $participacion,
                            "porcentaje"=>$porcentaje,
                            "grado" => $grado
                        );
                    }
                } else {
                    echo "<div id='noResultados'>No se encontraron resultados.</div>";
                }
                $json_data = json_encode($data);
                
                // Escribimos los datos en un archivo JSON
                $archivo_json = 'json/participacionNivel.json';
                file_put_contents($archivo_json, $json_data);
                
                echo "<script src='../js/generarEstadisticas3.js'></script>";
                ?>
            
                    
                </div>
        </div>
        <script src="../js/subirGraficos.js"></script>

         
      </div>
      </div>
   </main>
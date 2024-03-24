<?php
session_start();
$usuario = $_SESSION['usuario'];
$admin= $_SESSION['admin'];
if(is_null($usuario)){
    header('Location: /Informatica/MilaE/Proyecto/');
}
require_once('../tcpdf/tcpdf.php');


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecemos el título del documento
$pdf->SetTitle('Estadísticas Dirección');

// Agregamos una nueva página al documento
$pdf->AddPage();
// Contenido del PDF (la tabla)
include("../baseDatos/bbdd.php");
$pdf->Image('graficos/tabla.png', '', '', '200', '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);


// Agregamos una nueva página antes de añadir las imágenes
$pdf->AddPage();

// Insertamos las imágenes y agregamos un párrafo de descripción para cada una
$imagenes = array(
    'graficos/bar-chartFamilia.png' => 'MEDIA POR FAMILIA PROFESIONAL',
    'graficos/bar-chartGrado.png' => 'MEDIA POR NIVEL DE FORMACIÓN',
    'graficos/bar-chartCurso.png' => 'MEDIA POR CURSO',
    'graficos/pie-chartFamilia.png' => '% de PARTICIPACIÓN POR FAMILIAS',
    'graficos/pie-chartNivel.png' => '% de PARTICIPACIÓN POR NIVELES'
);

foreach ($imagenes as $imagen => $descripcion) {
    // Agregamos un párrafo para la descripción del gráfico
    $pdf->writeHTML("<p>$descripcion</p>");


    $tamanoImagen = (strpos($imagen, 'pie-chart') !== false) ? 100 : 150;

    // Insertamos cada imagen
    $pdf->Image($imagen, '', '', $tamanoImagen, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
    
    // Dejarmos un espacio en blanco dependiendo de si es un grafico de barras o de tipo pie
    if (strpos($imagen, 'pie-chart') !== false) {
        $pdf->Ln(110); 
    } else {
        $pdf->Ln(85);
    }
}

// Salida del PDF
$pdf->Output('EstadisticasDireccion.pdf', 'I');

// Cerrar conexión
$conn->close();
?>
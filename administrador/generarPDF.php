<?php
   session_start();
   $usuario = $_SESSION['usuario'];
   $admin= $_SESSION['admin'];
   if(is_null($usuario)){
       header('Location: /Informatica/MilaE/Proyecto/');
   }else if(is_null($admin)){
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


// Agregamos una nueva página antes de añadir las imágenes de los gráficos
$pdf->AddPage();

// Insertar las imágenes y agregar un párrafo de descripción para cada una
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

    // Tamaño las imágenes diferenciando para los que son de tipo pie
    $tamanoImagen = (strpos($imagen, 'pie-chart') !== false) ? 100 : 150;

    // Insertamos la imagen de cada gráfico
    $pdf->Image($imagen, '', '', $tamanoImagen, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
    
    // Dejar un espacio en blanco
    if (strpos($imagen, 'pie-chart') !== false) {
        $pdf->Ln(110); 
    } else {
        $pdf->Ln(85); 
    }
}


$pdf->Output('EstadisticasDireccion.pdf', 'I');


$conn->close();
?>
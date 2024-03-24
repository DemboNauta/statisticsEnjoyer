<?php

$carpetaGraficos = 'graficos/';

// Verificamos si la carpeta existe, y si no, la creamos
if (!file_exists($carpetaGraficos)) {
    mkdir($carpetaGraficos, 0777, true); 
} 

// Obtenermos los datos de la imagen 
$imageData = $_POST['imageData'];
$canvasId=$_POST['canvasId'];

//Esta solución tuve que buscar como podía ir guardando imagenes mediante sus datas, que las obtenemos con una libreria para pasar los canvas a imagenes.

$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
$imageData = base64_decode($imageData);

// Generamos un nombre para la imagen
$nombreImagen = $canvasId . '.png';

// Guardarmos la imagen en el servidor
file_put_contents('graficos/' . $nombreImagen, $imageData);


echo "Imagen guardada correctamente como $nombreImagen";
?>

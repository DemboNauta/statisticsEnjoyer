<?php
// Ruta del directorio a borrar
$rutaDirectorio = 'graficos/';

// Borrar el contenido del directorio
if (is_dir($rutaDirectorio)) {
    $archivos = glob($rutaDirectorio . '*', GLOB_MARK);
    foreach ($archivos as $archivo) {
        unlink($archivo);
    }
    echo 'Contenido del directorio borrado correctamente';
} else {
    echo 'El directorio no existe';
}
?>

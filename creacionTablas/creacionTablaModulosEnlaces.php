<pre>
<?php
header('Content-Encoding: UTF-8');
iconv_set_encoding("internal_encoding", "UTF-8");
include("./baseDatos/bbdd.php");

$tableName = "tablaModulosEnlaces";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows > 0;
$conn->set_charset("utf8mb4");

if (!$tableExists) {
    $sql = "CREATE TABLE $tableName (
        familia VARCHAR(30),
        grado VARCHAR(6),
        acronimo VARCHAR(20),
        ciclo VARCHAR(255),
        curso VARCHAR(3),
        modulo VARCHAR(255),
        nombreArchivoEncuesta VARCHAR(255),
        PRIMARY KEY (familia, grado, ciclo, modulo)
    )";

    if ($conn->query($sql)) {
        echo "La tabla $tableName ha sido creada correctamente ✅";
    } else {
        echo "Error al crear la tabla: $tableName" . $conn->error . "❌";
    }
    $handler = fopen("./csv/modulosCIFP.csv", 'r');

    if ($handler !== FALSE) {
        $stmt = $conn->prepare("INSERT INTO $tableName (familia, grado, acronimo, ciclo, curso, modulo, nombreArchivoEncuesta) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
                $stmt->bind_param("sssssss", $familia, $grado, $acronimo, $ciclo, $curso, $modulo, $enlace);

                $familia = $data[0];
                $grado = $data[1];
                $acronimo = $data[2];
                $ciclo = $data[3];
                $curso = $data[4];
                $modulo = $data[5];
                $enlace= $data[6];
            }

            $stmt->close();
        }
    mysqli_close($conn);
    }
}else {
    echo "La tabla $tableName ya existe.✅";
    $handler = fopen("./csv/modulosCIFP.csv", 'r');

    if ($handler !== FALSE) {

        $stmt = $conn->prepare("INSERT INTO $tableName (familia, grado, acronimo, ciclo, curso, modulo, nombreArchivoEncuesta) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
                $stmt->bind_param("sssssss", $familia, $grado, $acronimo, $ciclo, $curso, $modulo, $enlace);
                $familia = $data[0];
                $grado = $data[1];
                $acronimo = $data[2];
                $ciclo = $data[3];
                $curso = $data[4];
                $modulo = $data[5];
                $enlace= $data[6];

                $stmt->execute();
            }

            $stmt->close();
    }
    mysqli_close($conn);
}
}


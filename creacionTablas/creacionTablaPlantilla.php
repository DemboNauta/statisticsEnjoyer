<pre>
<?php
$handler = fopen("https://docs.google.com/spreadsheets/d/e/2PACX-1vRXfavC0JvQ5VOD3i5DprU8q3oAk1z3IMT5sk7D1W4qXJe90s4udxevrMKXwYGBZfnXeCR-bKs0ZLFU/pub?output=csv", 'r');
$arraydoble = [];

if ($handler !== FALSE) {
    while (($datos = fgetcsv($handler, 1000, ",")) !== FALSE) {
        $numero = count($datos);
        if ($numero == 99) {
            $arraySimple = [];
            for ($c = 0; $c < $numero; $c++) {
                if ($datos[$c] != '' || $c > 65) {
                    $arraySimple[] = $datos[$c];
                }
            }
            $arraydoble[] = $arraySimple;
        }
    }

    fclose($handler);
}


include("./baseDatos/bbdd.php");

$tableName = "Plantilla";
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows > 0;

if (!$tableExists) {
    $sql = "CREATE TABLE $tableName (
        horaI DATETIME ,
        horaF DATETIME UNIQUE,
        email VARCHAR(255) DEFAULT 'anonimo',
        nombre VARCHAR(255) DEFAULT 'anonimo',
        familia VARCHAR(255),
        grado VARCHAR(255),
        ciclo VARCHAR(255),
        curso VARCHAR(255),
        modulo VARCHAR(255),
        p1 VARCHAR(255),
        p2 VARCHAR(255),
        p3 VARCHAR(255),
        p4 VARCHAR(255),
        p5 VARCHAR(255),
        p6 VARCHAR(255),
        p7 VARCHAR(255),
        p8 VARCHAR(255),
        p9 VARCHAR(255),
        p10 VARCHAR(255),
        p11 VARCHAR(255),
        p12 VARCHAR(255),
        p13 VARCHAR(255),
        p14 VARCHAR(255),
        p15 VARCHAR(255),
        p16 VARCHAR(255),
        p17 VARCHAR(255),
        p18 VARCHAR(255),
        p19 VARCHAR(255),
        p20 VARCHAR(255),
        p21 VARCHAR(255),
        p22 VARCHAR(255),
        p23 VARCHAR(255),
        p24 VARCHAR(255),
        p25 VARCHAR(255),
        p26 VARCHAR(255),
        p27 VARCHAR(255),
        p28 VARCHAR(255),
        p29 VARCHAR(255),
        p30 VARCHAR(255),
        p31 VARCHAR(255),
        p32 VARCHAR(255),
        p33 VARCHAR(255),
        p34 VARCHAR(255),
        p35 VARCHAR(255),
        p36 VARCHAR(255),
        p37 VARCHAR(255)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "La tabla $tableName ha sido creada correctamente ✅";
    } else {
        echo "Error al crear la tabla: $tableName" . $conn->error . "❌";
    }
} else {
    echo "La tabla $tableName ya existe.✅";
}

foreach ($arraydoble as $dato) {
    
    $fechaHoraOriginal = $dato[0];
    $fechaHoraObj = DateTime::createFromFormat('d/m/Y H:i:s', $fechaHoraOriginal);
    $hora = $fechaHoraObj->format('Y/m/d H:i:s');
    $familia = $dato[1];
    $grado = $dato[2];
    $ciclo = $dato[3];
    if(substr($dato[3],-1) != 1 && substr($dato[3],-1) != 2 ){
        $curso="1º";
    }else{
        $curso = substr($dato[3],-1)."º";
    }
    
    $modulo = $dato[4];

    for ($i = 5; $i <= 41; $i++) {
        ${"p" . ($i - 4)} = $dato[$i];
    }

    $insertSQL = "INSERT INTO $tableName (horaI, horaF,familia, grado, ciclo, curso, modulo, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12, p13, p14, p15, p16, p17, p18, p19, p20, p21, p22, p23, p24, p25, p26, p27, p28, p29, p30, p31, p32, p33, p34, p35, p36, p37)
                  VALUES ('$hora','$hora','$familia', '$grado', '$ciclo', '$curso', '$modulo', '$p1', '$p2', '$p3', '$p4', '$p5', '$p6', '$p7', '$p8', '$p9', '$p10', '$p11', '$p12', '$p13', '$p14', '$p15', '$p16', '$p17', '$p18', '$p19', '$p20', '$p21', '$p22', '$p23', '$p24', '$p25', '$p26', '$p27', '$p28', '$p29', '$p30', '$p31', '$p32', '$p33', '$p34', '$p35', '$p36', '$p37')";

    $conn->query($insertSQL);
}
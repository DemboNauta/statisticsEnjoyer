<?php
    include("../baseDatos/bbdd.php");

    if(isset($_POST['subir'])){
        //Obtenemos el archivo que nos suben mediante $FILES
        $enlace=$_FILES['archivoCSV']['name'];
        $ciclo = $_POST['select'];
        //Actualizamos la tabla tablaModulosEnlaces con el enlace nuevo del archivo
        $stmt = $conn->prepare("UPDATE tablaModulosEnlaces SET nombreArchivoEncuesta=? WHERE acronimo=?");
        $stmt->bind_param('ss', $enlace, $ciclo);
        $stmt->execute();

        $tmp_name=$_FILES['archivoCSV']['tmp_name'];
        $handler = fopen($tmp_name, 'r');
        $arraydoble = [];
        $primero=true;
        //Iremos recorriendo cada fila del csv e iremos guardandolas en un array el cual luego trataremos para subirlo a la base de datos
        if ($handler !== FALSE) {
            while (($datos = fgetcsv($handler, 5000, ";")) !== FALSE) {
                $numero=count($datos);
                //Se pepiten la 38 y la 39
                    $arraySimple = [];
                    if(!$primero){
                        for ($c = 0; $c < $numero; $c++) {
                            if ($c != 0 && $c != 39) {
                                $arraySimple[] = $datos[$c];
                            }
                        }
                        $arraydoble[] = $arraySimple;

                    }
                    $primero=false;
                
            }

            fclose($handler);
        }
        //Recorremos el array y los vamos guardando en la base de datos
        foreach ($arraydoble as $dato) {
            $fechaHoraOriginal = $dato[0];
            $fechaHoraOriginalFin = $dato[1];
            $fechaHoraObj = DateTime::createFromFormat('d/m/Y H:i:s', $fechaHoraOriginal);
            $fechaHoraObjFin = DateTime::createFromFormat('d/m/Y H:i:s', $fechaHoraOriginalFin);
            $horaI = $fechaHoraObj->format('Y/m/d H:i:s');
            $horaF = $fechaHoraObjFin->format('Y/m/d H:i:s');
            $familia = $_POST['familia'];
            $ciclo = $_POST['select'];
            $ultima_letra_ciclo = substr($ciclo, -1);
            if ($ultima_letra_ciclo == '1' || $ultima_letra_ciclo == '2') {
                $curso = $ultima_letra_ciclo . 'º'; 
            }else if($ultima_letra_ciclo>2){
                $curso='2º';
            }
            else {
                $curso = '1º';
            }

            $grado=$_POST['grado'];
            $modulo = $dato[4];
            
            for ($i = 5; $i <= 41; $i++) {
                ${"p" . ($i - 4)} = $dato[$i];
            }
            $tableName="Plantilla";
            $insertSQL = "INSERT INTO $tableName (horaI, horaF,familia, grado, ciclo, curso, modulo, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12, p13, p14, p15, p16, p17, p18, p19, p20, p21, p22, p23, p24, p25, p26, p27, p28, p29, p30, p31, p32, p33, p34, p35, p36, p37)
                          VALUES ('$horaI','$horaF','$familia', '$grado', '$ciclo', '$curso', '$modulo', '$p1', '$p2', '$p3', '$p4', '$p5', '$p6', '$p7', '$p8', '$p9', '$p10', '$p11', '$p12', '$p13', '$p14', '$p15', '$p16', '$p17', '$p18', '$p19', '$p20', '$p21', '$p22', '$p23', '$p24', '$p25', '$p26', '$p27', '$p28', '$p29', '$p30', '$p31', '$p32', '$p33', '$p34', '$p35', '$p36', '$p37')";
        
            if ($conn->query($insertSQL) === FALSE) {
                echo "Error al insertar datos: " . $conn->error;
            }
        }

        
        echo "<script>window.close();</script>";


    }else if (isset($_POST['generar'])) {
        //Si se pulsa en generar haremos un selec a la bbdd con el ciclo adecuado y guardaremos los datos en un csv y lo descargaremos;
        $ciclo = $_POST['select'];
        $stmt = $conn->prepare("SELECT * FROM Plantilla WHERE ciclo = ?"); 
        echo $conn->error;  
        echo $stmt->error;  
        $stmt->bind_param('s', $ciclo);
        $stmt->execute();
    

        $result = $stmt->get_result();
    
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="archivo.csv"');
        $output = fopen('php://output', 'w');
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        $stmt->close();
        $conn->close();
    

    }
  
    


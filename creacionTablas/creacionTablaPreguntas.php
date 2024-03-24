<?php

include("./baseDatos/bbdd.php");


$tableName = "tablaPreguntas";

$preguntas = [
    "¿Se te ha informado de los resultados de aprendizaje del módulo profesional?",
    "¿Se te ha informado de los contenidos del módulo profesional y de su distribución por trimestres/evaluaciones?",
    "¿Se te ha informado del sistema de evaluación y de calificación empleados en el módulo profesional?",
    "¿Se te ha informado de los criterios de evaluación, de su ponderación y calificación?",
    "¿Se te han comunicado con suficiente antelación las fechas de realización y entrega de tareas y pruebas objetivas?",
    "¿Se ha informado del nº de faltas con las que se pierde el derecho a la evaluación continua y de sus efectos?",
    "VALORACIÓN DEL -BLOQUE 1- INFORMACIÓN SOBRE EL MÓDULO PROFESIONAL.",
    "OBSERVACIONES -BLOQUE 1- INFORMACIÓN SOBRE EL MÓDULO PROFESIONAL. (opcional)",
    "¿El profesor/a asiste con puntualidad a las clases?",
    "¿El profesor/a prepara bien sus clases?",
    "¿El profesor/a se explica con claridad y te permite seguir bien las clases?",
    "¿El profesor/a establece en cada U.T los objetivos a alcanzar?",
    "¿El profesor/a relaciona, entre sí, las diferentes UU.T del módulo?",
    "¿El profesor/a domina los contenidos del módulo que imparte?",
    "¿El profesor/a muestra interés y le gusta enseñar los contenidos del módulo que imparte?",
    "¿La asistencia a clase te ayuda, significativamente, a comprender los contenidos del módulo?",
    "¿El profesor/a sabe conectar y motivar al alumnado?",
    "¿El profesor/a responde/aclara las preguntas/dudas planteadas?",
    "¿El profesor/a mantiene un clima respetuoso y de trabajo en clase?",
    "¿El profesor/a promueve la participación del alumnado en clase?",
    "VALORACIÓN DEL -BLOQUE 2-     CLASES – PROFESOR/A.",
    "OBSERVACIONES -BLOQUE 2- CLASES – PROFESOR/A. (opcional)",
    "¿Consideras práctica y útil el Aula virtual para impartir las clases?",
    "¿Los medios empleados en clase te ayudan a entender lo explicado?",
    "¿Las actividades de las UU.T te ayudan a comprender, más y mejor, los contenidos?",
    "¿Las actividades, trabajos, prácticas de las UU.T te ayudan a  preparar los exámenes?",
    "VALORACIÓN DEL -BLOQUE 3-    RECURSOS EMPLEADOS EN EL MÓDULO PROFESIONAL.",
    "OBSERVACIONES - BLOQUE 3 - RECURSOS EMPLEADOS EN EL MÓDULO PROFESIONAL. (opcional)",
    "¿Tienen utilidad las correcciones que se hacen a las actividades entregadas?",
    "¿Te parece bien ser evaluado trimestralmente con varios instrumentos de evaluación, (ejercicios, trabajos, test, supuestos prácticos, pruebas objetivas)?",
    "¿Preferirías ser evaluado con una única prueba objetiva, (práctica y/o teórica) al trimestre?",
    "¿Las preguntas de los exámenes, (teóricas/prácticas), han sido, previamente,  explicadas en clase?",
    "¿Consideras objetivo, imparcial y justo el sistema de evaluación y calificación empleados?",
    "¿Cambiarías el sistema de evaluación y calificación empleados el módulo?",
    "VALORACIÓN DEL -BLOQUE 4-    SISTEMA DE EVALUACIÓN-CALIFICACIÓN EN EL MÓDULO.",
    "OBSERVACIONES - BLOQUE 4 - CSISTEMA DE EVALUACIÓN-CALIFICACIÓN EN EL MÓDULO. (opcional)",
    "SATISFACCIÓN FINAL DEL ÁMBITO/MÓDULO"
];

// Verificar si la tabla existe
$tableExists = $conn->query("SHOW TABLES LIKE '$tableName'")->num_rows > 0;

if (!$tableExists) {
    $sql = "CREATE TABLE $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pregunta VARCHAR(255) UNIQUE
    )";

    if ($conn->query($sql) === TRUE) {
        echo "La tabla $tableName ha sido creada correctamente ✅";
    } else {
        echo "Error al crear la tabla: $tableName" . $conn->error . "❌";
    }
    $sql = "INSERT INTO $tableName (pregunta) VALUES (?)";
    $statement = $conn->prepare($sql);

    foreach ($preguntas as $pregunta) {
        $statement->bind_param("s", $pregunta);
        $statement->execute();
    }

    $statement->close();
    $conn->close();
    } else {
        echo "<br>La tabla $tableName ya existe.✅";
    }

// Construir la consulta de inserción con parámetros preparados


?>

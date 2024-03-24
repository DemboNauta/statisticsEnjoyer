<?php
session_start();
$usuario = $_SESSION['usuario'];
$admin= $_SESSION['admin'];
if(is_null($usuario)){
    header('Location: /Informatica/MilaE/Proyecto/');
}else if(is_null($admin)){
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
    <script src="../js/gestionUsuarios.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/subirCSV.css">
    <script src="../js/script.js"></script>

</head>

<?php
    include("cabecera.php");
    include("../baseDatos/bbdd.php");

    
    
?>
<main class="container-fluid m-0 p-0">
    <div class="row">
    <div class="cabecera col-2">
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse">
                    <button id="sidebarCollapse"><i class="bi bi-caret-left-fill"></i></button>
                    <div class="position-sticky" id="textoSidebar">
                        <div class="list-group list-group-flush">
                        <a href="index.php" class="list-group-item list-group-item-action py-2 ripple">
                                <i class="fas fa-chart-line fa-fw me-3"></i><span>Generar Estadísticas</span>
                            </a>

                            <a href="compararEstadisticas.php"
                                class="list-group-item list-group-item-action py-2 ripple "><i
                                    class="fas fa-chart-line fa-fw me-3"></i><span>Comparar Estadísticas</span></a>
                                    
                            <a href="subirCSV.php" class="list-group-item list-group-item-action py-2 ripple active">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Subir/Crear CSV</span>
                            </a>
                            <a href="gestionUsuarios.php" class="list-group-item list-group-item-action py-2 ripple">
                                <i class="fas fa-chart-line fa-fw me-3"></i><span>Gestión de Usuarios</span>
                            </a>
                            
                        </div>
                    </div>
                </nav>
            </div>

    <div class="col-10 familias">
        <div class="row">
            <div class="col">
                <h5>Agraria</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectAgraria">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'AGRARIA'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>
                    <div>
        
                        <div>       
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label> 
                        </div>

                    </div><br>
                    <input type="hidden" name="familia" value="AGRARIA">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg ">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">

                </form>
            </div>

            <div class="col">
                <h5>Electricidad y electronica</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectElectricidad">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'ELECTRICIDAD Y ELECTRONICA'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>

                    <div>


                        <div>    
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label>
                        </div> 
                    </div><br>
                    <input type="hidden" name="familia" value="ELECTRICIDAD Y ELECTRONICA">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg ">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">

                </form>
            </div>

            <div class="col">
                <h5>Hosteleria y turismo</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectHosteleria">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'Hosteleria y turismo'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>
                    <div>
                        <div>    
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label>
                        </div> 
                    </div><br>
                    <input type="hidden" name="familia" value="Hosteleria y turismo">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">

                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h5>Imagen y sonido</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectImagen">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'Imagen y sonido'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>
                    <div>
                        <div>    
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label>
                        </div> 
                    </div><br>
                    <input type="hidden" name="familia" value="Imagen y sonido">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg ">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">

                </form>
            </div>

            <div class="col">
                <h5>Informatica y comunicaciones</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectInformatica">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'Informatica y comunicaciones'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>
                    <div>
                        <div>    
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label>
                        </div> 
                    </div><br>
                    <input type="hidden" name="familia" value="Informatica y comunicaciones">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg ">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">
                </form>

            </div>

            <div class="col">
                <h5>Instalaciones y mantenimiento</h5>
                <form action="subirCSV2.php" method="POST" enctype="multipart/form-data" target="_blank">
                    <select name="select" id="selectInstalaciones">
                        <?php
                            $sql="SELECT DISTINCT ACRONIMO FROM tablaModulosEnlaces WHERE FAMILIA = 'Instalaciones y mantenimiento'";
                            $result = $conn->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='".$row['ACRONIMO']."'>".$row['ACRONIMO']."</option>";
                                        }
                                    }
                        ?>
                    </select><br>
                    <div>

                        <div>
                            <label for="gradoAgraria">Grado Básico          
                            <input type="radio" name="grado" value="Grado Básico" required>
                            </label> 
                            <label for="gradoAgraria">Grado Medio          
                            <input type="radio" name="grado" value="Grado Medio" required>
                            </label> <br>
                            <label for="gradoAgraria">Grado Superior          
                            <input type="radio" name="grado" value="Grado Superior" required>
                            </label> 
                            <label for="gradoAgraria">Curso de Especialización         
                            <input type="radio" name="grado" value="Curso de Especialización " required>
                            </label> 
                        </div>
                    </div><br>
                    <input type="hidden" name="familia" value="Instalaciones y mantenimiento">
                    <input type="file" name="archivoCSV" placeholder="Sube tu enlace"><br>
                    <input type="submit" value="Subir csv" name="subir" class="btn colorCIFP text-white btn-lg ">
                    <input type="submit" value="Generar csv" name="generar" class="btn colorCIFP text-white btn-lg ">

                </form>
            </div>
        </div>
        
    </div>
    </div>
        
        
    
        




</main>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


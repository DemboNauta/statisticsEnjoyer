function guardarImagenes() {
    var canvasList = document.getElementsByTagName("canvas");
    var table = document.getElementById("tabla");
    var promises = []; 

    // Función para convertir la tabla a una imagen
    function convertirTablaAImagen(table) {
        html2canvas(document.getElementById("tabla"), {
            scale: 2, 
            onrendered: function(canvas) {
                var imageData = canvas.toDataURL("image/png", 1.0); 
                let canvasId = "tabla";
                promises.push(enviarImagenAlServidor(imageData, canvasId));
            }
        });
    }

    // Iterar sobre todos los canvas en la página
    for (var i = 0; i < canvasList.length; i++) {
        var canvas = canvasList[i];
        var imageData = canvas.toDataURL("image/png");
        let canvasId = canvas.id;

        // Enviar la imagen al servidor y almacenar la promesa resultante
        promises.push(enviarImagenAlServidor(imageData, canvasId));
    }

    // Convertir la tabla a una imagen y enviarla al servidor
    convertirTablaAImagen(table);

    // Devolver una promesa que se resolverá cuando todas las imágenes se envíen
    return Promise.all(promises);
}



function borrarContenidoDirectorio() {
    return fetch('borrarGraficos.php', {
        method: 'POST',
    })
    .then(response => {
        if (response.ok) {
            console.log('Contenido del directorio borrado correctamente');
        } else {
            console.error('Error al borrar el contenido del directorio');
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}

function enviarImagenAlServidor(imageData, canvasId) {
    return new Promise((resolve, reject) => {
        // Crear una solicitud AJAX para enviar la imagen al servidor
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "guardar_imagen.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log("Imagen guardada en el servidor");
                    resolve(); // Resolver la promesa cuando la imagen se haya guardado correctamente
                } else {
                    reject(new Error("Error al guardar la imagen en el servidor"));
                }
            }
        };

        // Adjuntar el ID del canvas junto con los datos de la imagen en la solicitud
        var data = "imageData=" + encodeURIComponent(imageData) + "&canvasId=" + encodeURIComponent(canvasId);
        xhr.send(data);
    });
}

window.addEventListener("load", () => {
    let botonGuardar = document.getElementById("guardaImagenes");
    botonGuardar.addEventListener("click", () => {
        borrarContenidoDirectorio()
            .then(() => guardarImagenes()) // Ejecutar guardarImagenes después de borrarContenidoDirectorio
            .then(() => {
                console.log("Todas las imágenes guardadas correctamente");
                // Abrir el enlace en una nueva ventana
                window.open('./generarPDF.php', '_blank');
            })
            .catch(error => console.error(error)); // Manejar cualquier error que ocurra
    });
});

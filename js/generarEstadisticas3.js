window.addEventListener("load", () => {
    let spansMedia = document.getElementsByClassName("media");
    for (let i = 0; i < spansMedia.length; i++) {
        let spanMedia = spansMedia[i];
        if (parseFloat(spanMedia.textContent) < 2.5) {
            spanMedia.style.color = "red";
        } else {
            spanMedia.style.color = "green";
        }
    }

    fetch('json/estadisticasFamilia.json')
    .then(response => response.json())
    .then(data => {
        // Obtener las etiquetas y datos del JSON
        const labels = data.map(entry => entry.familia);
        const values = data.map(entry => entry.media);

        // Destruir el gráfico anterior si existe
        if (window.barChartFamilia) {
            window.barChartFamilia.destroy();
        }

        // Crear el gráfico
        window.barChartFamilia = new Chart(document.getElementById("bar-chartFamilia"), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Media",
                    backgroundColor: "#e86b1c",
                    data: values
                }]
            },
            options: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Frecuencia de números del 0 al 5'
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });
    });

fetch('json/estadisticasGrado.json')
    .then(response => response.json())
    .then(data => {
        
        // Obtener las etiquetas y datos del JSON
        const labels = data.map(entry => entry.grado);
        const values = data.map(entry => entry.media);

        // Destruir el gráfico anterior si existe
        if (window.barChartGrado) {
            window.barChartGrado.destroy();
        }

        // Crear el gráfico
        window.barChartGrado = new Chart(document.getElementById("bar-chartGrado"), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Media",
                    backgroundColor: "#e86b1c",
                    data: values
                }]
            },
            options: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Frecuencia de números del 0 al 5'
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });
    });

fetch('json/estadisticasCurso.json')
    .then(response => response.json())
    .then(data => {
        
        // Obtener las etiquetas y datos del JSON
        const labels = data.map(entry => entry.curso);
        const values = data.map(entry => entry.media);

        // Destruir el gráfico anterior si existe
        if (window.barChartCurso) {
            window.barChartCurso.destroy();
        }

        // Crear el gráfico
        window.barChartCurso = new Chart(document.getElementById("bar-chartCurso"), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Media",
                    backgroundColor: "#e86b1c",
                    data: values
                }]
            },
            options: {
                legend: { display: true },
                title: {
                    display: true,
                    text: 'Frecuencia de números del 0 al 5'
                },
                plugins: {
                    labels: {
                        render: 'value'
                    }
                }
            }
        });
    });


        fetch('json/participacionFamilia.json')
    .then(response => response.json())
    .then(data => {
        
        // Obtener las etiquetas y datos del JSON
        const labels = data.map(entry => entry.familia);
        const values = data.map(entry => parseFloat(entry.porcentaje));
        
        // Definir colores de fondo
        const backgroundColors = ['#e86b1c', '#3e95cd', '#8e5ea2', '#3cba9f', '#c45850'];

        // Destruir el gráfico anterior si existe
        if (window.pieChartFamilia) {
            window.pieChartFamilia.destroy();
        }

        // Crear el gráfico
        window.pieChartFamilia = new Chart(document.getElementById("pie-chartFamilia"), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: "Participación",
                    backgroundColor: backgroundColors,
                    data: values
                }]
            },
            options: {
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: '#fff',
                        precision: 2, // Número de decimales para el porcentaje
                        fontSize: 17
                    }
                },
                title: {
                    display: true,
                    text: 'Participación por Familias'
                }
            }
        });
    });


    fetch('json/participacionNivel.json')
    .then(response => response.json())
    .then(data => {
        
        // Obtener las etiquetas y datos del JSON
        const labels = data.map(entry => entry.grado);
        const values = data.map(entry => parseFloat(entry.porcentaje));
        
        // Definir colores de fondo
        const backgroundColors = ['#e86b1c', '#3e95cd', '#8e5ea2', '#3cba9f', '#c45850'];

        // Destruir el gráfico anterior si existe
        if (window.piechartNivel) {
            window.piechartNivel.destroy();
        }

        // Crear el gráfico
        window.piechartNivel = new Chart(document.getElementById("pie-chartNivel"), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: "Participación",
                    backgroundColor: backgroundColors,
                    data: values
                }]
            },
            options: {
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: '#fff',
                        precision: 2, // Número de decimales para el porcentaje
                        fontSize: 17,

                    }
                },
                title: {
                    display: true,
                    text: 'Participación por Nivel'
                }
            }
        });
    });




        
    
});

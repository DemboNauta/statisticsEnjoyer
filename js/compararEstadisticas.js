window.addEventListener("load", () => {
  fetch('json/comparar.json')
        .then(response => response.json())
        .then(data => {
            // Obtener las etiquetas y datos del JSON
            const labels = data.map(item => item.modificador);
            const values = data.map(item => item.media);

            // Crear el gráfico
            new Chart(document.getElementById("bar-chart"), {
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
                        text: 'Media de los resultados'
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                let dataset = data.datasets[tooltipItem.datasetIndex];
                                let total = dataset.data[tooltipItem.index];
                                return total.toString();
                            }
                        }
                    }
                }
            });
        });
});

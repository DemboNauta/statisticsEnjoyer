window.addEventListener("load", ()=>{
  let spanMedia = document.getElementById("media");
  if(parseFloat(spanMedia.textContent)<2.5){
    spanMedia.style.color="red";
  }else{
    spanMedia.style.color="green";

  }

    fetch('json/resultados.json')
      .then(response => response.json())
      .then(data => {
        // Obtener las etiquetas y datos del JSON
        const labels = Object.keys(data);
        const values = Object.values(data);

        // Crear el gráfico
        new Chart(document.getElementById("bar-chart"), {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: "Frecuencia",
              backgroundColor: "#e86b1c",
              data: values
            }]
          },
          options: {
            legend: { display: true },
            title: {
              display: true,
              text: 'Frecuencia de números del 0 al 5'
            }
          }
        });
      });
})
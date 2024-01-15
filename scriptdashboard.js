document.addEventListener("DOMContentLoaded", function () {
    // Graphique de Température
    const ctxTemp = document.getElementById('lineCanvasTemp').getContext('2d');
    lineChartTemp = createLineChart(ctxTemp, labels, datasetsTemperature[0]);

    // Graphique d'Humidité
    const ctxHumidité = document.getElementById('lineCanvasHumidité').getContext('2d');
    lineChartHumidité = createLineChart(ctxHumidité, labels, datasetsHumidite[0]);

    // Graphique de Pression
    const ctxPression = document.getElementById('lineCanvasPression').getContext('2d');
    lineChartPression = createLineChart(ctxPression, labels, datasetsPression[0]);

    // Graphique de la température de la semaine
    const ctxTempWeek = document.getElementById('lineCanvasTempWeek').getContext('2d');
    let lineChartTempWeek;

    // Graphique d'Humidité de la semaine
    const ctxHumiditéWeek = document.getElementById('lineCanvasHumiditéWeek').getContext('2d');
    let lineChartHumiditéWeek;

    // Graphique de Pression de la semaine
    const ctxPressionWeek = document.getElementById('lineCanvasPressionWeek').getContext('2d');
    let lineChartPressionWeek;

     // Utilisez AJAX pour obtenir les données de la semaine
     fetch('semaine.php')
     .then(response => response.json())
     .then(data => {
         const labelsWeek = ["lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche"];

         // Graphique de la température de la semaine
         lineChartTempWeek = createLineChartWeek(ctxTempWeek, labelsWeek, [{
             label: "Température",
             data: JSON.parse(data.temperatureWeek),
             fill: false,
             backgroundColor: "red",
             tension: 0.1
         }]);

         // Graphique d'Humidité de la semaine
         lineChartHumiditéWeek = createLineChartWeek(ctxHumiditéWeek, labelsWeek, [{
             label: "Humidité",
             data: JSON.parse(data.humiditeWeek),
             fill: false,
             backgroundColor: "turquoise",
             tension: 0.1
         }]); 

         // Graphique de Pression de la semaine
         lineChartPressionWeek = createLineChartWeek(ctxPressionWeek, labelsWeek, [{
             label: "Pression",
             data: JSON.parse(data.pressionWeek),
             fill: false,
             backgroundColor: "grey",
             tension: 0.1
         }]); 
     })
     .catch(error => console.error('Erreur lors de la récupération des données:', error));


     function createLineChart(ctx, labels, dataset) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,  
                datasets: [dataset]
            },
            options: {
                responsive: false,
                elements: {
                    point: {
                        pointBorderColor: "#333"
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            color: "#333"
                        },
                        suggestedMin: 0, // pression à changer
                        suggestedMax: 40
                    },
                    x: {
                        ticks: {
                            color: "#333"
                        }
                    }
                }
            }
        });
    }

function createLineChartWeek(ctx, labels, dataset) {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,  
            datasets: dataset
        },
        options: {
            responsive: false,
            elements: {
                point: {
                    pointBorderColor: "#333"
                }
            },
            scales: {
                y: {
                    ticks: {
                        color: "#333"
                    },
                    suggestedMin: 0, // pression à changer
                    suggestedMax: 100
                },
                x: {
                    ticks: {
                        color: "#333"
                    }
                }
            }
        }
    });
}

// Fonction pour basculer entre les jours de la semaine et une seule journée de 24 heures
function toggleTimeFormat() {
    const daysOfWeek = [];
    const hoursOfDay = Array.from({ length: labels.length }, (_, i) => `${i}h`);

    // Sélectionnez le graphique de température
    lineChartTemp.data.labels = timeFormatIsDaysOfWeek ? daysOfWeek : hoursOfDay;

    // Sélectionnez le graphique de taux d'humidité
    lineChartHumidité.data.labels = timeFormatIsDaysOfWeek ? daysOfWeek : hoursOfDay;

    // Sélectionnez le graphique de pression atmosphérique
    lineChartPression.data.labels = timeFormatIsDaysOfWeek ? daysOfWeek : hoursOfDay;

    // Mettez à jour les graphiques
    lineChartTemp.update();
    lineChartHumidité.update();
    lineChartPression.update();
    updateWeekCharts();  // Appel de la nouvelle fonction pour mettre à jour les graphiques de la semaine
    // Inversez l'état
    timeFormatIsDaysOfWeek = !timeFormatIsDaysOfWeek;
}

function updateWeekCharts() {
    // Mettez à jour les graphiques de la semaine
    lineChartTempWeek.update();
    lineChartHumiditéWeek.update();
    lineChartPressionWeek.update();
}

const toggleButton = document.getElementById('toggleButton');
toggleButton.addEventListener('click', toggleTimeFormat);
let timeFormatIsDaysOfWeek = true;  // Variable pour suivre l'état actuel du format de temps
});
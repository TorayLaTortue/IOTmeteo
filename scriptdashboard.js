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
         const labelsWeek = data.dates;
 
         // Graphique de la température de la semaine
         lineChartTempWeek = createLineChartWeek(ctxTempWeek, labelsWeek, [{
             label: "Température",
             data: JSON.parse(data.temperatureWeek),
             fill: false,
             backgroundColor: "red",
             tension: 0.4
         }]);
 
         // Graphique d'Humidité de la semaine
         lineChartHumiditéWeek = createLineChartWeek(ctxHumiditéWeek, labelsWeek, [{
             label: "Humidité",
             data: JSON.parse(data.humiditeWeek),
             fill: false,
             backgroundColor: "turquoise",
             tension: 0.4
         }]); 
 
         // Graphique de Pression de la semaine
         lineChartPressionWeek = createLineChartWeek(ctxPressionWeek, labelsWeek, [{
             label: "Pression",
             data: JSON.parse(data.pressionWeek),
             fill: false,
             backgroundColor: "grey",
             tension: 0.4
         }]); 
     })
     .catch(error => console.error('Erreur lors de la récupération des données:', error));
 

     function createLineChart(ctx, labels, dataset) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: dataset.label,
                    data: dataset.data,
                    fill: dataset.fill,
                    backgroundColor: dataset.backgroundColor,
                    borderColor: 'black', //couleur de la ligne à noir
                    pointRadius: 5, // Taille des points
                    tension: dataset.tension
                }]
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
                            color: "#333",
                            font: {
                                weight: 'bold'
                            }
                        },
                        suggestedMax: 50
                    },
                    x: {
                        ticks: {
                            color: "#333",
                            font: {
                                weight: 'bold'
                            }
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
                datasets: [{
                    label: dataset[0].label,
                    data: dataset[0].data,
                    fill: dataset[0].fill,
                    backgroundColor: dataset[0].backgroundColor,
                    borderColor: 'black', //couleur de la ligne à noir
                    pointRadius: 5, // taille des points
                    tension: dataset[0].tension
                }]
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
                            color: "#333",
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: "#333",
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    }
    
    
const dataByDate = {};  // Utilisez un tableau associatif pour stocker les données filtrées par date

// Pour chaque jour de la semaine, récupérer les données et calculer la moyenne
data.forEach(entry => {
    const date = entry.date;

    // Si la date n'est pas encore présente dans le tableau associatif, ajoutez-la
    if (!dataByDate[date]) {
        dataByDate[date] = [];
    }

    // Filtrer les données pour le jour spécifique et ajouter à la date correspondante dans le tableau associatif
    const filteredData = dataByDate[date].filter(e =>
        isNumeric(e.température) && isNumeric(e.humidité) && isNumeric(e.patmosphérique)
    );

    dataByDate[date].push(entry);
});

// Parcourir le tableau associatif pour calculer les moyennes par date
const dates = Object.keys(dataByDate);
const temperatureWeek = [];
const humiditeWeek = [];
const pressionWeek = [];

dates.forEach(date => {
    const filteredData = dataByDate[date];

    const temperatureMoyenne = filteredData.length > 0 ?
        filteredData.reduce((sum, entry) => sum + parseFloat(entry.température), 0) / filteredData.length : 0;

    const humiditeMoyenne = filteredData.length > 0 ?
        filteredData.reduce((sum, entry) => sum + parseFloat(entry.humidité), 0) / filteredData.length : 0;

    const pressionMoyenne = filteredData.length > 0 ?
        filteredData.reduce((sum, entry) => sum + parseFloat(entry.patmosphérique), 0) / filteredData.length : 0;

    temperatureWeek.push(temperatureMoyenne);
    humiditeWeek.push(humiditeMoyenne);
    pressionWeek.push(pressionMoyenne);
});

// Mettre à jour les graphiques de la semaine avec les données filtrées
lineChartTempWeek.data.labels = dates;
lineChartTempWeek.data.datasets[0].data = temperatureWeek;

lineChartHumiditéWeek.data.labels = dates;
lineChartHumiditéWeek.data.datasets[0].data = humiditeWeek;

lineChartPressionWeek.data.labels = dates;
lineChartPressionWeek.data.datasets[0].data = pressionWeek;

updateWeekCharts();  // Mettez à jour les graphiques de la semaine

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
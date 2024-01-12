
document.addEventListener("DOMContentLoaded", function () {
    // Graphique de Température
    const ctxTemp = document.getElementById('lineCanvasTemp').getContext('2d');
    const lineChartTemp = createLineChart(ctxTemp, labels, datasetsTemperature[0]);
    const ctxHumidité = document.getElementById('lineCanvasHumidité').getContext('2d');
    const lineChartHumidité = createLineChart(ctxHumidité, labels, datasetsHumidite[0]);
    const ctxPression = document.getElementById('lineCanvasPression').getContext('2d');
    const lineChartPression = createLineChart(ctxPression, labels, datasetsPression[0]);

});


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
                    suggestedMin: 0,
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


    

    // Fonction pour basculer entre les jours de la semaine et une seule journée de 24 heures
    function toggleTimeFormat() {
        const daysOfWeek = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
        const hoursOfDay = Array.from({ length: 24 }, (_, i) => `${i}h`);

        // Sélectionnez le graphique de température
        lineChartTemp.data.labels = timeFormatIsDaysOfWeek ? hoursOfDay : daysOfWeek;

        // Sélectionnez le graphique de taux d'humidité
        lineChartHumidité.data.labels = timeFormatIsDaysOfWeek ? hoursOfDay : daysOfWeek;

        // Sélectionnez le graphique de pression atmosphérique
        lineChartPression.data.labels = timeFormatIsDaysOfWeek ? hoursOfDay : daysOfWeek;

        // Mettez à jour les graphiques
        lineChartTemp.update();
        lineChartHumidité.update();
        lineChartPression.update();

        // Inversez l'état
        timeFormatIsDaysOfWeek = !timeFormatIsDaysOfWeek;
    }

    // Ajoutez un gestionnaire d'événements pour le basculement
    const toggleButton = document.getElementById('toggleButton');
    toggleButton.addEventListener('click', toggleTimeFormat);

    let timeFormatIsDaysOfWeek = true;  // Variable pour suivre l'état actuel du format de temps


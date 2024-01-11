document.addEventListener("DOMContentLoaded", function () {
    // Graphique de Température
    const lineCanvasTemp = document.getElementById('lineCanvasTemp');
    const lineChartTemp = new Chart(lineCanvasTemp, {
        type: "line",
        data: {
            labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            datasets: [{
                label: 'Température',
                data: [températureMoyenne],
                fill: false,
                backgroundColor: 'red',
                tension: 0.1
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

    // Graphique de Taux d'humidité
    const lineCanvasHumidité = document.getElementById('lineCanvasHumidité');
    const lineChartHumidité = new Chart(lineCanvasHumidité, {
        type: "line",
        data: {
            labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            datasets: [{
                label: 'Taux Humidité',
                data: [humiditéMoyenne],
                fill: false,
                backgroundColor: 'turquoise',
                tension: 0.1
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
                        color: "#333"
                    },
                    suggestedMin: 0,
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

    // Graphique de Pression Atmosphérique
    const lineCanvasPression = document.getElementById('lineCanvasPression');
    const lineChartPression = new Chart(lineCanvasPression, {
        type: "line",
        data: {
            labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            datasets: [{
                label: 'Pression Atmosphérique',
                data: [pressionMoyenne],
                fill: false,
                backgroundColor: 'grey',
                tension: 0.1
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
                        color: "#333"
                    },
                    suggestedMin: 0,
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
});

document.addEventListener("DOMContentLoaded", function() {
    // Graphique de Température
    const lineCanvasTemp = document.getElementById('lineCanvasTemp');
    const lineChartTemp = new Chart(lineCanvasTemp, {
        type: "line",
        data: {
            labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            datasets: [{
                label: 'Température',
                data: [20, 21, 19, 25, 23, 22, 20],
                fill: false,
                backgroundColor: 'red',
                tension: 0.1
            }]
        },
        options: {
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
    const barCanvasHumidité = document.getElementById('barCanvasHumidité');
    const barChartHumidité = new Chart(barCanvasHumidité, {
        type: "bar",
        data: {
            labels: ["1H", "2H", "3H", "4H", "5H", "6H", "7H", "8H", "9H", "10H", "11H", "MIDI", "13H", "14H", "15H", "16H", "17H", "18H", "19H", "20H", "21H", "22H", "23H", "MINUIT"],
            datasets: [{
                label: 'Taux d\'humidité',
                data: [20, 21, 19, 25, 23, 22, 20],
                backgroundColor: 'red',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique de Pression Atmosphérique
    const barCanvasPression = document.getElementById('barCanvasPression');
    const barChartPression = new Chart(barCanvasPression, {
        type: "bar",
        data: {
            labels: ["1H", "2H", "3H", "4H", "5H", "6H", "7H", "8H", "9H", "10H", "11H", "MIDI", "13H", "14H", "15H", "16H", "17H", "18H", "19H", "20H", "21H", "22H", "23H", "MINUIT"],
            datasets: [{
                label: 'Pression Atmosphérique',
                data: [20, 21, 19, 25, 23, 22, 20],
                backgroundColor: 'red',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

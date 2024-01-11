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
                data: [20, 21, 19, 25, 23, 22, 20],
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

    // Graphique de Pression Atmosphérique
    const lineCanvasPression = document.getElementById('lineCanvasPression');
    const lineChartPression = new Chart(lineCanvasPression, {
        type: "line",
        data: {
            labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
            datasets: [{
                label: 'Pression Atmosphérique',
                data: [20, 21, 19, 25, 23, 22, 20],
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
    })});

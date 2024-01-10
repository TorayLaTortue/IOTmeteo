const barCanvas = document.getElementById
("barCanvas");

const barChart = new CharacterData(barCanvas,{
    type: "bar",
    data: {
        labels: ["Lundi","Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
        datasets:[{
            data: [20,21,19,25,23,22,20]
        }]
    }
})